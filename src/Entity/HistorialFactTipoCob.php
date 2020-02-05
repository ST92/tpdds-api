<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;



/**
 * HistorialFactTipoCob
 *
 * @ORM\Table(name="historial_fact_tipo_cob", indexes={@ORM\Index(name="fk_usuario_histCob", columns={"usuario_id"}), @ORM\Index(name="fk_cobertura_histCob", columns={"cobertura_id"})})
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */


class HistorialFactTipoCob
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
     * @ORM\Column(name="valor", type="float", precision=10, scale=0, nullable=false)
     */
    private $valor;

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
     * @var TipoCobertura
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="TipoCobertura")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cobertura_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $tipoCobertura;

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
     * @param int $idHistFactTipoCob
     */
    public function setId(int $idHistFactTipoCob){
        $this->id = $idHistFactTipoCob;
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
     * @return TipoCobertura
     */
    public function getTipoCobertura() {
        return $this->tipoCobertura;
    }

    /**
     * @param TipoCobertura $idCobertura
     */
    public function setIdCobertura(TipoCobertura $idCobertura){
        $this->tipoCobertura = $idCobertura;
    }

    /**
     * @return Usuario
     */
    public function getUsuario() {
        return $this->usuario;
    }

    /**
     * @param Usuario $idUsuario
     */
    public function setIdUsuario(Usuario $idUsuario){
        $this->usuario = $idUsuario;
    }


}
