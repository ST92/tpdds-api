<?php


    namespace App\Services\DAO;

    //Entidades
    use App\Entity\SiniestrosFc;

    //Doctrine
    use App\Interfaces\IDAO\ISiniestrosDAO;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    class SiniestrosDAO implements ISiniestrosDAO{


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

           return $this->em->getRepository(SiniestrosFc::class)->find($id);


        }

        /**
         * @return object[]
         */
        public function getAllObj(){

            //Es nombre del atributo en Entity, no de BD
            return $this->em->getRepository(SiniestrosFc::class)->findBy([], array('descripcion' => 'ASC'));

        }

    }
