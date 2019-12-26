<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * EnumTipoDni
 *
 * @ORM\Table(name="enum_tipo_dni")
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */

class EnumTipoDni
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
     * EnumTipoDni constructor.
     */
    public function __construct()
    {
        $this->id = 0;
    }

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $idEnumtipodni
     */
    public function setId(int $idEnumtipodni)
    {
        $this->id = $idEnumtipodni;
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
