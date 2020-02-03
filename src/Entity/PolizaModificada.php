<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;



/**
 * PolizaModificada
 *
 * @ORM\Table(name="PolizaModificada", indexes={@ORM\Index(name="fk_coberturaModificada", columns={"tipoCobertura_id"}), @ORM\Index(name="fk_polizaOriginal", columns={"nro_poliza"})})
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */
class PolizaModificada
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="int", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(name="anio_vehiculo", type="integer", nullable=false)
     */
    private $anioVehiculo;

    /**
     * @var string
     * @ORM\Column(name="patente", type="string", length=30, nullable=false)
     */
    private $patente;

    /**
     * @var string
     * @ORM\Column(name="motor", type="string", length=30, nullable=false)
     */
    private $motor;

    /**
     * @var string
     * @ORM\Column(name="chasis", type="string", length=30, nullable=false)
     */
    private $chasis;

    /**
     * @var float
     * @ORM\Column(name="km_anio", type="float", precision=10, scale=0, nullable=false)
     */
    private $kmAnio;


    /**
     * @var int
     * @ORM\Column(name="num_siniestros_anio", type="integer", nullable=false)
     */
    private $numSiniestrosAnio;

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
     * @var int
     * @ORM\Column(name="nro_modificacion", type="integer", nullable=false)
     */
    private $nroModificacion;

    /**
     * @var TipoCobertura
     *
     * @ORM\ManyToOne(targetEntity="TipoCobertura")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipoCobertura_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $tipoCobertura;

    /**
     * @var Poliza
     * @ORM\ManyToOne(targetEntity="Poliza")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="nro_poliza", referencedColumnName="nro_poliza", nullable=false)
     * })
     */
    private $poliza;




    //Getters and Setters
    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $nroPolizaModif
     */
    public function setId(int $nroPolizaModif){
        $this->id = $nroPolizaModif;
    }

    /**
     * @return int
     */
    public function getAnioVehiculo(){
        return $this->anioVehiculo;
    }

    /**
     * @param int $anioVehiculo
     */
    public function setAnioVehiculo(int $anioVehiculo){
        $this->anioVehiculo = $anioVehiculo;
    }

    /**
     * @return string
     */
    public function getPatente(){
        return $this->patente;
    }

    /**
     * @param string $patente
     */
    public function setPatente(string $patente){
        $this->patente = $patente;
    }

    /**
     * @return string
     */
    public function getMotor(){
        return $this->motor;
    }

    /**
     * @param string $motor
     */
    public function setMotor(string $motor){
        $this->motor = $motor;
    }

    /**
     * @return string
     */
    public function getChasis(){
        return $this->chasis;
    }

    /**
     * @param string $chasis
     */
    public function setChasis(string $chasis){
        $this->chasis = $chasis;
    }

    /**
     * @return float
     */
    public function getKmAnio(){
        return $this->kmAnio;
    }

    /**
     * @param float $kmAnio
     */
    public function setKmAnio(float $kmAnio){
        $this->kmAnio = $kmAnio;
    }

    /**
     * @return int
     */
    public function getNumSiniestrosAnio(){
        return $this->numSiniestrosAnio;
    }

    /**
     * @param int $numSiniestrosAnio
     */
    public function setNumSiniestrosAnio(int $numSiniestrosAnio){
        $this->numSiniestrosAnio = $numSiniestrosAnio;
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
     * @return int
     */
    public function getNroModificacion(){
        return $this->nroModificacion;
    }

    /**
     * @param int $nroModificacion
     */
    public function setNroModificacion(int $nroModificacion){
        $this->nroModificacion = $nroModificacion;
    }

    /**
     * @return TipoCobertura
     */
    public function getTipoCobertura(){
        return $this->tipoCobertura;
    }

    /**
     * @param TipoCobertura $idCobertura
     */
    public function setIdCobertura(TipoCobertura $idCobertura){
        $this->tipoCobertura = $idCobertura;
    }

    /**
     * @return Poliza
     */
    public function getPoliza(){
        return $this->poliza;
    }

    /**
     * @param Poliza $nroPoliza
     */
    public function setPoliza(Poliza $nroPoliza){
        $this->poliza = $nroPoliza;
    }



}
