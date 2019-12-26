<?php


    namespace App\Services\DAO;

    //Entidades
    use App\Entity\FactoresCaracteristicas;

    //Doctrine
    use App\Interfaces\IDAO\IFactoresCDAO;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    class FactoresCDAO implements IFactoresCDAO {


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

            return $this->em->getRepository(FactoresCaracteristicas::class)->find($id);

        }

    }
