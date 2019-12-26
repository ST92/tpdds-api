<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * MedidasSeguridad
 *
 * @ORM\Table(name="MedidasSeguridad")
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */
class MedidasSeguridad
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
     * @ORM\Column(name="descripcion", type="string", length=150, nullable=false)
     * @Expose
     */
    private $descripcion;

    /**
     * @var float
     * @ORM\Column(name="factor", type="float", precision=10, scale=0, nullable=false)
     */
    private $factor;





    //Getters and Setters

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $idMedidasseguridad
     */
    public function setId(int $idMedidasseguridad){
        $this->id = $idMedidasseguridad;
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
        return $this->factor;
    }

    /**
     * @param float $factor
     */
    public function setValor(float $factor){
        $this->factor = $factor;
    }


}
