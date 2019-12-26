<?php


namespace App\Controller;


use App\Entity\EnumTipoDni;
use App\Services\DAO\EnumTipoDNIDAO;
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
 * @RouteResource("EnumTipoDni")
 */
class EnumTipoDniController extends FOSRestController
{

    //private $tipoDNIDAO;


    /*public function __construct(){

        /** @var EntityManager $em */
        /*$em = $this->getDoctrine()->getManager();
        $this->tipoDNIDAO = new EnumTipoDNIDAO($em);

    }*/


    /**
     * Devuelve tipo de DNI segun el id
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @param int $id
     * @return mixed
     */
    public function getAction(int $id){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $tipoDNIDAO = new EnumTipoDNIDAO($em);

        return $tipoDNIDAO->getObj($id);

    }



    /**
     * Devuelve los tipos de DNI en orden alfabético
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @return array
     */
    public function cgetAction(){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $tipoDNIDAO = new EnumTipoDNIDAO($em);

        return $tipoDNIDAO->getAllObj();

    }

}