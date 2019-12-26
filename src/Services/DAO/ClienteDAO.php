<?php


    namespace App\Services\DAO;

    //Entidades
    use App\Entity\Cliente;

    //Doctrine
    use App\Entity\Cuota;
    use App\Interfaces\IDAO\IClienteDAO;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    class ClienteDAO implements IClienteDAO{

        private $em;

        /**
         * ClienteDAO constructor.
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
        public function getObj(int $id){

            return $this->em->getRepository(Cliente::class)->find($id);

        }

        /**
         * @param $id
         * @param $nombre
         * @param $apellido
         * @param $dni
         * @param $tipoDni
         * @return object[]
         */
        public function getAllObj($id, $nombre, $apellido, $dni, $tipoDni){

            return $this->em->getRepository(Cliente::class)->findBy(['id'=>$id, 'nombre'=>$nombre, 'apellido'=>$apellido, 'dni'=>$dni], ['apellido' => 'ASC']);
            /*$dql = "select c
                    from App:Cliente c
                    where c.id=:id and c.nombre=:nombre and c.apellido=:apellido and c.dni=:dni and c.enumTipoDni=:tipoDni";

            $query = $this->em->createQuery($dql);
            $query->setParameter('id', $id);
            $query->setParameter('nombre', $nombre);
            $query->setParameter('apellido', $apellido);
            $query->setParameter('dni', $dni);
            $query->setParameter('tipoDni', $tipoDni);

            return $query->getResult();*/

        }


    }
