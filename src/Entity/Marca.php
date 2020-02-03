<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;



/**
 * Marca
 *
 * @ORM\Table(name="marca")
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */

class Marca{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @Expose
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="nombre", type="string", length=150, nullable=false)
     * @Expose
     */
    private $nombre;


    //Getters and Setters
    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $idMarca
     */
    public function setId(int $idMarca){
        $this->id = $idMarca;
    }

    /**
     * @return string
     */
    public function getNombre(){
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre(string $nombre){
        $this->nombre = $nombre;
    }


}
