<?php


namespace App\Controller;

use App\Entity\Localidad;
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
 * @RouteResource("Localidades")
 */

class LocalidadController extends FOSRestController{

    /**
     * Devuelve localidad dado un id
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @param int $id
     * @return object|null
     */
    public function getAction(int $id){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $localidadDAO = DoctrineFactoryDAO::getFactory()->getLocalidadDAO($em);

        return $localidadDAO->getObj($id);

    }


    /**
     * Devuelve las localidades en orden alfabético
     * @View(serializerEnableMaxDepthChecks=true)
     *
     * @return array
     *
     */
    //TODO Ver si agregar o no el id de provincia
    public function cgetAction(){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $localidadDAO = DoctrineFactoryDAO::getFactory()->getLocalidadDAO($em);

        return $localidadDAO->getAllObj();

    }

}