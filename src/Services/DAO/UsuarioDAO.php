<?php


namespace App\Services\DAO;


use App\Interfaces\IDAO\IUsuarioDAO;
use Doctrine\ORM\EntityManagerInterface;

class UsuarioDAO implements IUsuarioDAO {

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


}