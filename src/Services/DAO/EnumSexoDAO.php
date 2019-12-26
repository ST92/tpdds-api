<?php


    namespace App\Services\DAO;


    use App\Entity\EnumSexo;
    use App\Interfaces\IDAO\IEnumDAO;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    class EnumSexoDAO implements IEnumDAO{

        private $em;

        public function __construct(EntityManagerInterface $em)
        {
            $this->em = $em;
        }

        /**
         * @param int $id
         * @return mixed $enumSexo
         */
        public function getObj(int $id){

            return $this->em->getRepository(EnumSexo::class)->find($id);

        }

        public function getAllObj(){

            return $this->em->getRepository(EnumSexo::class)->findBy([], ['descripcion' => 'ASC']);
        }

    }
