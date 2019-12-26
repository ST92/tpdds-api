<?php

namespace App\Controller;


use App\Entity\Provincia;
use App\Services\DAO\ProvinciaDAO;
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
 * @RouteResource("Provincia")
 */
class ProvinciaController extends FOSRestController
{

    //private $provinciaDAO;

    /**
     * ProvinciaController constructor.
     */
   /* public function __construct()
    {
        /** @var EntityManager $em */
       /* $em = $this->getDoctrine()->getManager();
        $this->provinciaDAO = new ProvinciaDAO($em);

    }*/


    /**
     * Devuelve una provincia según el id
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @param int $id
     * @return array
     */
    public function getAction(int $id){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $provinciaDAO = new ProvinciaDAO($em);

         return $provinciaDAO->getObj($id);

     }


     /**
      * Devuelve las provincias en orden alfabético
      *
      * @View(serializerEnableMaxDepthChecks=true)
      * @return array
      */
    public function cgetAction(){
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $provinciaDAO = new ProvinciaDAO($em);

        return $provinciaDAO->getAllObj();
    }
}