<?php


namespace App\Services\DAO;


use App\Entity\Provincia;
use App\Interfaces\IDAO\IProvinciaDAO;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProvinciaDAO implements IProvinciaDAO {

    private $em;

    /**
     * ProvinciaDAO constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * @param int $id
     * @return mixed
     */
    public function getObj($id){

        return $this->em->getRepository(Provincia::class)->find($id);

    }

    /**
     * @return object[]
     */
    public function getAllObj(){

        //Es nombre del atributo en Entity, no de BD
        return $this->em->getRepository(Provincia::class)->findBy([], array('nombre' => 'ASC'));

    }

}
