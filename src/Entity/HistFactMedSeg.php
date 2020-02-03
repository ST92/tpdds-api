<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * HistFactMedSeg
 *
 * @ORM\Table(name="hist_fact_med_seg", indexes={@ORM\Index(name="fk_usuario_histMedidas", columns={"usuario_id"}), @ORM\Index(name="fk_medidas_histMedidas", columns={"medidasSeguridad_id"})})
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */

class HistFactMedSeg
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
     * @ORM\Column(name="descripcion", type="string", length=150, nullable=false)
     */
    private $descripcion;

    /**
     * @var float
     * @ORM\Column(name="factor", type="float", precision=10, scale=0, nullable=false)
     */
    private $factor;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fecha_inicio_vigencia", type="date", nullable=false)
     */
    private $fechaInicioVigencia;

    /**
     * @var DateTime
     * @ORM\Column(name="fecha_fin_vigencia", type="date", nullable=false)
     */
    private $fechaFinVigencia;

    /**
     * @var MedidasSeguridad
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="MedidasSeguridad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="medidasSeguridad_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $medidaSeguridad;

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



    //Getters and Setters
    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $idHistFactMedSeg
     */
    public function setId(int $idHistFactMedSeg){
        $this->id = $idHistFactMedSeg;
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
    public function getFactor(){
        return $this->factor;
    }

    /**
     * @param float $factor
     */
    public function setFactor(float $factor){
        $this->factor = $factor;
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
     * @return MedidasSeguridad
     */
    public function getMedidaSeguridad(){
        return $this->medidaSeguridad;
    }

    /**
     * @param MedidasSeguridad $idMedidasseguridad
     */
    public function setMedidaSeguridad(MedidasSeguridad $idMedidasseguridad){
        $this->medidaSeguridad = $idMedidasseguridad;
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
