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
use PhpParser\Comment\Doc;
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
use Symfony\Component\Validator\Constraints\Date;


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
     * Verifica si chasis tiene una poliza vigente o no. Retorna true si EXISTE POLIZA con estado DIFERENTE a FINALIZADA con ese chasis
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @param string $chasis
     * @return bool
     */
    public function getValidacionchasisAction($chasis){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $polizaDAO = DoctrineFactoryDAO::getFactory()->getPolizaDAO($em);
        $estadoPolizaDAO = DoctrineFactoryDAO::getFactory()->getEnumEstadoPolizaDAO($em);

        //Estado Finalizado
        $estado = $estadoPolizaDAO->getObj(3);

        //Cuenta la cantidad de polizas que hay con estado diferente a Finalizado
        $cant = $polizaDAO->findVehiculoActivo("chasis", $chasis, $estado);

        if($cant==0){

            return false;
        }
        else{
            return true;
        }

    }

    /**
     * Verifica si motor tiene una poliza vigente o no. Retorna true si EXISTE POLIZA con estado DIFERENTE a FINALIZADA con ese motor
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @param string $motor
     * @return bool
     */
    public function getValidacionmotorAction($motor){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $polizaDAO = DoctrineFactoryDAO::getFactory()->getPolizaDAO($em);
        $estadoPolizaDAO = DoctrineFactoryDAO::getFactory()->getEnumEstadoPolizaDAO($em);

        //Estado Vigente/Activa
        $estado = $estadoPolizaDAO->getObj(3);

        $cant = $polizaDAO->findVehiculoActivo("motor", $motor, $estado);

        if($cant==0 || $cant == null){

            return false;
        }
        else{
            return true;
        }

    }


    /**
     * Verifica si patente tiene una poliza vigente o no. Retorna true si EXISTE POLIZA con estado DIFERENTE a FINALIZADA con esa patente
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @param string $patente
     * @return bool
     */
    public function getValidacionpatenteAction($patente){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $polizaDAO = DoctrineFactoryDAO::getFactory()->getPolizaDAO($em);
        $estadoPolizaDAO = DoctrineFactoryDAO::getFactory()->getEnumEstadoPolizaDAO($em);

        //Estado Vigente/Activa
        $estado = $estadoPolizaDAO->getObj(3);
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
    //En el diagrama de clases, los derechos de emision se almacenan en los factores de caracteristicas. Si bien, no sabemos si es correcto o no, el diagrama fue validado con dicho atributo
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
     * @return ArrayCollection|null
     * @throws
     */
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
            $cuota->setRecargos(0);
            $cuota->setBonificacionPagoAdelantado(0);

            $cuotas->add($cuota);

            return $cuotas;

            /*$response = new JsonResponse();
            $response->setData(['cuotas' => $cuotas]);

            return $response;*/

        }

        //Pago Mensual
        $cuota->setId(0);
        $cuota->setNumCuota(1);

        //Monto de cada cuota sera el monto total dividido seis.
        $cuota->setMonto($montoTotal/6);

        $fecha = new DateTime($fechaInicioVigencia);
        $fecha->modify("-1 day");
        $cuota->setFechaVencimiento($fecha);
        $cuota->setRecargos(0);
        $cuota->setBonificacionPagoAdelantado(0);

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
            $cuota->setRecargos(0);
            $cuota->setBonificacionPagoAdelantado(0);
            $cuotas->add($cuota);

            $i++;

        }
        return $cuotas;
        /*$response = new JsonResponse();
        $response->setData(['cuotas' => $cuotas]);

        return $response;*/

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

            //Agrega Cliente a Poliza.
                $c = $clienteDAO->getObj($poliza->getCliente()->getId());
                $poliza->setCliente($c);

           //Calculo de nro de poliza.
                $nroPoliza = $this->getCalculonropolizaAction($poliza->getCliente()->getId());
                $poliza->setNroPoliza($nroPoliza);

           //Referencia a poliza anterior.
                $poliza->setIdPoliza($polizaDAO->getObj($nroPoliza-1));

           //Estado de Poliza es "GENERADA" al crearse. En la BD, tiene el id 4
                $estadoPoliza = $estadoPolizaDAO->getObj(4);
                $poliza->setEstadopoliza($estadoPoliza);

           //Calculo de monto total a abonar. Lo hace también el frontend
                $poliza->setMontoTotalAAbonar($poliza->getPremio()- $poliza->getImportePorDescuento());

           //Este se obtiene desde el DAO basandose en los KManio ingresados desde el frontend
                $ajusteKM = $ajusteKMDAO->getObj($poliza->getKmAnio());
                if(is_null($ajusteKM)){

                    return (int)(($poliza->getKmAnio())/10000);

                }
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

                $this->actualizarEstadoCliente($poliza);

                return $poliza;

        }

        //Si la estructura JSON no concuerda con el Form o no es válido, retorna error.
        return $objForm;

    }

