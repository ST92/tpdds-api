<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;



/**
 * Pago
 *
 * @ORM\Table(name="pago")
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */
class Pago
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var float
     * @ORM\Column(name="monto", type="float", precision=10, scale=0, nullable=false)
     * @Expose
     */
    private $monto;

    /**
     * @var DateTime
     * @ORM\Column(name="fecha", type="date", nullable=false)
     * @Expose
     */
    private $fecha;

    /**
     * Pago constructor.
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
     * @param int $idPago
     */
    public function setId(int $idPago){
        $this->id = $idPago;
    }

    /**
     * @return int
     */
    public function getMes(){
        return $this->mes;
    }

    /**
     * @param int $mes
     */
    public function setMes(int $mes){
        $this->mes = $mes;
    }

    /**
     * @return float
     */
    public function getMonto(){
        return $this->monto;
    }

    /**
     * @param float $monto
     */
    public function setMonto(float $monto){
        $this->monto = $monto;
    }

    /**
     * @return DateTime
     */
    public function getHora(){
        return $this->hora;
    }

    /**
     * @param DateTime $hora
     */
    public function setHora(DateTime $hora){
        $this->hora = $hora;
    }

    /**
     * @return DateTime
     */
    public function getFecha(){
        return $this->fecha;
    }

    /**
     * @param DateTime $fecha
     */
    public function setFecha(DateTime $fecha){
        $this->fecha = $fecha;
    }


}
