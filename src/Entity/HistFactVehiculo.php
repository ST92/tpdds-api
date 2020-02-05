<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;



/**
 * HistFactVehiculo
 *
 * @ORM\Table(name="hist_fact_vehiculo", indexes={@ORM\Index(name="fk_usuario_histVehiculo", columns={"usuario_id"}), @ORM\Index(name="fk_modelo_histVehiculo", columns={"modelo_id"})})
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */
class HistFactVehiculo
{
    /**
     * @var int
     *
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
     * @var float
     * @ORM\Column(name="robo_por_modelo", type="float", precision=10, scale=0, nullable=false)
     */
    private $roboPorModelo;

    /**
     * @var Modelo
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Modelo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="modelo_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $modelo;

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
     * @param int $idHistFactVehiculo
     */
    public function setId(int $idHistFactVehiculo){
        $this->id = $idHistFactVehiculo;
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
     * @return float
     */
    public function getRoboPorModelo(){
        return $this->roboPorModelo;
    }

    /**
     * @param float $roboPorModelo
     */
    public function setRoboPorModelo(float $roboPorModelo){
        $this->roboPorModelo = $roboPorModelo;
    }

    /**
     * @return Modelo
     */
    public function getModelo(){
        return $this->modelo;
    }

    /**
     * @param Modelo $idModelo
     */
    public function setModelo(Modelo $idModelo){
        $this->modelo = $idModelo;
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
