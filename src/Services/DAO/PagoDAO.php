<?php


namespace App\Services\DAO;


use App\Interfaces\IDAO\IPagoDAO;
use Doctrine\ORM\EntityManagerInterface;

class PagoDAO implements IPagoDAO{

    private $em;

    public function __construct(EntityManagerInterface $em){

        $this->em = $em;

    }

    public function getObj(int $id){

    }

    public function save($pago){

        $this->em->persist($pago);
        $this->em->flush();

    }


}