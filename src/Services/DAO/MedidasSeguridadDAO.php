<?php


namespace App\Services\DAO;


use App\Entity\MedidasSeguridad;
use App\Interfaces\IDAO\IMedidasSeguridadDAO;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MedidasSeguridadDAO implements IMedidasSeguridadDAO{


    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * @param int $id
     * @return mixed
     */
    public function getObj($id){

        return $this->em->getRepository(MedidasSeguridad::class)->find($id);

    }

    public function getAllObj(){

        return $this->em->getRepository(MedidasSeguridad::class)->findBy([], ['descripcion' => 'ASC']);

    }
}
