<?php


namespace App\Controller;


use App\EntidadesAux\BusquedaCliente;
use App\Entity\Cliente;
use App\Entity\EnumTipoDni;
use App\Form\BusquedaClienteType;
use App\Services\DAO\ClienteDAO;
use App\Services\DAO\DoctrineFactoryDAO;
use App\Services\DAO\EnumTipoDNIDAO;
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

    /**
     * Retorna un cliente según el id enviado como parametro
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
     * Busqueda de clientes
     * Criterios: id, nombre, apellido, tipoDNI, dni
     *
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @param Request $request
     * @return object[]|FormInterface
     */
    //TODO Funciona con los diferentes parámetros pero no funciona recibiendo el request
    //TODO La validacion de todos los valores en null se hace o en el front end, o se crea un metodo aparte
    public function cgetAction(Request $request){

        /*
        $id = $request->request->getInt('id');
        $apellido = $request->request->getAlpha('apellido');
        $nombre = $request->query->getAlpha('nombre');
        $tipo = $request->query->getInt('tipo_dni');
        $dni = $request->query->getInt('dni');
        */
        $id = $request->get('id');
        $apellido = $request->get('apellido');
        $nombre = $request->get('nombre');
        $tipo = $request->get('tipo_dni');
        $dni = $request->get('dni');

        $tipoDni = null;

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $clienteDAO = DoctrineFactoryDAO::getFactory()->getClienteDAO($em);
        $estadoClienteDAO = DoctrineFactoryDAO::getFactory()->getEnumEstadoClienteDAO($em);

        //Busca entidad tipo DNI para luego buscarla en una consulta
        if($tipo){

            $tipoDNIDAO = DoctrineFactoryDAO::getFactory()->getEnumTipoDNIDAO($em);
            $tipoDni = $tipoDNIDAO->getObj($tipo);

        }

        //Obtiene el enumEstadoCliente inactivo, despues en el metodo de busqueda, la consulta busca aquellos que no tengan ese enum
        $estadoCliente = $estadoClienteDAO->getObj(3);


        //Busca un cliente dado los criterios
        return $clienteDAO->getAllObj($id, $nombre, $apellido, $dni, $tipoDni, $estadoCliente);

    }

}