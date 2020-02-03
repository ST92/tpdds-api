<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;



/**
 * HistorialFactoresCaract
 *
 * @ORM\Table(name="historial_factores_caract", indexes={@ORM\Index(name="fk_usuario_histCaracteristicas", columns={"usuario_id"}), @ORM\Index(name="fk_caract_histCaracteristicas", columns={"caract_id"})})
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */

class HistorialFactoresCaract
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

    /**
     * @var DateTime
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
     * @var FactoresCaracteristicas
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="FactoresCaracteristicas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="caract_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $factoresCaracteristicas;

    /**
     * @var Usuario
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
     * @param int $idHistCaract
     */
    public function setId(int $idHistCaract){
        $this->id = $idHistCaract;
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
     * @return FactoresCaracteristicas
     */
    public function getFactoresCaracteristicas(){
        return $this->factoresCaracteristicas;
    }

    /**
     * @param FactoresCaracteristicas $idCaract
     */
    public function setFactoresCaracteristicas(FactoresCaracteristicas $idCaract){
        $this->factoresCaracteristicas = $idCaract;
    }

    /**
     * @return Usuario
     */
    public function getUsuario(){
        return $this->usuario;
    }

    /**
     * @param Usuario $u
     */
    public function setUsuario(Usuario $u){
        $this->usuario = $u;
    }


}
