<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * MsVehiculo
 *
 * @ORM\Table(name="ms_vehiculo", indexes={@ORM\Index(name="fk_medidas_ms", columns={"medidasSeguridad_id"}), @ORM\Index(name="fk_vehiculo_ms", columns={"vehiculo_id"})})
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */
//TODO Esta entidad creo que no va
class MsVehiculo
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Expose
     */
    private $id;

    /**
     * @var MedidasSeguridad
     *
     * @ORM\ManyToOne(targetEntity="MedidasSeguridad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="medidasSeguridad_id", referencedColumnName="id")
     * })
     */
    private $medidasSeguridad;

    /**
     * @var Vehiculo
     *
     * @ORM\ManyToOne(targetEntity="Vehiculo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="vehiculo_id", referencedColumnName="id")
     * })
     */
    private $vehiculo;



    //Getters and Setters
    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $idMsVehiculo
     */
    public function setId(int $idMsVehiculo){
        $this->id = $idMsVehiculo;
    }

    /**
     * @return MedidasSeguridad
     */
    public function getMedidasseguridad(){
        return $this->medidasSeguridad;
    }

    /**
     * @param MedidasSeguridad $idMedidasseguridad
     */
    public function setMedidasseguridad(MedidasSeguridad $idMedidasseguridad){
        $this->medidasSeguridad = $idMedidasseguridad;
    }

    /**
     * @return Vehiculo
     */
    public function getVehiculo(){
        return $this->vehiculo;
    }

    /**
     * @param Vehiculo $idAuto
     */
    public function setIdAuto(Vehiculo $idAuto){
        $this->vehiculo = $idAuto;
    }


}
