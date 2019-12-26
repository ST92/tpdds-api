<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * EnumTipoUsuario
 *
 * @ORM\Table(name="enum_tipo_usuario")
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */
class EnumTipoUsuario{

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
     * @ORM\Column(name="descripcion", type="string", length=150, nullable=false)
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
     * @param int $idEnumtipousuario
     */
    public function setId(int $idEnumtipousuario){
        $this->id = $idEnumtipousuario;
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
