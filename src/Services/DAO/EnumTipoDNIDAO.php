<?php


namespace App\Services\DAO;


use App\Entity\EnumTipoDni;
use App\Interfaces\IDAO\IEnumDAO;
use Doctrine\ORM\EntityManagerInterface;

class EnumTipoDNIDAO implements IEnumDAO {

    private $em;

    /**
     * EnumTipoDNIDAO constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param int $id
     * @return object|null
     */
    public function getObj(int $id){

        return $this->em->getRepository(EnumTipoDni::class)->find($id);

    }

    /**
     * @return object[]
     */
    public function getAllObj(){

        return $this->em->getRepository(EnumTipoDni::class)->findBy([], ['descripcion' => 'ASC']);

    }
}