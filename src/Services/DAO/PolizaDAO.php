<?php

namespace App\Services\DAO;

    //Entidades
use App\Entity\Cliente;
use App\Entity\EnumEstadoPoliza;
use App\Entity\Poliza;

    //Doctrine
    use App\Interfaces\IDAO\IPolizaDAO;
    use Doctrine\ORM\EntityManagerInterface;
    use phpDocumentor\Reflection\Types\Integer;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    class PolizaDAO implements IPolizaDAO{


        private $em;

        public function __construct(EntityManagerInterface $em)
        {
            $this->em = $em;
        }


        /**
         * @param int | Integer $id
         * @return object|null
         */
        public function getObj(int $id){

            return $this->em->getRepository(Poliza::class)->find($id);

        }


        /**
         * @param Poliza $poliza
         */
        public function save($poliza){

            $this->em->persist($poliza);
            $this->em->flush();

        }

        /**
         * @param $obj
         * @return mixed
         * @throws
         */
        public function countObj($obj){


            $dql = "select count(a.nroPoliza)
                    from App:Poliza a
                    where a.cliente=:cliente";

            $query = $this->em->createQuery($dql);
            $query->setParameter('cliente', $obj);

            return $query->getSingleScalarResult();

        }

        /**
         * @param $cliente
         * @param $estado
         * @return mixed
         * @throws
         *
         */
        public function countPolizaPorEstado($cliente, $estado){

            $dql = "select count(a.nroPoliza)
                    from App:Poliza a
                    where a.cliente=:cliente and a.estadoPoliza=:estado";

            $query = $this->em->createQuery($dql);
            $query->setParameter('cliente', $cliente);
            $query->setParameter('estado', $estado);

            return $query->getSingleScalarResult();

        }

        /**
         * @param $campo
         * @param $valor
         * @param $estado
         * @return mixed
         * @throws
         */
        public function findVehiculoActivo($campo, $valor, $estado){

            $dql = "select count(p.nroPoliza)
                    from App:Poliza p join App:Vehiculo v 
                    where v.".$campo."=:valor and p.estadoPoliza <> :es";

            $query = $this->em->createQuery($dql);
            $query->setParameter('valor', $valor);
            $query->setParameter('es', $estado);

            return $query->getSingleScalarResult();

        }

        /**
         * @return object[]
         */
        public function getAllObj(){

            return $this->em->getRepository(Poliza::class)->findBy([], ['nroPoliza' => 'ASC']);

        }

    }
