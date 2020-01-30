<?php


namespace App\Controller;


use App\Entity\TipoCobertura;
use App\Services\DAO\DoctrineFactoryDAO;
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
 * @RouteResource("TipoCobertura")
 */

class TipoCoberturaController extends FOSRestController {


    /**
     * Devuelve un tipo de cobertura según id
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @param int $id
     * @return mixed
     */
    public function getAction(int $id){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $tipoCobDAO = DoctrineFactoryDAO::getFactory()->getTipoCoberturaDAO($em);

        return $tipoCobDAO->getObj($id);

    }


    /**
     * Devuelve los tipos de cobertura en orden alfabético
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @return array
     */
    public function cgetAction(){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $tipoCobDAO = DoctrineFactoryDAO::getFactory()->getTipoCoberturaDAO($em);

        return $tipoCobDAO->getAllObj();

    }

}