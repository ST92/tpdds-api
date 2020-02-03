<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * TipoCobertura
 *
 * @ORM\Table(name="tipo_cobertura")
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */
class TipoCobertura
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
     * @var string|null
     * @ORM\Column(name="nombre", type="string", length=200, nullable=true)
     * @Expose
     */
    private $nombre;

    /**
     * @var string|null
     * @ORM\Column(name="descripcion", type="string", length=300, nullable=true)
     */
    private $descripcion;

    /**
     * @var float
     * @ORM\Column(name="valor", type="float", nullable=false)
     */
    private $valor;


    //Getters and Setters
    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $idCobertura
     */
    public function setId(int $idCobertura){
        $this->id = $idCobertura;
    }

    /**
     * @return string|null
     */
    public function getNombre(){
        return $this->nombre;
    }

    /**
     * @param string|null $nombre
     */
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    /**
     * @return string|null
     */
    public function getDescripcion(){
        return $this->descripcion;
    }

    /**
     * @param string|null $descripcion
     */
    public function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
    }

    /**
     * @return float
     */
    public function getValor(){
        return $this->valor;
    }

    /**
     * @param float $valor
     */
    public function setValor(float $valor){
        $this->valor = $valor;
    }


}
