<?php


    namespace App\Services\DAO;

    //Entidades
    use App\Entity\TipoCobertura;

    //Doctrine
    use App\Interfaces\IDAO\ITipoCoberturaDAO;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    class TipoCoberturaDAO implements ITipoCoberturaDAO {

        private $em;

        /**
         * TipoCoberturaDAO constructor.
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

            return $this->em->getRepository(TipoCobertura::class)->find($id);

        }

        /**
         * @return object[]
         */
        public function getAllObj(){

            return $this->em->getRepository(TipoCobertura::class)->findBy([], ['nombre' => 'ASC']);

        }


    }
