<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * EnumCondIva
 *
 * @ORM\Table(name="enum_cond_iva")
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */
class EnumCondIva
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Expose
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="descripcion", type="string", length=200, nullable=false)
     * @Expose
     */
    private $descripcion;




    //Getters and Setters
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $idEnumcondiva
     */
    public function setId(int $idEnumcondiva)
    {
        $this->id = $idEnumcondiva;
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
