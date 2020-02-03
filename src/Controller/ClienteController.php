<?php


namespace App\Controller;


use App\Entity\Cliente;
use App\Entity\Poliza;
use App\Services\DAO\DoctrineFactoryDAO;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Request\ParamFetcherInterface;
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
 * @RouteResource("Cliente")
 */
class ClienteController extends FOSRestController{

//CU1: Actualización de estado de cliente

    //TODO Implementarlo luego de consultar
    //Los unicos estados activos son normal o plata
    /**
     * @param Poliza $poliza
     * @return
     */
    public function getActualizarestadoclienteAction($poliza){

        //DAO
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $polizaDAO = DoctrineFactoryDAO::getFactory()->getPolizaDAO($em);
        $clienteDAO = DoctrineFactoryDAO::getFactory()->getClienteDAO($em);
        $estadoClienteDAO = DoctrineFactoryDAO::getFactory()->getEnumEstadoClienteDAO($em);
        $estadoPolizaDAO = DoctrineFactoryDAO::getFactory()->getEnumEstadoPolizaDAO($em);

        //Revisa la cantidad de polizas del cliente.
        // Si la unica poliza asociada fue la dada de alta recien (la referencia a poliza anterior es nula, quiere decir que es la primera asociada).
        // El cliente pasa a estado normal.
        if(is_null($poliza->getIdPoliza())){

            //Busca estado Normal en la BD y se lo agrega al cliente.
            $poliza->getCliente()->setEnumEstadocliente($estadoClienteDAO->getObj(2));

            //Almacena los cambios realizados
            $clienteDAO->save($poliza->getCliente());

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
        $cantPolizaVig = $polizaDAO->countPolizaPorEstado($poliza->getCliente(), $estado);

        if($cantPolizaVig==0){

            //Busca estado Normal en la BD y se lo agrega al cliente.
            $poliza->getCliente()->setEnumEstadocliente($estadoClienteDAO->getObj(2));

            //Almacena los cambios realizados
            $clienteDAO->save($poliza->getCliente());

            return new Response();

        }

        //"no estuvo activo ininterrumpido": si, por ejemplo, contrata una poliza por año, se considera que esta inactivo desde el mes 7 al 12.
        //o sea, una poliza por año cuenta como activo interrumpido

        //Si posee siniestros en el ultimo año (las ultimas dos polizas asociadas al cliente)
            //Busco las polizas con fecha de inicio de vigencia dentro de un año.
            //Las agrego a una lista
            //Recorro la lista y veo si hay siniestros. Si hay una poliza en esa lista que tenga siniestros, pasa a normal y termina
            //normal

        //Cliente no posee siniestros en el ultimo año (supera el recorrido poliza por poliza)
        //Si posee una cuota impaga
        //normal
        //Cliente no posee cuotas impagas
        //Cliente activo en los ultimos tres años de forma ininterrumpida
        //Dadas estas tres condiciones, con un AND, el estado pasa a ser Plata
        //Plata
        //No ha sido un cliente activo ininterrumpido al menos los dos ultimos años.
        //Dadas estas tres condiciones, con un OR, si se cumple alguna pasa a estado Normal.
        //Normal

        return new Response();


    }



//CU17: Busqueda de Clientes

    /**
     * Busqueda de clientes
     * Criterios: id, nombre, apellido, tipoDNI, dni
     *
     * @param ParamFetcherInterface $paramFetcher
     *
     * @View()
     *
     * @QueryParam(name="offset", requirements="\d+", nullable=true, description="Offset from which to start listing notes.")
     * @QueryParam(name="limit", requirements="\d+", default="100", description="How many notes to return.")
     * @QueryParam(name="order_by", nullable=true, description="Order by fields. Must be an array ie. &order_by[name]=ASC&order_by[description]=DESC")
     * @QueryParam(name="filters", nullable=true, description="Filter by fields. Must be an array ie. &filters[id]=3")
     * @QueryParam(name="operators", nullable=true, description="Operator by fields. Must be an array ie. &operators[id]=>")
     *
     * @return array
     *
     * @throws
     *
     */
    //TODO Al agregar un filtro mas a la URL, el = deja de actuar como el startswith
    // No funciona para el criterio de busqueda "Estado cliente id distinto de 3 o descripcion distinta a Inactivo
    // EL CRITERIO DE BUSQUEDA ESTADO CLIENTE SIEMPRE ES ACTIVO (id <> 3)

    public function cgetAction(ParamFetcherInterface $paramFetcher){

        //Obtiene el DAO para realizar la busqueda sobre entidades de tipo Cliente
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $clienteDAO = DoctrineFactoryDAO::getFactory()->getClienteDAO($em);

        //Obtiene los parámetros que se usaran para realizar la busqueda
        $offset = $paramFetcher->get('offset');
        $limit = $paramFetcher->get('limit');
        $order_by = !is_null($paramFetcher->get('order_by')) ? $paramFetcher->get('order_by') : array();
        $filters = !is_null($paramFetcher->get('filters')) ? $paramFetcher->get('filters') : array();
        $operators = !is_null($paramFetcher->get('filters')) ? $paramFetcher->get('operators') : array();

        //Retorna los resultados obtenidos
        return [
            'items' => $clienteDAO->getAllObj($filters, $operators, $order_by, $limit, $offset),
            'filters'=>$filters,
            'operators'=>$operators
        ];

    }


    /**
     * Retorna un cliente según el id enviado como parametro
     * No sirve para la busqueda de cliente. Solo sirve como prueba. Salvo que filtre por clientes activos.
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @param int $id
     * @return Cliente
     */
    public function getAction(int $id){

        /** @var EntityManager $em */

        $em = $this->getDoctrine()->getManager();
        $clienteDAO = DoctrineFactoryDAO::getFactory()->getClienteDAO($em);

        return $clienteDAO->getObj($id);

    }


    /**
     * Este se supone que retorna un valor fijo para los siniestros del conductor. En este caso retornará una entidad de tipo SiniestrosFC "fija"
     * simulando la interaccion con el subsistema de de siniestros
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @param $dni
     * @return mixed
     */
    public function getSiniestrosconductorAction($dni){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $id = rand(1,4);

        return DoctrineFactoryDAO::getFactory()->getSiniestrosDAO($em)->getObj($id);

    }

}