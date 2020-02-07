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
use Symfony\Component\Yaml\Tests\A;


/**
 * @RouteResource("Cliente")
 */
class ClienteController extends FOSRestController{

//CU1: Actualización de estado de cliente




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


        $clientes = new ArrayCollection();
        foreach ($clienteDAO->getAllObj($filters, $operators, $order_by, $limit, $offset) as $c){

            //Selecciona los clientes activos
            if($c->getEnumEstadoCliente()->getId()!=3){

                $clientes->add($c);

            }

        }


        return [
            'items' => $clientes,
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