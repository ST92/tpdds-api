<?php


namespace App\Controller;



use App\Entity\Modelo;
use App\Services\DAO\DoctrineFactoryDAO;
use App\Services\DAO\ModeloDAO;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\MimeType\FileinfoMimeTypeGuesser;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * @RouteResource("Modelo")
 */
class ModeloController extends FOSRestController
{

    /**
     * Devuelve un modelo según id
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @param int $id
     * @return mixed
     */
    public function getAction(int $id){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $modeloDAO = DoctrineFactoryDAO::getFactory()->getModeloDAO($em);

        return $modeloDAO->getObj($id);

    }


    /**
     * Devuelve los modelos en orden alfabético
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @return array
     */
    //TODO Igual que localidad, ver si agregar lo de id marca
    public function cgetAction(){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $modeloDAO = DoctrineFactoryDAO::getFactory()->getModeloDAO($em);

        return $modeloDAO->getAllObj();

    }

}