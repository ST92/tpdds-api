<?php


namespace App\Controller;

use App\Entity\Marca;
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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * @RouteResource("Marca")
 */
class MarcaController extends FOSRestController {

    /**
     * Devuelve una marca según el id
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @param int $id
     * @return mixed
     */
    public function getAction(int $id){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $marcaDAO = DoctrineFactoryDAO::getFactory()->getMarcaDAO($em);

        return $marcaDAO->getObj($id);

    }

    /**
     * Devuelve las marcas en orden alfabético
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @return array
     */
    public function cgetAction(){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $marcaDAO = DoctrineFactoryDAO::getFactory()->getMarcaDAO($em);

        return $marcaDAO->getAllObj();

    }


}