<?php

namespace App\Controller;

//Entidades
use App\Entity\AjustesPorKm;
use App\Entity\Cliente;
use App\Entity\EnumEstadoPoliza;
use App\Entity\FactoresCaracteristicas;
use App\Entity\Localidad;
use App\Entity\MedidasSeguridad;
use App\Entity\Modelo;
use App\Entity\SiniestrosFc;
use App\Entity\TipoCobertura;
use App\Entity\Cuota;
use App\Entity\Poliza;

//FormType
use App\Form\PremioDescType;
use App\Form\PolizaType;

//DAO
use App\Services\DAO\AjustesKMDAO;
use App\Services\DAO\ClienteDAO;
use App\Services\DAO\DoctrineFactoryDAO;
use App\Services\DAO\EnumSexoDAO;
use App\Services\DAO\EnumEstadoCivilDAO;
use App\Services\DAO\EnumEstadoPolizaDAO;
use App\Services\DAO\FactoresCDAO;
use App\Services\DAO\EnumFormaPagoDAO;
use App\Services\DAO\LocalidadDAO;
use App\Services\DAO\MedidasSeguridadDAO;
use App\Services\DAO\ModeloDAO;
use App\Services\DAO\PolizaDAO;
use App\Services\DAO\SiniestrosDAO;
use App\Services\DAO\TipoCoberturaDAO;

//Otros
use App\Services\SistemaFinancieroService;

//FOS-Route
use DateInterval;
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
 * @RouteResource("Poliza")
 */

class PolizaController extends FOSRestController{

    /**
     * @var SistemaFinancieroService
     */
    private $sistemaFinancieroService;
    /*private $polizaDAO;
    private $clienteDAO;
    private $estadoPolizaDAO;
    private $ajusteKMDAO;
    private $formaPagoDAO;
    private $localidadDAO;
    private $medidasSeguridadDAO;
    private $modeloDAO;
    private $tipoCoberturaDAO;
    private $siniestrosDAO;
    private $factoresCDAO;
    private $enumSexoDAO;
    private $enumEstadoCivil;
    */

    /**
     * PolizaController constructor.
     * @param SistemaFinancieroService $sistemaFinanciero
     *
     */
    public function __construct(SistemaFinancieroService $sistemaFinanciero){

        $this->sistemaFinancieroService = $sistemaFinanciero;



    }


    /**
     * Retorna una poliza con nroPoliza = id. Busqueda de Poliza por Nro. No requiere que sea vigente
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @param int $id
     * @return mixed
     */
    //@View(serializerEnableMaxDepthChecks=true) sirve para serializar los datos y retornarlos en formato json.
    //Retorna solo los valores de poliza que tienen en tag @Expose.
    public function getAction(int $id){

        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();
        $polizaDAO = new PolizaDAO($em);
        return $polizaDAO->getObj($id);

    }


