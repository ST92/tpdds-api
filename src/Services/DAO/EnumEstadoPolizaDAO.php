<?php


    namespace App\Services\DAO;


    use App\Entity\EnumEstadoPoliza;
    use App\Interfaces\IDAO\IEnumDAO;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    class EnumEstadoPolizaDAO implements IEnumDAO {

        private $em;

        public function __construct(EntityManagerInterface $em)
        {
            $this->em = $em;
        }

        /**
         * @param int $id
         * @return mixed $estadoPoliza
         */
        public function getObj(int $id){

            return $this->em->getRepository(EnumEstadoPoliza::class)->find($id);

        }

        public function getAllObj(){

            return $this->em->getRepository(EnumEstadoPoliza::class)->findBy([], ['descripcion' => 'ASC']);

        }

    }
