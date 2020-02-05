<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;



/**
 * HistorialSiniestrosFc
 *
 * @ORM\Table(name="historial_siniestros_fc", indexes={@ORM\Index(name="fk_usuario_histSiniestros", columns={"usuario_id"}), @ORM\Index(name="fk_siniestros_histSiniestros", columns={"siniestros_id"})})
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */
class HistorialSiniestrosFc
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     *
     */
    private $id;
    //@ORM\GeneratedValue(strategy="IDENTITY")
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
     * @var string
     * @ORM\Column(name="descripcion", type="string", length=100, nullable=false)
     */
    private $descripcion;

    /**
     * @var float
     * @ORM\Column(name="valor", type="float", precision=10, scale=0, nullable=false)
     */
    private $valor;

    /**
     * @var SiniestrosFc
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="SiniestrosFc")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="siniestros_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $siniestrosFC;

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
     * @param int $idSiniestrosHist
     */
    public function setId(int $idSiniestrosHist){
        $this->id = $idSiniestrosHist;
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

    /**
     * @return SiniestrosFc
     */
    public function getSiniestrosFc(){
        return $this->siniestrosFC;
    }

    /**
     * @param SiniestrosFc $idSiniestros
     */
    public function setSiniestrosFc(SiniestrosFc $idSiniestros){
        $this->siniestrosFC = $idSiniestros;
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
    public function setIdUsuario(Usuario $idUsuario){
        $this->usuario = $idUsuario;
    }


}
