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

        public function save($cuota){

            $this->em->persist($cuota);
            $this->em->flush();

        }

        public function countCuotasImpagas($cliente, $estado){

            $dql = "select c
                    from App:Cliente cl join App:Poliza p join App:Cuota c
                    where p.cliente= :cli and c.poliza= p and p.estadoPoliza <> :es";

            $query = $this->em->createQuery($dql);
            $query->setParameter('cli', $cliente);
            $query->setParameter('es', $estado);
            //$query->setParameter('nulo', null);

            $cuotas = $query->getResult();
            $i=0;

            foreach ($cuotas as $c){

                if(is_null($c->getPago())){
                    $i++;
                }
            }

            //return $query->getSingleScalarResult();
            return $i;
            //return $query->getResult();
        }
    }
