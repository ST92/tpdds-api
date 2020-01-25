<?php


namespace App\Controller;

use App\Entity\Pago;
use App\Form\PagoType;
use App\Services\DAO\CuotaDAO;
use App\Services\Otros\SistemaFinancieroService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Request\ParamFetcherInterface;
use phpDocumentor\Reflection\Types\Mixed_;
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
 * @RouteResource("Pago")
 */
class PagoController extends FOSRestController{

    //private $cuotaDAO;

    /*public function __construct()
    {
        /** @var EntityManager $em */
        /*$em = $this->getDoctrine()->getManager();

        $this->cuotaDAO = new CuotaDAO($em);
    }*/


    /**
     * @param Request $request
     * @View(serializerEnableMaxDepthChecks=true)
     * @return null
     * @throws
     */

    public function postAction(Request $request){

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $cuotaDAO = new CuotaDAO($em);

        $pago = new Pago();

        $objForm = $this->createForm(PagoType::class, $pago, ['em' => $em]);
        $objForm->handleRequest($request);

        if ($objForm->isSubmitted() && $objForm->isValid()) {
            $cuotas = $objForm->get('lista_cuotas')->getData();

            foreach ($cuotas as $cuota){


            }
        }


        return $objForm;

    }
}