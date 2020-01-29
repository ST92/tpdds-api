<?php


namespace App\Controller;

use App\Entity\Cuota;
use App\Entity\Pago;
use App\Form\PagoType;
use App\Services\DAO\CuotaDAO;
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
class PagoController extends FOSRestController{

    /**
     * @var SistemaFinancieroService
     */
    //Interactúa para obtener las tasas de interes ante cuotas atrasadas
    private $sistemaFinancieroService;

    /**
     * PolizaController constructor.
     * @param SistemaFinancieroService $sistemaFinanciero
     */
    public function __construct(SistemaFinancieroService $sistemaFinanciero){

        $this->sistemaFinancieroService = $sistemaFinanciero;

    }




    /**
     * @param $fecha
     * @return string
     * @throws
     * @View(serializerEnableMaxDepthChecks=true)
     *
     */
    public function getPruebafechasAction($fecha){

        $f = new DateTime($fecha);
        //La clave esta en today en lugar de now
        $now = new DateTime('today');

        $diferencia = $now->diff($f);

        //return $diferencia->format('%y-%m-%d');
        //Al parecer este devuelve bien la diferencia en dias.
        return (int)$diferencia->format('%R%a');

    }


//CU12: Registro de pago de poliza

    /**
     * Recibe el id de la poliza a pagar.
     * Puede ser solo un arreglo de id, ya que se requiere actualizar las cuotas
     * Retorna un arreglo con las cuotas pendiente de pago y sus montos actualizados (Tipo Cuota)
     *
     * El monto actualizado se calcula como monto + recargosPorMora - bonificacionPagoAdelantado
     *
     * No se guarda en la cuota, se deberia calcular. TODO Consultar esto!
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @param
     * @return ArrayCollection
     * @throws
     */
    //TODO Consultar sobre los valores de descuento y de tasa de interés
    public function getMontoactualizadocuotasAction($idPoliza){

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

        foreach ($arregloCuotas as $c){

            //Verifica que no tiene un pago para agregarla a la lista resultado
            if(is_null($c->getPago())){

                //Calcula la diferencia entre las fechas actual y de vencimiento de cuota
                $diferencia = $now->diff($c->getFechaVencimiento());
                $dias = (int)($diferencia->format('%R%a'));

                //Dias es un valor negativo si la fecha es anterior a la actual. Indica la cantidad de dias que ya pasaron desde la fecha
                if($dias<0){

                    //Busca la tasa de interes generada por dias atrasados
                    $tasa = $this->sistemaFinancieroService->obtenerTasadeinteres();


                    //Calculo de regargos. Porcentaje del monto original segun tasa de interes por los días de atraso.
                    //La tasa de interes es por dia (0.01 es fijo)
                    $recargo = $c->getMonto()*$tasa*$dias*-1;

                    //Actualiza el valor de recargos por el calculado y coloca el valor de bonificacion en cero.
                    $c->setRecargos($recargo);
                    $c->setBonificacionPagoAdelantado(0);

                    //Agrega cuota modificada a resultado final. La modificacion no se almacena en la BD hasta que se invoque al postPago
                    $resultado->add($c);
                }
                else{

                    //Dias es un valor positivo si la fecha todavia no llegó. Indica la cantidad de dias que faltan para que llegue dicha fecha
                    if($dias>0){

                        //Valor fijo de descuento
                        $descuento = 0.001;

                        //Calculo de bonificacion por pago adelantado. Descuento de 0.01 fijo
                        //El -1 es porque dias es negativo si llega aquí
                        $bonificacion = $c->getMonto()*$descuento*$dias;

                        //Set de recargos en cero y de bonificacion por pago adelantado en valor calculado
                        $c->setRecargos(0);
                        $c->setBonificacionPagoAdelantado($bonificacion);

                        //Agrega cuota modificada a resultado final
                        $resultado->add($c);
                    }
                    else{

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
     * Recibe arreglo de cuotas seleccionadas a pagar con sus valores actualizados
     * Retorna el monto total a pagar segun las cuotas seleccionadas
     */
    public function getImportetotalapagarAction(){

    }


    /**
     * Recibe el monto total ingresado por el operador y el monto total a pagar calculado anteriormente
     * Retorna la diferencia entre ambos.
     * No se si es necesario este metodo
     */
    public function getcalculovueltoAction(){

    }


    /**
     * @param Request $request
     * @return Pago|FormInterface
     *
     * @View(serializerEnableMaxDepthChecks=true)
     */
    //TODO Si queda tiempo, agregar el usuario que realizó la operación a Pago. De todas formas, no era necesario
    //Si no anda, seguramente es a causa de PagoType y el argumento lista_cuotas
    public function postAction(Request $request){

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

            foreach ($cuotas as $cuota){

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

            return $pago;

        }

        return $objForm;

    }


    //Por ultimo, se debe invocar al metodo getActualizarpoliza declarado en PolizaController

}