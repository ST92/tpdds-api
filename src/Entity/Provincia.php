<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * Provincia
 *
 * @ORM\Table(name="provincia")
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */
class Provincia
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @Expose
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="nombre_provincia", type="string", length=150, nullable=false)
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
     * @param int $idProvincia
     */
    public function setId(int $idProvincia){
        $this->id = $idProvincia;
    }

    /**
     * @return string
     */
    public function getNombre(){
        return $this->nombre;
    }

    /**
     * @param string $nombreProvincia
     */
    public function setNombre(string $nombreProvincia){
        $this->nombre = $nombreProvincia;
    }


}
