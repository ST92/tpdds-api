<?php


    namespace App\Services\DAO;


    use App\Entity\Hijo;
    use App\Interfaces\IDAO\IHijosDAO;
    use Doctrine\ORM\EntityManagerInterface;

    class HijoDAO implements IHijosDAO{

        private $em;

        public function __construct(EntityManagerInterface $em)
        {
            $this->em = $em;
        }


    }
