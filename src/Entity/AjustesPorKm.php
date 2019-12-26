<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * AjustesPorKm
 *
 * @ORM\Table(name="ajustes_por_km")
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */
//Esta entidad no debe mostrarse al FrontEnd
class AjustesPorKm
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     */
    private $id;

    /**
     * @var float
     * @ORM\Column(name="ajuste_por_km_realizados", type="float", precision=10, scale=0, nullable=false)
     */
    private $ajustePorKmRealizados;

    /**
     * @var int
     * @ORM\Column(name="valor_inicial", type="integer", nullable=false)
     */
    private $valorInicial;

    /**
     * @var int
     * @ORM\Column(name="valor_final", type="integer", nullable=false)
     */
    private $valorFinal;



    //Getters and Setters

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $idAjusteskm
     */
    public function setId(int $idAjusteskm){
        $this->id = $idAjusteskm;
    }

    /**
     * @return float
     */
    public function getValor(){
        return $this->ajustePorKmRealizados;
    }

    /**
     * @param float $ajustePorKmRealizados
     */
    public function setValor(float $ajustePorKmRealizados){
        $this->ajustePorKmRealizados = $ajustePorKmRealizados;
    }

    /**
     * @return int
     */
    public function getValorInicial(){
        return $this->valorInicial;
    }

    /**
     * @param int $valorInicial
     */
    public function setValorInicial($valorInicial){
        $this->valorInicial = $valorInicial;
    }

    /**
     * @return int
     */
    public function getValorFinal(){
        return $this->valorFinal;
    }

    /**
     * @param int $valorFinal
     */
    public function setValorFinal(int $valorFinal){
        $this->valorFinal = $valorFinal;
    }


}
