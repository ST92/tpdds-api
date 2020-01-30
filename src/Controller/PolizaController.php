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
use App\Entity\Pago;
use App\Entity\SiniestrosFc;
use App\Entity\TipoCobertura;
use App\Entity\Cuota;
use App\Entity\Poliza;

//FormType
use App\Form\PremioDescType;
use App\Form\PolizaType;

//DAO
use App\Services\DAO\DoctrineFactoryDAO;

//Otros
use App\Services\SistemaFinancieroService;

//FOS-Route
use App\Services\ValoresAutomoviles;
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



 //CU1. Alta de Poliza.

    /**
     * Retorna la suma asegurada para los vehiculos. Siempre retorna el mismo valor
     *
     * @return int
     */
    public function getSumaaseguradaAction(){

        return ValoresAutomoviles::getSumaAsegurada();

    }

    /**
     * Verifica si la fecha de nacimiento es mayor a 18 años y menor a 30 respecto de la actual
     * $fechaNacimiento -> AAAA-MM-DD
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @param $fechaNacimiento
     * @return bool
     * @throws
     */
    public function getValidacionfechanacimientoAction($fechaNacimiento){

        $now = new DateTime();
        $fecha= new DateTime($fechaNacimiento);

        $edad = date_diff($now, $fecha);

        $edad = (int)($edad->format('%Y'));
        if($edad>17 && $edad<31){
            return true;
        }

        return false;
    }


    /**
     * Verifica si chasis tiene una poliza vigente o no. Retorna true si EXISTE POLIZA ACTIVA con ese chasis
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @param string $chasis
     * @return bool
     */
    //TODO Consultar que ocurre si hay una poliza está en estado GENERADA y tiene el mismo chasis
    public function getValidacionchasisAction($chasis){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $polizaDAO = DoctrineFactoryDAO::getFactory()->getPolizaDAO($em);
        $estadoPolizaDAO = DoctrineFactoryDAO::getFactory()->getEnumEstadoPolizaDAO($em);

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
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @param string $motor
     * @return bool
     */
    //TODO Consultar que ocurre si hay una poliza está en estado GENERADA y tiene el mismo motor
    public function getValidacionmotorAction($motor){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $polizaDAO = DoctrineFactoryDAO::getFactory()->getPolizaDAO($em);
        $estadoPolizaDAO = DoctrineFactoryDAO::getFactory()->getEnumEstadoPolizaDAO($em);

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
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @param string $patente
     * @return bool
     */
    //TODO Consultar que ocurre si hay una poliza está en estado GENERADA y tiene la misma patente
    public function getValidacionpatenteAction($patente){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $polizaDAO = DoctrineFactoryDAO::getFactory()->getPolizaDAO($em);
        $estadoPolizaDAO = DoctrineFactoryDAO::getFactory()->getEnumEstadoPolizaDAO($em);

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
     * Verifica si el vehiculo tiene más de 10 años. De ser asi, solo debería mostrarse la opcion Responsabilidad Civil como tipo de cobertura
     * Retorna TRUE si tiene más de 10 años
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param $anioVehiculo
     * @return bool
     *
     */
    public function getValidacionaniosvehiculoAction($anioVehiculo){

        $now = date('Y');
        $now = (int)$now;

        if($now - $anioVehiculo > 10){
            return true;
        }

        return false;
    }


    /**
     * Verifica que la fecha de inicio de vigencia ingresada no sea menor a la fecha siguiente a la actual y mayor a 1 mes de la fecha actual
     * Retorna TRUE si la fecha es valida
     *
     * //TODO Si faltan menos de 24 horas para la siguiente fecha a la actual, el if no lo toma como fecha valida salvo que ponga >=0, pero aceptaría la fecha de hoy
     * @View(serializerEnableMaxDepthChecks=true)
     * @param $fechaInicio
     * @return
     * @throws
     */
    public function getValidacionfechainicioAction($fechaInicio){

        $now = new DateTime('today');
        $fecha= new DateTime($fechaInicio);

        $dias=$now->diff($fecha);

        //Diferencia en días
        $diferencia = (int)($dias->format('%R%a'));

        //Si la diferencia es mayor a cero, es decir, la fecha es mayor que la de hoy
        if($diferencia>0) {

            //Si la diferencia es menor a 31, la fecha está dentro de los 30 días. Por lo que sería válida
            if((int)$dias->format('%R%a')<31){

                return true;
            }
            else{
                return false;
            }
        }

        return $diferencia;
    }



//CU16. Calculo de Premio, Derechos de Emision y Descuentos.

    /**
     * Retorna Premio, Monto Total y Descuento
     *
     * Debe recibir en el request: lo que está en PremioDescType a pesar de que no se usen.
     * No hay validacion del Request ya que solo retorna valores fijos.
     *
     * @param Request $request
     * @View(serializerEnableMaxDepthChecks=true)
     * @return mixed
     * @throws
     */
    //TODO Consultar respecto a que hacer con los derechosDeEmision. En teoria se puede calcular despues en base a los valores para el ajuste y los historiales
    //CU16 lo retorna, pero en diagrama, Poliza no tiene el atributo derechosDeEmision
    public function getCalculopremiodescAction(Request $request){

        //Prima = precio del seguro
        //Premio = Prima mas ajustes sobre dicha prima.
        //Descuentos = no se si es porcentaje o es una suma.

        $premio = 100000;
        $descuento = 0.10;
        $derechosDeEmision=30000; //por ahora asumo que es un valor que se le suma a la prima para obtener el premio

        $response = new JsonResponse();
        $response->setData(['premio' => $premio, 'descuento' => $descuento,'derechos_de_emision' => $derechosDeEmision]);

        return $response;

    }

    /**
     * Se encarga de calcular el monto total a abonar dado el premio y los descuentos retornados por el cu16
     */
    //TODO Ver si es necesario. Basicamente es operación bastante sencilla. Considerar realizarlo en el metodo anterior
    public function getMontototalAction(){

    }

//CU1. Alta Poliza

    /**
     * Calcula fecha fin de vigencia. Todas las polizas duran 6 meses como máximo
     * Prueba realizada con formato de fechaInicioVigencia = YYYY-MM-DD
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @param $fechaInicioVigencia
     * @return string
     * @throws
     *
     */
    public function getFechafinvigenciaAction($fechaInicioVigencia){

        $now = new DateTime($fechaInicioVigencia);

        $now->modify("+1 day");
        $now->modify("+6 months");

        return $now->format( 'Y/m/d' );

    }


    /**
     * Armado de lista de cuotas.
     *
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param $montoTotal //Para calcular el monto de cada cuota
     * @param $cant //1 si es semestral, 6 si es mensual. Todas las polizas tienen al menos una cuota asociada.
     * @param $fechaInicioVigencia //Para calcular las fechas de pago
     *
     * Retorna arreglo de cuotas, si es semestral, el arreglo tendrá solo una cuota como elemento
     * @return ArrayCollection
     * @throws
     *
     */
    //TODO Problema es que solo retorna los argumentos que tienen valor. CuotaType tiene mas atributos que los que retorna este listado
    public function getCalculoCuotasAction($montoTotal, $cant, $fechaInicioVigencia){

        //Arranca en 1 el numero de cuota porque la BD actua raro con el número 0
        $i=2;
        //Crea el arreglo para agregar las cuotas
        $cuotas = new ArrayCollection();

        //Crea una entidad de tipo Cuota
        $cuota = new Cuota();

        if(!$cant){
            return null;
        }
        //Verifica si el pago es semestral. Si lo es, crea una sola cuota
        if($cant==1){

            $cuota->setId(0);
            $cuota->setNumCuota(1);
            $cuota->setMonto($montoTotal);

            //Fecha de vencimiento es dia anterior a entrada en vigencia
            $fecha = new DateTime($fechaInicioVigencia);
            $fecha->modify("-1 day");
            //Retorna en este formato: 2020-01-25T00:00:00+00:00, pero si fechaInicioVigencia tiene este formato funciona
            $cuota->setFechaVencimiento($fecha);

            $cuotas->add($cuota);

            return $cuotas;

        }

        //Pago Mensual
        $cuota->setId(0);
        $cuota->setNumCuota(1);

        //Monto de cada cuota sera el monto total dividido seis.
        $cuota->setMonto($montoTotal/6);

        $fecha = new DateTime($fechaInicioVigencia);
        $fecha->modify("-1 day");
        $cuota->setFechaVencimiento($fecha);
        $cuotas->add($cuota);

        //Crea con fecha actual
        while($i<=$cant) {

            $cuota = new Cuota();

            //En la BD, al poner un id igual a cero, se calcula un id de forma automatica
            $cuota->setId(0);
            $cuota->setNumCuota($i);
            $cuota->setMonto($montoTotal/6);

            $fecha = new DateTime(''.$fecha->format('Y-m-d'));

            //$fecha->modify('+30 days');
            $fecha->modify('+1 Month');
            $cuota->setFechaVencimiento($fecha);
            $cuotas->add($cuota);

            $i++;

        }
        return $cuotas;
    }



    /**
     * Almacena en base de datos una poliza nueva.
     *
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

        //Valores del Json enviado en Request se almacenan en una entidad Poliza
        $objForm = $this->createForm(PolizaType::class, $poliza, ['em'=> $em]);
        $objForm->handleRequest($request);

        if ($objForm->isSubmitted() && $objForm->isValid()) {

            //TODO Consultar. Entra al if de arriba si alguno de los campos es nulo, el error salta luego de procesar todo (en el persist).

            //Agrega Cliente a Poliza.
                $c = $clienteDAO->getObj($poliza->getCliente()->getId());
                $poliza->setCliente($c);

           //Calculo de nro de poliza.
                $nroPoliza = $this->getCalculonropolizaAction($poliza->getCliente()->getId());
                $poliza->setNroPoliza($nroPoliza);

           //Estado de Poliza es "GENERADA" al crearse. En la BD, tiene el id 4
                $estadoPoliza = $estadoPolizaDAO->getObj(4);
                $poliza->setEstadopoliza($estadoPoliza);

           //Este se obtiene desde el DAO basandose en los KManio ingresados desde el frontend
                $ajusteKM = $ajusteKMDAO->getObj($poliza->getKmAnio());
                $poliza->setAjusteskm($ajusteKM);

           //Forma de pago.
                $fp = $formaPagoDAO->getObj($poliza->getFormapago()->getId());
                $poliza->setFormapago($fp);

           //Localidad (Domicilio de Riesgo)
                $l = $localidadDAO->getObj($poliza->getLocalidad()->getId());
                $poliza -> setLocalidad($l);

           //Vehiculo
                $vehiculo = $poliza->getVehiculo();

                //Medidas de Seguridad
                $medidas = new ArrayCollection();

                foreach($vehiculo->getListaMedidas() as $medida){
                    $medidas->add($medidasSeguridadDAO->getObj($medida->getId()));
                }

                $vehiculo->setListaMedidas($medidas);

                //Modelo de Vehiculo
                $vehiculo->setModelo($modeloDAO->getObj($vehiculo->getModelo()->getId()));

                $poliza->setVehiculo($vehiculo);


           //Tipo Cobertura
                $tc = $tipoCoberturaDAO->getObj($poliza->getTipoCobertura()->getId());
                $poliza -> setTipoCobertura($tc);


           //SiniestrosFC
                $s = $siniestrosDAO->getObj($poliza->getSiniestroFC()->getId());
                $poliza -> setSiniestroFC($s);


           //Hijos
                 if (is_array($poliza->getListaHijos()) || is_object($poliza->getListaHijos())) {

                     foreach ($poliza->getListaHijos() as $hijo) {

                         $hijo->setPoliza($poliza);
                         $hijo->setEnumSexo($enumSexoDAO->getObj($hijo->getEnumSexo()->getId()));
                         $hijo->setEstadoCivil($enumEstadoCivil->getObj($hijo->getEstadoCivil()->getId()));

                     }
                 }

           //Cuotas
                //TODO Validacion de listado de cuotas nulo, consultar donde se realizaria.
                if (is_array($poliza->getListaCuotas()) || is_object($poliza->getListaCuotas())) {
                    /** @var Cuota $cuota */
                    foreach ($poliza->getListaCuotas() as $cuota) {
                        $cuota->setPoliza($poliza);
                    }
                }


           //Factores de Caracteristicas es siempre el mismo
                $factoresCaracteristicas= $factoresCDAO->getObj(1);
                $poliza->setFactores($factoresCaracteristicas);

           //Almacena la Poliza en la BD
                $polizaDAO->save($poliza);

                return $poliza;

        }

        //Si la estructura JSON no concuerda con el Form o no es válido, retorna error.
        return $objForm;

    }


    /**
     * Calculo nro Poliza. Parametro: id de cliente
     *
     * @param $cliente
     * @View(serializerEnableMaxDepthChecks=true)
     * @return mixed
     */
    //TODO Falta ver cuando cant poliza es mayor a 99
    public function getCalculonropolizaAction($cliente){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $polizaDAO = DoctrineFactoryDAO::getFactory()->getPolizaDAO($em);
        $clienteDAO = DoctrineFactoryDAO::getFactory()->getClienteDAO($em);

        //Obtiene el cliente para realizar la busqueda por cliente
        $c = $clienteDAO->getObj($cliente);

        //Obtiene la cantidad de polizas que tiene asociado el cliente, vigente o no.
        $cantPoliza = $polizaDAO->countObj($c);


        return 8888*10000000+$c->getId()*100+$cantPoliza+1;

    }


//CU18. Busqueda de Poliza por número.

    /**
     * Retorna una poliza con nroPoliza = id. Busqueda de Poliza por Nro.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @param int $id
     * @return mixed
     */
    public function getAction(int $id){

        /** @var EntityManager $em */
        $em=$this->getDoctrine()->getManager();
        $polizaDAO = DoctrineFactoryDAO::getFactory()->getPolizaDAO($em);

        return $polizaDAO->getObj($id);

    }


//CU12. Luego de realizar un pago se actualiza el estado de poliza
    /**
     * Debe actualizar el estado de poliza segun los pagos realizados
     * @param $id
     */
    //TODO Implementar
    public function putAction($id){


    }
}