//TODO Implementarlo luego de consultar
    //Los unicos estados activos son normal o plata
    /**
     * @param Poliza $poliza
     * @return
     */
    public function actualizarEstadoCliente($poliza){

        //DAO
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $polizaDAO = DoctrineFactoryDAO::getFactory()->getPolizaDAO($em);
        $clienteDAO = DoctrineFactoryDAO::getFactory()->getClienteDAO($em);
        $estadoClienteDAO = DoctrineFactoryDAO::getFactory()->getEnumEstadoClienteDAO($em);
        $estadoPolizaDAO = DoctrineFactoryDAO::getFactory()->getEnumEstadoPolizaDAO($em);

        $cliente = $poliza->getCliente();

        //Revisa la cantidad de polizas del cliente.
        // Si la unica poliza asociada fue la dada de alta recien (la referencia a poliza anterior es nula, quiere decir que es la primera asociada).
        // El cliente pasa a estado normal.
        if(is_null($poliza->getIdPoliza())){

            //Busca estado Normal en la BD y se lo agrega al cliente.
            $cliente->setEnumEstadocliente($estadoClienteDAO->getObj(2));

            //Almacena los cambios realizados
            $clienteDAO->save($cliente);

            return new Response();
        }

        //Buscar polizas que estén vigentes. Si retorna 0, el cliente pasa a estado Normal

        //Se podría asumir que la ultima poliza, es decir, la anterior a esta, si no está vigente entonces las otras seguro no lo estarían.
        //Por el tema de los calculos de fecha inicio o fin de vigencia
        /*if($poliza->getIdPoliza()->getEstadoPoliza()->getId() != 1){

            $poliza->getCliente()->setEnumEstadocliente($estadoClienteDAO->getObj(2));
            //Almacena los cambios realizados
            $clienteDAO->save($poliza->getCliente());

            return new Response();
        }*/

        //De todas formas implemento el conteo por las dudas.
        //Estado de poliza de id 1 es estado Vigente
        $estado = $estadoPolizaDAO->getObj(1);
        $cantPolizaVig = $polizaDAO->countPolizaPorEstado($cliente, $estado);

        if($cantPolizaVig==0){

            //Busca estado Normal en la BD y se lo agrega al cliente.
            $cliente->setEnumEstadocliente($estadoClienteDAO->getObj(2));

            //Almacena los cambios realizados
            $clienteDAO->save($cliente);

            return new Response();

        }

        //Si posee siniestros en el ultimo año

        $siniestros = $poliza->getSiniestroFC();

        //Tiene al menos un siniestro este año (la recientemente dada de alta)
        if($siniestros->getId() != 4){

            //Busca estado Normal en la BD y se lo agrega al cliente.
            $cliente->setEnumEstadocliente($estadoClienteDAO->getObj(2));

            //Almacena los cambios realizados
            $clienteDAO->save($poliza->getCliente());


        }

        //Comienza a buscar en las polizas anteriores a la que fue dada de alta recien cuya fecha de fin de vigencia sea en el ultimo año
        $now = new DateTime('today');
        $diferencia = $now->diff($poliza->getIdPoliza()->getFechaFinVigencia());
        $dias = (int)$diferencia->format('%R%a');

        $poliza = $poliza->getIdPoliza();
        //Si la diferencia entre la poliza anterior y esta, en días, es menor a 365, quiere decir que la poliza anterior se renovo/dio de alta en el mismo año
        while($dias<=365 && !is_null($poliza)){

            //Revisar si tiene siniestros
            //Si es distinto de 4, tiene siniestros en el ultimo año. Pasa a estado normal el cliente
            if($poliza->getSiniestroFC()->getId()!=4){

                //Busca estado Normal en la BD y se lo agrega al cliente.
                $cliente->setEnumEstadocliente($estadoClienteDAO->getObj(2));

                //Almacena los cambios realizados
                $clienteDAO->save($poliza->getCliente());

                return new Response();

            }

            $poliza = $poliza->getIdPoliza();

            if(!is_null($poliza)){

                $diferencia = $now->diff($poliza->getFechaFinVigencia());
                $dias = (int)$diferencia->format('%R%a');

            }

        }

        //Si lo anterior no anda, probar buscar en la BD directamente y recorrer la lista
        //Busco las polizas con fecha de inicio de vigencia dentro de un año.
        //Las agrego a una lista
        //Recorro la lista y veo si hay siniestros. Si hay una poliza en esa lista que tenga siniestros, pasa a normal y termina
        //normal

        //Si pasa el while, es porque no tiene siniestros en el ultimo año.
        //Cliente no posee siniestros en el ultimo año (supera el recorrido poliza por poliza)


        //Si posee una cuota impaga normal




        //Cliente no posee cuotas impagas, pasa a la ultima evaluación










        //Cliente activo en los ultimos tres años de forma ininterrumpida.
        //"no estuvo activo ininterrumpido": si, por ejemplo, contrata una poliza por año, se considera que esta inactivo desde el mes 7 al 12.
        //o sea, una poliza por año cuenta como activo interrumpido
        //Dadas estas tres condiciones, con un AND, el estado pasa a ser Plata
        //Plata
        //No ha sido un cliente activo ininterrumpido al menos los dos ultimos años.
        //Dadas estas tres condiciones, con un OR, si se cumple alguna pasa a estado Normal.
        //Normal

        return new Response();

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
        $polizaDAO = DoctrineFactoryDAO::getFactory()->getPolizaDAO($em);
        $clienteDAO = DoctrineFactoryDAO::getFactory()->getClienteDAO($em);

        //Obtiene el cliente para realizar la busqueda por cliente
        $c = $clienteDAO->getObj($cliente);

        //Obtiene la cantidad de polizas que tiene asociado el cliente, vigente o no.
        $cantPoliza = $polizaDAO->countObj($c);


        return 8888*1000000000000+$c->getId()*100+$cantPoliza+1;

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
     * @param $idPoliza
     * @return string|void
     * @throws
     */
    public function putAction($idPoliza){



    }
}