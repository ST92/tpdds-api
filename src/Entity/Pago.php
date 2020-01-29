<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
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
     *
     * @Expose
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
    //Se puede obtener fecha y hora de pago
    private $fecha;

    //Relación bidireccional con cuotas
    /**
     * @ORM\OneToMany(targetEntity="Cuota", mappedBy="pago", cascade={"persist", "remove"})
     * @var ArrayCollection
     * @Expose
     */
    private $listaCuotas;


    /**
     * Pago constructor.
     */
    public function __construct()
    {
        $this->id = 0;
        $this->listaCuotas = new ArrayCollection();

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
    public function getFecha(){
        return $this->fecha;
    }

    /**
     * @param DateTime $fecha
     */
    public function setFecha(DateTime $fecha){
        $this->fecha = $fecha;
    }

    /**
     * @return ArrayCollection
     */
    public function getListaCuotas()
    {
        return $this->listaCuotas;
    }

    /**
     * @param ArrayCollection $listaCuotas
     */
    public function setListaCuotas($listaCuotas)
    {
        $this->listaCuotas = $listaCuotas;
    }


}