    /**
     * @param Request $request
     * @View(serializerEnableMaxDepthChecks=true)
     * @return null
     * @throws
     */
    public function postAction(Request $request){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $polizaDAO = DoctrineFactoryDAO::getFactory()->getPolizaDAO($em);
        $clienteDAO = DoctrineFactoryDAO::getFactory()->getClienteDAO($em);
        $estadoPolizaDAO = DoctrineFactoryDAO::getFactory()->getEnumEstadoPolizaDAO($em);
        $ajusteKMDAO = DoctrineFactoryDAO::getFactory()->getAjustesKMDAO($em);
        $formaPagoDAO = DoctrineFactoryDAO::getFactory()->getEnumFormaPagoDAO($em);
        $localidadDAO = DoctrineFactoryDAO::getFactory()->getLocalidadDAO($em);
        $medidasSeguridadDAO = DoctrineFactoryDAO::getFactory()->getMedidasSeguridadDAO($em);
        $modeloDAO = DoctrineFactoryDAO::getFactory()->getModeloDAO($em);
        $tipoCoberturaDAO = DoctrineFactoryDAO::getFactory()->getTipoCoberturaDAO($em);
        $siniestrosDAO = DoctrineFactoryDAO::getFactory()->getSiniestrosDAO($em);
        $factoresCDAO = DoctrineFactoryDAO::getFactory()->getFactoresCDAO($em);
        $enumSexoDAO = DoctrineFactoryDAO::getFactory()->getEnumSexoDAO($em);
        $enumEstadoCivil = DoctrineFactoryDAO::getFactory()->getEnumEstadoCivilDAO($em);

        $poliza = new Poliza();

        $objForm = $this->createForm(PolizaType::class, $poliza, ['em'=> $em]);
        $objForm->handleRequest($request);

        if ($objForm->isSubmitted() && $objForm->isValid()) {

            $nroPoliza = $poliza->getNroPoliza();
            $p = $polizaDAO->getObj($nroPoliza);

            //Consultar.
            /*if($p){

                $r = new Response("La Poliza ya Existe");
                $r->setStatusCode(529);
                return $r;
            }*/

            //TODO Consultar. Entra al if primero si nro de poliza es nulo, el error salta luego de procesar todo (en el persist).
            /*if($poliza->getNroPoliza()==null){

                    $r = new Response("Poliza: Nro Poliza Nulo");
                    $r->setStatusCode(500);
                    return $r;
            }*/

             //Agrega Cliente a Poliza.
                $cliente = $objForm->get('cliente')->getData();
                $c = $clienteDAO->getObj($cliente->getId());
                $poliza->setCliente($c);


             //Agrega valores de poliza
                /*$poliza ->setSumaAsegurada($objForm->get('sumaAsegurada')->getData());
                $poliza ->setPremio($objForm->get('premio')->getData());
                $poliza->setImportePorDescuento($objForm->get('importePorDescuento')->getData());
                $poliza->setMontoTotalAAbonar($objForm->get('montoTotalAAbonar')->getData());
                */

             //Siempre es "GENERADA" al crearse la poliza. Por eso el 4.
                $estadoPoliza = $estadoPolizaDAO->getObj(4);
                $poliza->setEstadopoliza($estadoPoliza);

             //Este se obtiene desde el DAO basandose en los KManio ingresados desde el frontend
                $ajusteKM = $ajusteKMDAO->getObj($poliza->getKmAnio());
                $poliza->setAjusteskm($ajusteKM);
                //$poliza ->setKmAnio($objForm->get('kmAnio')->getData());


              //Agrega las fechas. Se calculan en el front
                /*$poliza ->setFechaFinVigencia($objForm->get('fechaFinVigencia')->getData());
                $poliza ->setFechaInicioVigencia($objForm->get('fechaInicioVigencia')->getData());
                $poliza->setUltimoDiaPago($objForm->get('ultimoDiaPago')->getData());
                */

            //Forma de pago.
                $formaPago = $objForm->get('formapago')->getData();
                $fp = $formaPagoDAO -> getObj($formaPago->getId());
                $poliza->setFormapago($fp);

            //Localidad (Domicilio de Riesgo)
                $localidad=$objForm->get('localidad')->getData();
                $l = $localidadDAO->getObj($localidad->getId());
                $poliza -> setLocalidad($l);


            //Vehiculo
                $vehiculo = $objForm->get('vehiculo')->getData();
                $medidas = new ArrayCollection();

                foreach($vehiculo->getListaMedidas() as $medida){
                    $medidas->add($medidasSeguridadDAO->getObj($medida->getId()));
                }

                $vehiculo->setModelo($modeloDAO->getObj($vehiculo->getModelo()->getId()));
                $vehiculo->setListaMedidas($medidas);


                $poliza->setVehiculo($vehiculo);

              //Tipo Cobertura
                $tipoCob = $objForm->get('tipo_cobertura')->getData();
                $tc = $tipoCoberturaDAO->getObj($tipoCob->getId());
                $poliza -> setTipoCobertura($tc);

             //SiniestrosFC
                $siniestros = $objForm->get('siniestro_FC')->getData();
                $s = $siniestrosDAO->getObj($siniestros->getId());
                $poliza -> setSiniestroFC($s);


             //Hijos
                 if (is_array($objForm->get('lista_hijos')->getData()) || is_object($objForm->get('lista_hijos')->getData())) {
                     $poliza->setListaHijos($objForm->get('lista_hijos')->getData());
                     foreach ($poliza->getListaHijos() as $hijo) {
                         $hijo->setPoliza($poliza);
                         $hijo->setEnumSexo($enumSexoDAO->getObj($hijo->getEnumSexo()->getId()));
                         $hijo->setEstadoCivil($enumEstadoCivil->getObj($hijo->getEstadoCivil()->getId()));
                     }
                 }

             //Cuotas
                if (is_array($objForm->get('lista_cuotas')->getData()) || is_object($objForm->get('lista_cuotas')->getData())) {
                    /** @var Cuota $cuota */
                    $poliza->setListaCuotas($objForm->get('lista_cuotas')->getData());
                    foreach ($poliza->getListaCuotas() as $cuota) {
                        $cuota->setPoliza($poliza);
                    }
                }

             //Factores de Caracteristicas es siempre el mismo
                $factoresCaracteristicas= $factoresCDAO->getObj(1);
                $poliza->setFactores($factoresCaracteristicas);


                $polizaDAO->save($poliza);

                return $poliza;

            }

        return $objForm;


    }


