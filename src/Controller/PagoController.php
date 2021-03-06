<?php


namespace App\Controller;

use App\Entity\Cuota;
use App\Entity\Pago;
use App\Form\PagoType;
use App\Services\DAO\DoctrineFactoryDAO;
use App\Services\SistemaFinancieroService;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Request\ParamFetcherInterface;
use phpDocumentor\Reflection\Types\Mixed_;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use ProxyManager\ProxyGenerator\RemoteObject\PropertyGenerator\AdapterProperty;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\MimeType\FileinfoMimeTypeGuesser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;


/**
 * @RouteResource("Pago")
 */
class PagoController extends FOSRestController
{

    /**
     * @var SistemaFinancieroService
     */
    //Interactúa para obtener las tasas de interes ante cuotas atrasadas
    private $sistemaFinancieroService;

    /**
     * PolizaController constructor.
     * @param SistemaFinancieroService $sistemaFinanciero
     */
    public function __construct(SistemaFinancieroService $sistemaFinanciero)
    {

        $this->sistemaFinancieroService = $sistemaFinanciero;

    }


//CU12: Registro de pago de poliza

    /**
     * Recibe el id de la poliza a pagar.
     * Puede ser solo un arreglo de id, ya que se requiere actualizar las cuotas
     * Retorna un arreglo con las cuotas pendiente de pago y sus montos actualizados (Tipo Cuota)
     *
     * El monto actualizado se calcula como monto + recargosPorMora - bonificacionPagoAdelantado
     *
     * No se guarda en la cuota, se deberia calcular. Esto se calcula en el frontend antes de mostrar los montos actualizados
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @param
     * @return ArrayCollection
     * @throws
     */
    public function getMontoactualizadocuotasAction($idPoliza)
    {

        //Dao de Poliza para obtener el arreglo de cuotas de dicha poliza
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $polizaDAO = DoctrineFactoryDAO::getFactory()->getPolizaDAO($em);

        //Obtiene el arreglo de cuotas de la poliza
        $arregloCuotas = $polizaDAO->getObj($idPoliza)->getListaCuotas();

        //Arreglo que contendra las cuotas sin pagar
        $resultado = new ArrayCollection();

        //Fecha actual
        $now = new DateTime('today');

        foreach ($arregloCuotas as $c) {

            //Verifica que no tiene un pago para agregarla a la lista resultado
            if (is_null($c->getPago())) {

                //Calcula la diferencia entre las fechas actual y de vencimiento de cuota
                $diferencia = $now->diff($c->getFechaVencimiento());
                $dias = (int)($diferencia->format('%R%a'));

                //Dias es un valor negativo si la fecha es anterior a la actual. Indica la cantidad de dias que ya pasaron desde la fecha
                if ($dias < 0) {

                    //Busca la tasa de interes generada por dias atrasados
                    $tasaA = $this->sistemaFinancieroService->obtenerTasadeinteresAnual();
                    $tasaM = $this->sistemaFinancieroService->obtenerTasadeinteresMensual();
                    $tasaD = $this->sistemaFinancieroService->obtenerTasadeinteresDiaria();

                    //Calculo de regargos. Porcentaje del monto original segun tasa de interes por los días de atraso.
                    //La tasa de interes es por dia (0.01 es fijo)
                    $a = (int)($dias/365);
                    $m = (int)(($dias%365)/30);
                    $d = (int)(($dias%365)%30);

                    $recargo = ($c->getMonto())*($tasaA*$a + $tasaM*$m + $tasaD*$d)*(-1);

                    //Actualiza el valor de recargos por el calculado y coloca el valor de bonificacion en cero.
                    $c->setRecargos($recargo);
                    $c->setBonificacionPagoAdelantado(0);

                    //Agrega cuota modificada a resultado final. La modificacion no se almacena en la BD hasta que se invoque al postPago
                    $resultado->add($c);
                } else {

                    //Dias es un valor positivo si la fecha todavia no llegó. Indica la cantidad de dias que faltan para que llegue dicha fecha
                    if ($dias > 0) {

                        //Valor fijo de descuento
                        $descuento = 0.001;

                        //Calculo de bonificacion por pago adelantado. Descuento de 0.01 fijo
                        //El -1 es porque dias es negativo si llega aquí
                        $bonificacion = $c->getMonto() * $descuento * $dias;

                        //Set de recargos en cero y de bonificacion por pago adelantado en valor calculado
                        $c->setRecargos(0);
                        $c->setBonificacionPagoAdelantado($bonificacion);

                        //Agrega cuota modificada a resultado final
                        $resultado->add($c);
                    } else {

                        //Si lo paga en la misma fecha de vencimiento no hay recargos ni bonificación
                        $c->setRecargos(0);
                        $c->setBonificacionPagoAdelantado(0);
                    }
                }
            }
        }

        return $resultado;

    }



    /**
     * @param Request $request
     * @return object|string
     *
     * @View(serializerEnableMaxDepthChecks=true)
     */

