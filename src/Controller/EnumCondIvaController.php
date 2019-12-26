<?php


namespace App\Controller;


use App\Entity\EnumCondIva;
use App\Services\DAO\EnumCondIvaDAO;
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
 * @RouteResource("EnumCondIva")
 */

class EnumCondIvaController extends FOSRestController {

    //private $enumCondIvaDAO;

    /*public function __construct(){
        /** @var EntityManager $em */
       /* $em = $this->getDoctrine()->getManager();
        $this->enumCondIvaDAO = new EnumCondIvaDAO($em);

    }*/


    /**
     * Devuelve entidad CondicionIVA dado un Id
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @param int $id
     * @return mixed
     */
    public function getAction(int $id){
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
         $enumCondIvaDAO = new EnumCondIvaDAO($em);

         return $enumCondIvaDAO->getObj($id);
    }


     /**
      * Devuelve las entidades CondicionIVA en orden alfabético
      *
      * @View(serializerEnableMaxDepthChecks=true)
      * @return array
      */
    public function cgetAction(){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $enumCondIvaDAO = new EnumCondIvaDAO($em);

        return $enumCondIvaDAO->getAllObj();

    }


}