    /**
     * @param Request $request
     * @View(serializerEnableMaxDepthChecks=true)
     * @return mixed
     * @throws
     */
    //TODO Mismo problema que Busqueda Cliente
    public function getCalculopremiodescAction(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();


        $clienteDAO = new ClienteDAO($em);
        $estadoPolizaDAO = new EnumEstadoPolizaDAO($em);
        $ajusteKMDAO = new AjustesKMDAO($em);
        $localidadDAO = new LocalidadDAO($em);
        $medidasSeguridadDAO = new MedidasSeguridadDAO($em);
        $modeloDAO = new ModeloDAO($em);
        $tipoCoberturaDAO = new TipoCoberturaDAO($em);
        $siniestrosDAO = new SiniestrosDAO($em);
        $factoresCDAO = new FactoresCDAO($em);


        $objForm = $this->createForm(PremioDescType::class, null, ['em'=> $em]);
        //$objForm->handleRequest($request);
        $objForm->submit($request->get($objForm->getData()), false);

        if ($objForm->isSubmitted()) {
            if($objForm->isValid()) {
                //Porcentaje valor según Cobertura
                $idCobertura = $objForm->get('tipoCobertura')->getData();
                if ($idCobertura == null) {
                    return new JsonResponse("tipocobertura nulo");

                }

                $ajusteCobertura = $tipoCoberturaDAO->getObj($idCobertura)->getValor();

                //Porcentaje por Domicilio de Riesgo (Localidad)
                $ajusteDomicilio = $localidadDAO->getObj($objForm->get("localidad")->getData())->getValor();


                //Porcentaje por Modelo de Vehiculo
                $ajusteModelo = $modeloDAO->getObj($objForm->get("modelo")->getData())->getValor();

                //Porcentaje por Km realizado
                $ajusteKm=$ajusteKMDAO->getObj($objForm->get("kmAnio")->getData())->getValor();

                //Porcentaje por cada medida de seguridad seleccionada. El porcentaje final es la suma de los porcentajes
                $ajusteMedidas = 0;
                if (is_array($objForm->get('medidasSeguridad')->getData()) || is_object($objForm->get('medidasSeguridad')->getData())) {

                    foreach ($objForm->get('medidasSeguridad')->getData() as $medida) {

                        $ajusteMedidas += $medidasSeguridadDAO->getObj($medida)->getValor();

                    }
                }

                //Porcentaje por cant de siniestros.
                $ajusteSiniestro = $siniestrosDAO->getObj($objForm->get("cantSiniestros")->getData())->getValor();

                //Porcentaje por cant de hijos. Requiere que se envíe la cantidad de hijos nomás. El valor se obtiene por defecto con el mismo Id
                $fc = $factoresCDAO->getObj(0);
                $ajusteCantHijos = ($fc->getAjustePorHijo()) * ($objForm->get("cantHijos")->getData());

                //Calculo de Prima
                //Prima Individual =  suma asegurada x tasa de riesgo
                //Prima = Prima individual x cantidad de pólizas
                $sumaAsegurada = $objForm->get("sumaAsegurada")->getData();
                $prima = $sumaAsegurada * $ajusteCobertura;
                $prima += $prima * ($ajusteMedidas + $ajusteCantHijos + $ajusteDomicilio + $ajusteKm + $ajusteModelo + $ajusteSiniestro);

                //Derechos de Emision
                //Valor Fijo. Depende de la aseguradora y sus gastos.
                $derechosEmision = 100;

                //Premio
                $premio = $prima + $derechosEmision;

                //Descuentos
                //Obtener cantidad de vehiculos vigentes por cliente. TODO Cantidad vehiculos vigentes
                $cliente = $clienteDAO->getObj($objForm->get("cliente")->getData());
                //Estado vigente de poliza
                $estadoPoliza = $estadoPolizaDAO->getObj(1);

                //TODO Programar findCantVehiculos en ClienteDao
                $unidades = 0;
                //$unidades = $this->clienteDAO->findCantVehiculos($cliente, $estadoPoliza);
                $descuentoPorUnidad = $fc->getDescuentoPorUnidadAdicional();
                $descuento = $descuentoPorUnidad * $unidades;

                //Tipo de pago Semestral. En caso de ser Semestral hay que contactar con un sistema de gestión financiero (controller?)
                //Obtiene un valor fijo, pero es necesario simularlo
                $tipoPago = 1; //o 2, no recuerdo
                if ($tipoPago == 1) {
                    //obtener tasa de descuento desde Sistema Financiero
                    $tasaDescuento = $this->sistemaFinancieroService->obtenerTasaDescuentoPagoSemestral();
                    $descuento += $tasaDescuento;
                }

                //Calcular Monto Total para Poliza
                $montoTotal = $premio - $descuento;

                $response = new JsonResponse();
                $response->setData(['premio' => $premio]);
                $response->setData(['descuento' => $descuento]);
                $response->setData(['montoTotal' => $montoTotal]);

                return $response;
            }
            else{
                $response= new JsonResponse("No es valido");
                $response->setData($request);
                return $response;
            }
        }

        $response= new JsonResponse("No submitted");
        $response->setData($request);
        return $response;
    }


