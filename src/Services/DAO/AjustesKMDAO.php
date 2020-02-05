<?php


    namespace App\Services\DAO;

    //Entidades
    use App\Entity\AjustesPorKm;
    use App\Entity\Localidad;

    //Doctrine
    use App\Interfaces\IDAO\IAjustesKMDAO;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    class AjustesKMDAO implements IAjustesKMDAO{

        private $em;

        public function __construct(EntityManagerInterface $em)
        {
            $this->em = $em;
        }


        /**
         * Retorna un AjusteKm dada la cantidad de km
         * @param int $kmAnio
         * @return mixed $ajustesKM
         */
        public function getObj($kmAnio){

            //Los ajustes van de 10000 en 10000
            //(int)(($poliza->getKmAnio())/10000)
            $idKm = (int)($kmAnio/10000);
            return $this->em->getRepository(AjustesPorKm::class)->find($idKm+1);

        }

    }
