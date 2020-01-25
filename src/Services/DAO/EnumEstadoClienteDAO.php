<?php


namespace App\Services\DAO;


use App\Entity\EnumEstadoCliente;
use App\Interfaces\IDAO\IEnumDAO;
use Doctrine\ORM\EntityManagerInterface;

class EnumEstadoClienteDAO implements IEnumDAO{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getObj(int $id){

        return $this->em->getRepository(EnumEstadoCliente::class)->find($id);

    }

    public function getAllObj(){

        return $this->em->getRepository(EnumEstadoCliente::class)->findBy([], ['descripcion' => 'ASC']);

    }

}