    /**
     * Calculo nro Poliza. Parametro: id de cliente
     *
     * @param $cliente
     * @View(serializerEnableMaxDepthChecks=true)
     * @return mixed
     */
    public function getCalculonropolizaAction($cliente){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $polizaDAO = new PolizaDAO($em);
        $estadoPolizaDAO = new EnumEstadoPolizaDAO($em);

        $c = $estadoPolizaDAO->getObj($cliente);
        $cantPoliza = $polizaDAO->countObj($c);

        //TODO Falta validar si el numero de poliza es mayor a 99 para el cliente
        return 8888*10000000+$c->getId()*100+$cantPoliza+1;

    }


    /**
     * Verifica si chasis tiene una poliza vigente o no. Retorna true si EXISTE POLIZA ACTIVA con ese chasis
     * @View(serializerEnableMaxDepthChecks=true)
     * @param string $chasis
     * @return bool
     */
    public function getChasispolizaactivaAction($chasis){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $polizaDAO = new PolizaDAO($em);
        $estadoPolizaDAO = new EnumEstadoPolizaDAO($em);

        //Estado Vigente/Activa
        $estado = $estadoPolizaDAO->getObj(1);

        $cant = $polizaDAO->findVehiculoActivo("chasis", $chasis, $estado);

        if($cant==0){

            return false;
        }
        else{
            return true;
        }

    }

