<?php


namespace App\Services\DAO;


use App\Entity\Modelo;
use App\Interfaces\IDAO\IModeloDAO;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModeloDAO implements IModeloDAO{

        private $em;

        /**
         * ModeloDAO constructor.
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

            return $this->em->getRepository(Modelo::class)->find($id);
        }


        /**
         * @return object[]
         */
        public function getAllObj(){

            return $this->em->getRepository(Modelo::class)->findBy([], ['nombre' => 'ASC']);

        }

}
