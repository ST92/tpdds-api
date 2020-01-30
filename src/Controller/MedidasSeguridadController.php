<?php


namespace App\Controller;


use App\Services\DAO\DoctrineFactoryDAO;
use FOS\RestBundle\Controller\FOSRestController;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\MimeType\FileinfoMimeTypeGuesser;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * @RouteResource("Medidasseguridad")
 */

class MedidasSeguridadController extends FOSRestController{


    /**
     * Devuelve una medida de seguridad dado un id
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @param int $id
     * @return object|null
     */
    public function getAction(int $id){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $medidaSeguridadDAO = DoctrineFactoryDAO::getFactory()->getMedidasSeguridadDAO($em);

        return $medidaSeguridadDAO->getObj($id);
    }


    /**
     * Devuelve todas las medidas de seguridad
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @return array
     *
     */
    public function cgetAction(){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $medidaSeguridadDAO = DoctrineFactoryDAO::getFactory()->getMedidasSeguridadDAO($em);

        return $medidaSeguridadDAO->getAllObj();

    }

}