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

    //private $clienteDAO;

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
     * @param Request $request
     * @return object[]|FormInterface
     */
    //TODO Falta resolver lo del get request. Submit y handleRequest no andan
    public function cgetAction(Request $request)
    {

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $busqueda = new BusquedaCliente();
        $clienteDAO = new ClienteDAO($em);

        //$objForm=$this->createForm(BusquedaClienteType::class, $busqueda);
        $objForm = $this->createForm(BusquedaClienteType::class, $busqueda, ['em' => $em]);
       // $objForm->handleRequest($request);

        if($request->isMethod("GET")) {
            $objForm->submit($request->request->all());

            //$objForm->submit($request->request->get($objForm->getName()));
        }
        else{
            return new Response("no fue get");
        }
       if($objForm->isSubmitted()) {

            if($objForm->isValid()){
                $busqueda = $objForm->getData();
                $nombre = $objForm->get('nombre')->getData();
                $apellido = $objForm->get('apellido')->getData();
                $id = $objForm->get('id')->getData();
                $dni = $objForm->get('dni')->getData();
                //$tipoDni = $objForm->get('enumTipoDni')->getData();
                $tipoDni = $em->getRepository(EnumTipoDni::class)->find(1);
                $resultado = $clienteDAO->getAllObj($id, $nombre, $apellido, $dni, $tipoDni);

                $r =  new JsonResponse();
                $r->setData($resultado);
                $r->setData($busqueda->getNombre());
                return $resultado;
            }
            else{
                return new Response("no valid");
                //return $objForm;
            }
        }
        return new Response("no submit");
        //return $objForm;
    }

}