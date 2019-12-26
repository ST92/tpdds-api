<?php


    namespace App\Services\DAO;


     use App\Entity\Vehiculo;
     use Doctrine\ORM\EntityManagerInterface;

     class VehiculoDAO{

         private $em;

         public function __construct(EntityManagerInterface $em)
         {
             $this->em = $em;
         }

    }
