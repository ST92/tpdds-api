<?php


    namespace App\Services\DAO;


    use App\Entity\Cuota;
    use App\Interfaces\IDAO\ICuotaDAO;
    use Doctrine\ORM\EntityManagerInterface;

    class CuotaDAO implements ICuotaDAO {

        private $em;

        public function __construct(EntityManagerInterface $em)
        {
            $this->em = $em;
        }

        public function getObj(int $id){

            return $this->em->getRepository(Cuota::class)->find($id);

        }
    }
