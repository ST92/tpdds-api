<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * EnumSexo
 *
 * @ORM\Table(name="enum_sexo")
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */
class EnumSexo
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Expose
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="descripcion", type="string", length=100, nullable=false)
     * @Expose
     */
    private $descripcion;



    //Getters and Setters

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $idEnumsexo
     */
    public function setId(int $idEnumsexo){
        $this->id = $idEnumsexo;
    }

    /**
     * @return string
     */
    public function getDescripcion(){
        return $this->descripcion;
    }

    /**
     * @param string $descripcion
     */
    public function setDescripcion(string $descripcion){
        $this->descripcion = $descripcion;
    }


}
