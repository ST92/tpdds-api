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
     * @param $estadoCliente
     * @return object[]
     */
        public function getAllObj($id, $nombre, $apellido, $dni, $tipoDni, $estadoCliente){

            /*$dql = "SELECT c
                    FROM App:Cliente c
                    WHERE c.id=:id AND c.nombre LIKE :nombre AND c.apellido LIKE :apellido AND c.dni=:dni AND c.enumTipoDni=:tipoDni";

            $query = $this->em->createQuery($dql);
            $query->setParameter('id', $id);
            $query->setParameter('nombre', $nombre.'%');
            $query->setParameter('apellido', $apellido.'%');
            $query->setParameter('dni', $dni);
            $query->setParameter('tipoDni', $tipoDni);

            return $query->getResult();*/

            //Valores distintos al estado enviado como parámetro
            $qb = $this->em->createQueryBuilder()
                ->select('c')
                ->from('App:Cliente', 'c')
                ->where('c.enumEstadoCliente <> :estado')
                ->setParameter('estado', $estadoCliente);

            if ($id) {
                $qb->Where('c.id = :id')
                    ->setParameter('id', $id);
            }
            if ($nombre) {
                $qb->andWhere('c.nombre LIKE :nombre')
                    ->setParameter('nombre', $nombre.'%');
            }
            if ($apellido) {
                $qb->andWhere('c.apellido LIKE :apellido')
                    ->setParameter('apellido', $apellido.'%');
            }
            if ($dni) {
                $qb->andWhere('c.dni = :dni')
                    ->setParameter('dni', $dni);
            }
            if ($tipoDni) {
                $qb->andWhere('c.enumTipoDni = :tipoDni')
                    ->setParameter('tipoDni', $tipoDni);
            }

            $query= $qb->getQuery();
            return $query->getResult();

        }


}
