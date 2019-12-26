<?php


namespace App\Services\DAO;


use App\Entity\Marca;
use App\Interfaces\IDAO\IMarcaDAO;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MarcaDAO implements IMarcaDAO{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * @param int $id
     * @return mixed
     */
    public function getObj($id){

        return $this->em->getRepository(Marca::class)->find($id);

    }

    public function getAllObj(){

        return $this->em->getRepository(Marca::class)->findBy([], ['nombre' => 'ASC']);

    }

}
