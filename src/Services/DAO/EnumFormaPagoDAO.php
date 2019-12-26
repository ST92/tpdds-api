<?php


    namespace App\Services\DAO;


    use App\Entity\EnumFormaPago;
    use App\Interfaces\IDAO\IEnumDAO;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    class EnumFormaPagoDAO implements IEnumDAO {


        private $em;

        public function __construct(EntityManagerInterface $em)
        {
            $this->em = $em;
        }


        /**
         * @param int $id
         * @return mixed $pago
         */
        public function getObj(int $id){

            return $this->em->getRepository(EnumFormaPago::class)->find($id);

        }

        public function getAllObj(){

            return $this->em->getRepository(EnumFormaPago::class)->findBy([], ['descripcion' => 'ASC']);

        }

    }
