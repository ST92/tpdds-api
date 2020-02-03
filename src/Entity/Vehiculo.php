<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * Vehiculo
 *
 * @ORM\Table(name="vehiculo", indexes={@ORM\Index(name="fk_modelo", columns={"modelo_id"})})
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */
class Vehiculo
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(name="anio_vehiculo", type="integer", nullable=false)
     * @Expose
     */
    private $anioVehiculo;

    /**
     * @var string
     * @ORM\Column(name="motor", type="string", length=30, nullable=false)
     * @Expose
     */
    private $motor;

    /**
     * @var string
     * @ORM\Column(name="chasis", type="string", length=30, nullable=false)
     * @Expose
     */
    private $chasis;

    /**
     * @var string
     * @ORM\Column(name="patente", type="string", length=30, nullable=true)
     * @Expose
     */
    private $patente;

    /**
     * @var Modelo
     * @ORM\ManyToOne(targetEntity="Modelo", cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="modelo_id", referencedColumnName="id", nullable=false)
     * })
     * @Expose
     */
    private $modelo;

    //Relación n a n

    /**
     * @ORM\ManyToMany(targetEntity="MedidasSeguridad", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="vehiculo_ms_vehiculo",joinColumns={@ORM\JoinColumn(name="vehiculo_id", referencedColumnName = "id")}, inverseJoinColumns={@ORM\JoinColumn(name="medidasSeguridad_id", referencedColumnName = "id")})
     * @Expose
     */
    private $medidasSeguridad;


    /**
     * Vehiculo constructor.
     */
    public function __construct(){
        $this->medidasSeguridad = new ArrayCollection();
        $this->id=0;
    }


    //Getters and Setters
    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $idAuto
     */
    public function setId(int $idAuto){
        $this->id = $idAuto;
    }

    /**
     * @return int
     */
    public function getAnioVehiculo(){
        return $this->anioVehiculo;
    }

    /**
     * @param int $anioVehiculo
     */
    public function setAnioVehiculo(int $anioVehiculo){
        $this->anioVehiculo = $anioVehiculo;
    }

    /**
     * @return string
     */
    public function getMotor(){
        return $this->motor;
    }

    /**
     * @param string $motor
     */
    public function setMotor(string $motor){
        $this->motor = $motor;
    }

    /**
     * @return string
     */
    public function getChasis(){
        return $this->chasis;
    }

    /**
     * @param string $chasis
     */
    public function setChasis(string $chasis){
        $this->chasis = $chasis;
    }

    /**
     * @return string
     */
    public function getPatente(){
        return $this->patente;
    }

    /**
     * @param string $patente
     */
    public function setPatente(string $patente){
        $this->patente = $patente;
    }

    /**
     * @return Modelo
     */
    public function getModelo(){
        return $this->modelo;
    }

    /**
     * @param Modelo $mod
     */
    public function setModelo($mod){

        $this->modelo = $mod;
    }

    /**
     * @param MedidasSeguridad $med
    */
    public function agregarMedida($med){
        $this->medidasSeguridad->add($med);
    }

    /**
     * @return ArrayCollection
     */
    public function getListaMedidas()
    {
        return $this->medidasSeguridad;
    }

    /**
     * @param $medidasSeguridad
     */
    public function setListaMedidas($medidasSeguridad)
    {
        $this->medidasSeguridad = $medidasSeguridad;
    }



}
