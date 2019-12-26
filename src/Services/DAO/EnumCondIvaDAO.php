<?php


namespace App\Services\DAO;


use App\Entity\EnumCondIva;
use App\Interfaces\IDAO\IEnumDAO;
use Doctrine\ORM\EntityManagerInterface;

class EnumCondIvaDAO implements IEnumDAO {

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * @param int $id
     * @return mixed
     */
    public function getObj(int $id){

        return $this->em->getRepository(EnumCondIva::class)->find($id);

    }


    /**
     * @return object[]
     */
    public function getAllObj(){

        return $this->em->getRepository(EnumCondIva::class)->findBy([], ['descripcion' => 'ASC']);

    }

}