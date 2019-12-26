<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * FactoresCaracteristicas
 *
 * @ORM\Table(name="factores_caracteristicas")
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */

//Front end no verá esta entidad
class FactoresCaracteristicas{

    /**
     * @var int
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var float
     * @ORM\Column(name="ajuste_por_hijo", type="float", precision=10, scale=0, nullable=false)
     */
    private $ajustePorHijo;

    /**
     * @var float
     * @ORM\Column(name="derecho_de_emision", type="float", precision=10, scale=0, nullable=false)
     */
    private $derechoDeEmision;

    /**
     * @var float
     * @ORM\Column(name="descuento_por_unidad_adicional", type="float", precision=10, scale=0, nullable=false)
     */
    private $descuentoPorUnidadAdicional;



    //Getters and Setters
    /**
     * @return int
     */
    public function getId(){

        return $this->id;
    }

    /**
     * @param int $idCaract
     */
    public function setId(int $idCaract){
        $this->id = $idCaract;
    }

    /**
     * @return float
     */
    public function getAjustePorHijo(){
        return $this->ajustePorHijo;
    }

    /**
     * @param float $ajustePorHijo
     */
    public function setAjustePorHijo(float $ajustePorHijo){
        $this->ajustePorHijo = $ajustePorHijo;
    }

    /**
     * @return float
     */
    public function getDerechoDeEmision(){
        return $this->derechoDeEmision;
    }

    /**
     * @param float $derechoDeEmision
     */
    public function setDerechoDeEmision(float $derechoDeEmision){
        $this->derechoDeEmision = $derechoDeEmision;
    }

    /**
     * @return float
     */
    public function getDescuentoPorUnidadAdicional(){
        return $this->descuentoPorUnidadAdicional;
    }

    /**
     * @param float $descuentoPorUnidadAdicional
     */
    public function setDescuentoPorUnidadAdicional(float $descuentoPorUnidadAdicional){
        $this->descuentoPorUnidadAdicional = $descuentoPorUnidadAdicional;
    }


}
