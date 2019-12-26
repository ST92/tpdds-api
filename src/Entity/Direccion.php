<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Direccion
 *
 * @ORM\Table(name="direccion", indexes={@ORM\Index(name="fk_localidad", columns={"localidad_id"})})
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */

class Direccion
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
     * @var string
     * @ORM\Column(name="nombre_calle", type="string", length=150, nullable=false)
     * @Expose
     */
    private $nombreCalle;

    /**
     * @var int
     * @ORM\Column(name="num_calle", type="integer", nullable=false)
     * @Expose
     */
    private $numCalle;

    /**
     * @var string
     * @ORM\Column(name="num_dpto", type="string", length=7, nullable=true)
     * @Expose
     */
    private $numDpto;

    /**
     * @var Localidad
     * @ORM\ManyToOne(targetEntity="Localidad", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="localidad_id", referencedColumnName="id")
     * })
     * @Expose
     */
    private $localidad;


    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $idDireccion
     */
    public function setId(int $idDireccion){
        $this->id = $idDireccion;
    }

    /**
     * @return string
     */
    public function getNombreCalle(){
        return $this->nombreCalle;
    }

    /**
     * @param string $nombreCalle
     */
    public function setNombreCalle(string $nombreCalle){
        $this->nombreCalle = $nombreCalle;
    }

    /**
     * @return int
     */
    public function getNumCalle(){
        return $this->numCalle;
    }

    /**
     * @param int $numCalle
     */
    public function setNumCalle(int $numCalle){
        $this->numCalle = $numCalle;
    }

    /**
     * @return string
     */
    public function getNumDpto(){
        return $this->numDpto;
    }

    /**
     * @param string $numDpto
     */
    public function setNumDpto(string $numDpto){
        $this->numDpto = $numDpto;
    }

    /**
     * @return Localidad
     */
    public function getLocalidad(){
        return $this->localidad;
    }

    /**
     * @param Localidad $loc
     */
    public function setLocalidad($loc){
        $this->localidad = $loc;
    }


}
