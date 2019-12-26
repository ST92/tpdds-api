<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * SiniestrosFc
 *
 * @ORM\Table(name="siniestros_fc")
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */
class SiniestrosFc
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

    /**
     * @var float
     * @ORM\Column(name="valor", type="float", precision=10, scale=0, nullable=false)
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
     * @param int $idSiniestros
     */
    public function setId(int $idSiniestros){
        $this->id = $idSiniestros;
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
