<?php


namespace App\Controller;


use App\Entity\EnumSexo;
use App\Services\DAO\DoctrineFactoryDAO;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use PhpParser\Comment\Doc;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\MimeType\FileinfoMimeTypeGuesser;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * @RouteResource("EnumSexo")
 */

class EnumSexoController extends FOSRestController {

    /**
     * Devuelve entidad EnumSexo dado un id
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @param int $id
     * @return mixed
     */
    public function getAction(int $id){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $enumSexoDAO = DoctrineFactoryDAO::getFactory()->getEnumSexoDAO($em);

        return $enumSexoDAO->getObj($id);

    }


    /**
     * Devuelve las entidades EnumSexo en orden alfabético
     *
     * @View(serializerEnableMaxDepthChecks=true)
     * @return array
     *
     */
    public function cgetAction(){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $enumSexoDAO = DoctrineFactoryDAO::getFactory()->getEnumSexoDAO($em);

        return $enumSexoDAO->getAllObj();

    }


}