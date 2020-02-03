<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * MedidasSeguridadModificadas
 *
 * @ORM\Table(name="medidas_seguridad_modificadas", indexes={@ORM\Index(name="fk_medMod_med", columns={"medidasSeguridad_id"}), @ORM\Index(name="fk_polizaMod_medidasMod", columns={"polizaMod_id"})})
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */

class MedidasSeguridadModificadas
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var MedidasSeguridad
     *
     * @ORM\ManyToOne(targetEntity="MedidasSeguridad")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="medidasSeguridad_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $medidasSeguridad;

    /**
     * @var PolizaModificada
     *
     * @ORM\ManyToOne(targetEntity="PolizaModificada")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="polizaMod_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $polizaMod;



    //Getters and Setters
    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $idMedidasModificadas
     */
    public function setId(int $idMedidasModificadas){
        $this->id = $idMedidasModificadas;
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
     * @return PolizaModificada
     */
    public function getPolizaMod(){
        return $this->polizaMod;
    }

    /**
     * @param PolizaModificada $nroPolizaModif
     */
    public function setPolizaMod(PolizaModificada $nroPolizaModif){
        $this->polizaMod = $nroPolizaModif;
    }


}
