<?php


namespace App\Services\DAO;


use App\Entity\Cliente;
use App\Entity\Cuota;
use App\Interfaces\IDAO\IClienteDAO;
use App\Services\HelperFilter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClienteDAO implements IClienteDAO{

    private $em;

    /**
     * ClienteDAO constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em){
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
     * @param $filters
     * @param $operators
     * @param $order_by
     * @param $limit
     * @param $offset
     *
     * @return object[]
     */
    //TODO No está funcionando la busqueda por EstadoCliente <> 3
     public function getAllObj($filters, $operators, $order_by, $limit, $offset){

         // armo los filtros
         $filterArray = [];
         $paramsArray = [];
         $joinWithArray = [];

         //Cada elemento del arreglo filters recibido como argumento es del tipo clave/campo - valor, donde valor contiene la informacion recibida para el filtro
         //Por cada elemento del arreglo filters va obteniendo los valores para crear la consulta
         foreach ($filters as $campo => $valor) {
             switch ($campo) {
                 case 'dni':
                 case 'id':
                     HelperFilter::makeNumeric('c', $campo, $valor, $operators, $filterArray, $paramsArray);
                     break;
                 case 'apellido':
                 case 'nombre';
                     HelperFilter::makeString('c', $campo, $valor, $operators, $filterArray, $paramsArray);
                     break;
                 case 'enumTipoDni.id':
                     $joinWithArray[] = 'JOIN c.enumTipoDni td ';
                     HelperFilter::makeId('td', 'id', $valor, $operators, $filterArray, $paramsArray);
                     break;
                 case 'estadoCliente.descripcion':
                     $joinWithArray[] = 'JOIN c.enumEstadoCliente ec ';
                     HelperFilter::makeString('ec', 'descripcion', $valor, $operators, $filterArray, $paramsArray);
                     break;
             }
         }

         //Esta parte lo que hace es generar el criterio de orden si es que ha alguno.
         $orderByArray = [];
         foreach ($order_by as $campo => $direccion) {
             switch ($campo) {
                 case 'id':
                     $orderByArray[] = 'c.id ' . $direccion;
                     break;
                 case 'dni';
                     $orderByArray[] = 'c.dni ' . $direccion;
                     break;
                 case 'apellido':
                     $orderByArray[] = 'c.apellido ' . $direccion;
                     break;
                 case 'nombre':
                     $orderByArray[] = 'c.nombre ' . $direccion;
                     break;
                 case 'enumTipoDni.id':
                     $orderByArray[] = 'td.id' . $direccion;
                     break;
                 case 'enumEstadoCliente.descripcion':
                     $orderByArray[] = 'ec.descripcion' . $direccion;
                     break;
             }
         }

         //Crea el string para el WHERE de la consulta con los valores de filtros
         $where = '';
         if (!empty($filterArray)) {
             $where = 'WHERE '.implode(' AND ', $filterArray);
         }

        //Crea el string para el ORDER BY de la consulta.
         $orderByStr = '';
         if (!empty($orderByArray)) {
             $orderByStr = ' ORDER BY ' . implode(' , ', $orderByArray);
         }


         $joinWithStr = '';
         if (!empty($joinWithArray)) {
             $joinWithStr = '' . implode(' ', $joinWithArray);
         }

         //Crea la consulta

         //Asi estaba definido en el ejemplo de afiliados.
         //"SELECT DISTINCT c,td FROM App:Cliente c JOIN c.enumTipoDni td $joinWithStr $where $orderByStr"
         //Lo diferente es lo de $joinWithStr que estaba diferente en los otros Repository

         $query = $this->em
             ->createQuery(
                 "SELECT DISTINCT c FROM App:Cliente c $joinWithStr $where $orderByStr"
             )
             ->setParameters($paramsArray)
             ->setMaxResults($limit)
             ->setFirstResult($offset);

         return $query->getResult();

     }


    /**
     * @param Cliente $cliente
     */
    public function save($cliente){

         $this->em->persist($cliente);
         $this->em->flush();

    }



}
