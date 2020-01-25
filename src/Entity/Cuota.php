<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * Cuota
 *
 * @ORM\Table(name="cuota", indexes={@ORM\Index(name="fk_pagoPoliza", columns={"poliza_id"}), @ORM\Index(name="fk_pago", columns={"pago_id"})})
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */
class Cuota{

    /**
     * @var int
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(name="num_cuota", type="integer", nullable=false)
     * @Expose
     */
    private $numCuota;

    /**
     * @var DateTime
     * @ORM\Column(name="fecha_vencimiento", type="date", nullable=false)
     * @Expose
     */
    private $fechaVencimiento;

    /**
     * @var float
     * @ORM\Column(name="monto", type="float", precision=10, scale=0, nullable=false)
     * @Expose
     */
    private $monto;


    //Este se actualiza al realizar pago
    /**
     * @var float
     * @ORM\Column(name="recargos", type="float", precision=10, scale=0, nullable=true)
     * @Expose
     */
    private $recargos;

    //Este se actualizan al realizar pago
    /**
     * @var float
     * @ORM\Column(name="bonificacion_pago_adelantado", type="float", precision=10, scale=0, nullable=true)
     * @Expose
     */
    private $bonificacionPagoAdelantado;

    //Este se actualizan al realizar pago
    /**
     * @var Pago
     * @ORM\ManyToOne(targetEntity="Pago", cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pago_id", referencedColumnName="id")
     * })
     * @Expose
     */
    private $pago;

    /**
     * @var Poliza
     * @ORM\ManyToOne(targetEntity="Poliza", inversedBy = "listaCuotas", cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="poliza_id", referencedColumnName="nro_poliza")
     * })
     */
    private $poliza;



    //Getters and Setters

    /**
     * Cuota constructor.
     */
    public function __construct()
    {
        $this->id = 0;
    }

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $idCuota
     */
    public function setId(int $idCuota){
        $this->id = $idCuota;
    }

    /**
     * @return int
     */
    public function getNumCuota(){
        return $this->numCuota;
    }

    /**
     * @param int $numCuota
     */
    public function setNumCuota(int $numCuota){
        $this->numCuota = $numCuota;
    }

    /**
     * @return DateTime
     */
    public function getFechaVencimiento(){
        return $this->fechaVencimiento;
    }

    /**
     * @param DateTime $fechaVencimiento
     */
    public function setFechaVencimiento($fechaVencimiento){
        $this->fechaVencimiento = $fechaVencimiento;
    }

    /**
     * @return float
     */
    public function getMonto()
    {
        return $this->monto;
    }

    /**
     * @param float $monto
     */
    public function setMonto(float $monto)
    {
        $this->monto = $monto;
    }

    /**
     * @return float
     */
    public function getRecargos(){
        return $this->recargos;
    }

    /**
     * @param float $recargos
     */
    public function setRecargos(float $recargos){
        $this->recargos = $recargos;
    }

    /**
     * @return float
     */
    public function getBonificacionPagoAdelantado(){
        return $this->bonificacionPagoAdelantado;
    }

    /**
     * @param float $bonificacionPagoAdelantado
     */
    public function setBonificacionPagoAdelantado(float $bonificacionPagoAdelantado){
        $this->bonificacionPagoAdelantado = $bonificacionPagoAdelantado;
    }

    /**
     * @return Pago
     */
    public function getPago() {
        return $this->pago;
    }

    /**
     * @param Pago $p
     */
    public function setPago($p){
        $this->pago = $p;
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
    public function setPoliza($nroPoliza){

        $this->poliza = $nroPoliza;
    }


}
