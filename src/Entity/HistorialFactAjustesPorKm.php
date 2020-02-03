<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;



/**
 * HistorialFactAjustesPorKm
 *
 * @ORM\Table(name="historial_fact_ajustes_por_km", indexes={@ORM\Index(name="fk_ajustes_histAjustes", columns={"ajusteskm_id"}), @ORM\Index(name="fk_usuario_histAjustes", columns={"usuario_id"})})
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */

class HistorialFactAjustesPorKm
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
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

    /**
     * @var DateTime
     * @ORM\Column(name="fecha_inicio_vigencia", type="date", nullable=false)
     */
    private $fechaInicioVigencia;

    /**
     * @var DateTime
     * @ORM\Column(name="fecha_fin_vigencia", type="date", nullable=false)
     */
    private $fechaFinVigencia;

    /**
     * @var AjustesPorKm
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="AjustesPorKm")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ajusteskm_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $ajustesKm;

    /**
     * @var Usuario
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $usuario;

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $idHistFactAjusteskm
     */
    public function setId(int $idHistFactAjusteskm){
        $this->id = $idHistFactAjusteskm;
    }

    /**
     * @return float
     */
    public function getAjustePorKmRealizados(){
        return $this->ajustePorKmRealizados;
    }

    /**
     * @param float $ajustePorKmRealizados
     */
    public function setAjustePorKmRealizados(float $ajustePorKmRealizados){
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
    public function setValorInicial(int $valorInicial){
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

    /**
     * @return DateTime
     */
    public function getFechaInicioVigencia(){
        return $this->fechaInicioVigencia;
    }

    /**
     * @param DateTime $fechaInicioVigencia
     */
    public function setFechaInicioVigencia(DateTime $fechaInicioVigencia){
        $this->fechaInicioVigencia = $fechaInicioVigencia;
    }

    /**
     * @return DateTime
     */
    public function getFechaFinVigencia(){
        return $this->fechaFinVigencia;
    }

    /**
     * @param DateTime $fechaFinVigencia
     */
    public function setFechaFinVigencia(DateTime $fechaFinVigencia){
        $this->fechaFinVigencia = $fechaFinVigencia;
    }

    /**
     * @return AjustesPorKm
     */
    public function getAjusteskm(){
        return $this->ajustesKm;
    }

    /**
     * @param AjustesPorKm $idAjusteskm
     */
    public function setAjusteskm(AjustesPorKm $idAjusteskm){
        $this->ajustesKm = $idAjusteskm;
    }

    /**
     * @return Usuario
     */
    public function getUsuario(){

        return $this->usuario;
    }

    /**
     * @param Usuario $idUsuario
     */
    public function setUsuario(Usuario $idUsuario){
        $this->usuario = $idUsuario;
    }


}