    /**
     * Verifica si motor tiene una poliza vigente o no. Retorna true si EXISTE POLIZA ACTIVA con ese motor
     * @View(serializerEnableMaxDepthChecks=true)
     * @param string $motor
     * @return bool
     */
    public function getMotorpolizaactivaAction($motor){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $polizaDAO = new PolizaDAO($em);
        $estadoPolizaDAO = new EnumEstadoPolizaDAO($em);

        //Estado Vigente/Activa
        $estado = $estadoPolizaDAO->getObj(1);

        $cant = $polizaDAO->findVehiculoActivo("motor", $motor, $estado);

        if($cant==0 || $cant == null){

            return false;
        }
        else{
            return true;
        }

    }

    /**
     * Verifica si patente tiene una poliza vigente o no. Retorna true si EXISTE POLIZA ACTIVA con esa patente
     * @View(serializerEnableMaxDepthChecks=true)
     * @param string $patente
     * @return bool
     */
    public function getPatentepolizaactivaAction($patente){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $polizaDAO = new PolizaDAO($em);
        $estadoPolizaDAO = new EnumEstadoPolizaDAO($em);

        //Estado Vigente/Activa
        $estado = $estadoPolizaDAO->getObj(1);
        $cant = $polizaDAO->findVehiculoActivo("patente", $patente, $estado);

        if($cant==0 || $cant == null){

            return false;
        }
        else{
            return true;
        }

    }


    /**
     * Calcula fecha de inicio de vigencia. Enunciado dice que se ingresa por actor, no es necesario este metodo
     * Ver tema de validaciones (fecha menor a la actual)
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     */
    public function getFechainiciovigenciaAction(){

        $now   = new DateTime();

        //return $now;
        $now->format( 'Y/m/d' );

        //$now->modify("+6 months");
        $now->modify("+1 day");
        return $now->format( 'Y/m/d' );
    }


    /**
     * Calcula fecha fin de vigencia
     * @View(serializerEnableMaxDepthChecks=true)
     *
    */
    public function getFechafinvigenciaAction(){

        $now   = new DateTime();

        //return $now;
         $now->format( 'Y/m/d' );
         $now->modify("+1 day");

         $now->modify("+6 months");
          //$now->modify("+1 week");
         return $now->format( 'Y/m/d' );

    }

    /**
     *
     * Calcula fecha ultimo pago. Fecha anterior al dia de entrada en vigencia, o sea, la fecha actual
     * @View(serializerEnableMaxDepthChecks=true)
     *
     */
    public function getFechaultimopagoAction(){

        $now   = new DateTime();

        //return $now;

        return $now->format( 'Y/m/d' );

    }

    /**
     * Problema con esto
     * @View(serializerEnableMaxDepthChecks=true)
     * @param $montoTotal
     * @return ArrayCollection
     * @throws
     */
    public function getCalculocuotasAction($montoTotal){

        $i=2;
        $cuotas = new ArrayCollection();
        $cuota = new Cuota();
        $cuota->setNumCuota(1);
        $cuota->setMonto($montoTotal/6);

        $fecha = new DateTime();
        $cuota->setFechaVencimiento($fecha);
        $cuotas->add($cuota);

        //Crea con fecha actual
        while($i<=6) {

            $cuota = new Cuota();
            $cuota->setNumCuota($i);
            $cuota->setMonto($montoTotal/6);

            $fecha = new DateTime(''.$fecha->format('Y-m-d'));

            $fecha->modify('+30 days');
            $cuota->setFechaVencimiento($fecha);
            $cuotas->add($cuota);

            $i++;
            //$fecha->add(new DateInterval('P1M'));

        }
        return $cuotas;
    }


}