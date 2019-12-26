<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * Usuario
 *
 * @ORM\Table(name="usuario", indexes={@ORM\Index(name="fk_tipousuario", columns={"enumTipoUsuario_id"})})
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */
class Usuario
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="nombre", type="string", length=50, nullable=false)
     */
    private $nombre;

    /**
     * @var string
     * @ORM\Column(name="password", type="string", length=50, nullable=false)
     */
    private $password;

    /**
     * @var EnumTipoUsuario
     *
     * @ORM\ManyToOne(targetEntity="EnumTipoUsuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="enumTipoUsuario_id", referencedColumnName="id")
     * })
     */
    private $enumTipoUsuario;


    //Getters and Setters
    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $idUsuario
     */
    public function setId(int $idUsuario){
        $this->id = $idUsuario;
    }

    /**
     * @return string
     */
    public function getNombre(){
        return $this->nombre;
    }

    /**
     * @param string $usuario
     */
    public function setNombre(string $usuario){
        $this->nombre = $usuario;
    }

    /**
     * @return string
     */
    public function getPassword(){
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password){
        $this->password = $password;
    }

    /**
     * @return EnumTipoUsuario
     */
    public function getIdEnumtipousuario(){
        return $this->enumTipoUsuario;
    }

    /**
     * @param EnumTipoUsuario $idEnumtipousuario
     */
    public function setIdEnumtipousuario(EnumTipoUsuario $idEnumtipousuario){
        $this->enumTipoUsuario = $idEnumtipousuario;
    }


}