    public function postAction(Request $request)
    {

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $cuotaDAO = DoctrineFactoryDAO::getFactory()->getCuotaDAO($em);
        $pagoDAO = DoctrineFactoryDAO::getFactory()->getPagoDAO($em);

        //Procesa el request
        $pago = new Pago();
        $objForm = $this->createForm(PagoType::class, $pago, ['em' => $em]);
        $objForm->handleRequest($request);

        $listaCuotas = new ArrayCollection();

        if ($objForm->isSubmitted() && $objForm->isValid()) {

            //$cuotas = $objForm->get('lista_cuotas')->getData();
            $cuotas = $pago->getListaCuotas();

            foreach ($cuotas as $cuota) {

                //Busca la cuota que hay que actualizar
                $c = $cuotaDAO->getObj($cuota->getId());

                //Los valores que se actualizan son los siguientes:
                $c->setBonificacionPagoAdelantado($cuota->getBonificacionPagoAdelantado());
                $c->setRecargos($cuota->getRecargos());
                $c->setPago($pago);

                $listaCuotas->add($c);


            }

            $pago->setListaCuotas($listaCuotas);
            $pagoDAO->save($pago);

            if(is_null($this->actualizarEstadoPoliza($pago->getListaCuotas()->first()->getPoliza()->getNroPoliza()))){

                return null;

            }

            //return $pago;
            return $this->actualizarEstadoPoliza($pago->getListaCuotas()->first()->getPoliza()->getNroPoliza());
        }

        return $objForm;

    }

    /**
     * @param $idPoliza
     * @return object|string|null
     * @throws
     */
    private function actualizarEstadoPoliza($idPoliza){

        //DAO
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $polizaDAO = DoctrineFactoryDAO::getFactory()->getPolizaDAO($em);
        $estadoPolizaDAO = DoctrineFactoryDAO::getFactory()->getEnumEstadoPolizaDAO($em);

        //Fecha de hoy
        $today = new DateTime('today');

        //Obtengo la poliza para modificar
        $poliza = $polizaDAO->getObj($idPoliza);
        if (is_null($poliza)) {
            return $poliza;
        }

        $arranca = $poliza->getEstadoPoliza()->getId();
        //Obtiene el listado de cuotas
        $cuotas = $poliza->getListaCuotas();

        foreach ($poliza->getListaCuotas() as $c) {

            //Encuentra la primera cuota pendiente de pago.
            if (is_null($c->getPago())) {

                //Calcula la diferencia en días entre la fecha de hoy y la de vencimiento
                $diferencia = $today->diff($c->getFechaVencimiento());
                $dias = (int)($diferencia->format('%R%a'));

                //Dias es un valor negativo si la fecha es anterior a la de hoy. Indica la cantidad de dias que ya pasaron desde la fecha
                if ($dias < 0) {
                    //Es deudor.

                    //Si la poliza tiene estado Vigente, entonces pasa a estado Suspendida.
                    //Vigente = 1
                    //Suspendida = 2
                    if ($poliza->getEstadoPoliza()->getId() == 1) {

                        $poliza->setEstadoPoliza($estadoPolizaDAO->getObj(2));

                        $polizaDAO->save($poliza);

                        return $poliza;
                        //return "pasa a suspendida";
                    }
                    //Si poliza tiene estado suspendida, entonces no hace nada. Retorna
                    //return "queda igual";
                    return $poliza;

                }
                else {

                    //No es deudor. Asume que si la fecha de vencimiento es la de hoy, la poliza todavia sigue vigente hasta que pase la fecha. O pasa a vigente si estaba suspendida
                    //Si la poliza tiene estado Suspendida, entonces pasa a estado Vigente.
                    //Vigente = 1
                    //Suspendida = 2

                    if ($poliza->getEstadoPoliza()->getId() == 2) {

                        $poliza->setEstadoPoliza($estadoPolizaDAO->getObj(1));

                        $polizaDAO->save($poliza);

                        return $poliza;
                        //return "pasa a vigente";
                    }
                    //Si poliza tiene estado Vigente, entonces no hace nada. Retorna
                    return $poliza;
                    //return "queda igual 2";
                }

            }

        }

        //Si llega aqui, es porque no tiene cuotas pendiente de pago, por lo que debe cambiar de estado en caso de ser necesario.
        // Como no es deudor, ya que no posee pagos pendientes, solo queda pasarlo a Vigente o a Finalizada

        $diferencia = $today->diff($poliza->getFechaFinVigencia());
        $dias = (int)($diferencia->format('%R%a'));

        if($dias<0){

            //Fecha de vigencia ya terminó, pasa a estado finalizada
            $poliza->setEstadoPoliza($estadoPolizaDAO->getObj(3));

            $polizaDAO->save($poliza);

            return $poliza;

        }


        //Si estaba suspendida, pasa a vigente hasta que finalice su vigencia
        if ($poliza->getEstadoPoliza()->getId() == 2) {


            $poliza->setEstadoPoliza($estadoPolizaDAO->getObj(1));
            $polizaDAO->save($poliza);

            return $poliza;

        }

        return $poliza;

    }

}