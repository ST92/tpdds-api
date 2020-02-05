<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;



/**
 * HistFactLocalidad
 * @ORM\Table(name="hist_fact_localidad", indexes={@ORM\Index(name="fk_usuario_histLocalidad", columns={"usuario_id"}), @ORM\Index(name="fk_localidad_histLocalidad", columns={"localidad_id"})})
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */

class HistFactLocalidad
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
     * @var float
     * @ORM\Column(name="fact_localidad", type="float", precision=10, scale=0, nullable=false)
     */
    private $factLocalidad;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fecha_inicio_vigencia", type="date", nullable=false)
     */
    private $fechaInicioVigencia;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="fecha_fin_vigencia", type="date", nullable=false)
     */
    private $fechaFinVigencia;

    /**
     * @var Localidad
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Localidad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="localidad_id", referencedColumnName="id")
     * })
     */
    private $localidad;

    /**
     * @var Usuario
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
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
     * @param int $idHistFactLocalidad
     */
    public function setId(int $idHistFactLocalidad){
        $this->id = $idHistFactLocalidad;
    }

    /**
     * @return float
     */
    public function getFactLocalidad(){
        return $this->factLocalidad;
    }

    /**
     * @param float $factLocalidad
     */
    public function setFactLocalidad(float $factLocalidad){
        $this->factLocalidad = $factLocalidad;
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
     * @return Localidad
     */
    public function getIdLocalidad(){
        return $this->localidad;
    }

    /**
     * @param Localidad $loc
     */
    public function setIdLocalidad(Localidad $loc){
        $this->localidad = $loc;
    }

    /**
     * @return Usuario
     */
    public function getIdUsuario(){
        return $this->usuario;
    }

    /**
     * @param Usuario $u
     */
    public function setIdUsuario(Usuario $u){
        $this->usuario = $u;
    }


}
