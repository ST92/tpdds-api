<?php


namespace App\Services\DAO;

//Entidades
use App\Entity\Localidad;

//Doctrine
use App\Interfaces\IDAO\ILocalidadDAO;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LocalidadDAO implements ILocalidadDAO {

    private $em;

    /**
     * LocalidadDAO constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * @param int $id
     * @return object|null
     */
    public function getObj(int $id){

        return $this->em->getRepository(Localidad::class)->find($id);

    }

    /**
     * @return object[]
     */
    public function getAllObj(){

        //Es nombre del atributo en Entity, no de BD
        return $this->em->getRepository(Localidad::class)->findBy([], ['nombreLocalidad' => 'ASC']);

    }

}
