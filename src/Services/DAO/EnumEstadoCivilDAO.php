<?php


    namespace App\Services\DAO;


    use App\Entity\EnumEstadoCivil;
    use App\Interfaces\IDAO\IEnumDAO;
    use Doctrine\ORM\EntityManagerInterface;

    class EnumEstadoCivilDAO implements IEnumDAO {

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

            return $this->em->getRepository(EnumEstadoCivil::class)->find($id);

        }

        public function getAllObj(){

            return $this->em->getRepository(EnumEstadoCivil::class)->findBy([], ['descripcion' => 'ASC']);

        }

    }
