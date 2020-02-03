<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Cliente
 *
 * @ORM\Table(name="cliente", indexes={@ORM\Index(name="fk_condIva", columns={"enumCondIva_id"}), @ORM\Index(name="fk_sexo", columns={"enumSexo_id"}), @ORM\Index(name="fk_direccion", columns={"direccion_id"}), @ORM\Index(name="fk_TipoDni", columns={"enumTipoDni_id"}), @ORM\Index(name="fk_estadoCliente", columns={"enumEstadoCliente_id"}), @ORM\Index(name="fk_estadoCivil", columns={"enumEstadoCivil_id"})})
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */

class Cliente
{
    /**
     * @var int
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @Expose
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(name="dni", type="bigint", nullable=false)
     * @Expose
     */
    private $dni;

    /**
     * @var int
     * @ORM\Column(name="cuil_cuit", type="bigint", nullable=false)
     * @Expose
     */
    private $cuilCuit;


    /**
     * @var Date
     * @ORM\Column(name="fecha_nac", type="date", nullable=false)
     * @Expose
     */
    private $fechaNac;


    /**
     * @var string
     * @ORM\Column(name="apellido", type="string", length=200, nullable=false)
     * @Expose
     */
    private $apellido;

    /**
     * @var string
     * @ORM\Column(name="nombre", type="string", length=200, nullable=false)
     * @Expose
     */
    private $nombre;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=200, nullable=false)
     * @Expose
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(name="profesion", type="string", length=200, nullable=false)
     * @Expose
     */
    private $profesion;

    /**
     * @var int
     * @ORM\Column(name="anio_registro", type="integer", nullable=false)
     * @Expose
     */
    private $anioRegistro;

    /**
     * @var EnumTipoDni
     * @ORM\ManyToOne(targetEntity="EnumTipoDni", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="enumTipoDni_id", referencedColumnName="id", nullable=false)
     * })
     * @Expose
     */
    private $enumTipoDni;

    /**
     * @var EnumCondIva
     *
     * @ORM\ManyToOne(targetEntity="EnumCondIva", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="enumCondIva_id", referencedColumnName="id", nullable=false)
     * })
     * @Expose
     */
    private $enumCondIva;

    /**
     * @var Direccion
     * @ORM\ManyToOne(targetEntity="Direccion", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="direccion_id", referencedColumnName="id", nullable=false)
     * })
     * @Expose
     */
    private $direccion;

    /**
     * @var EnumEstadoCivil
     * @ORM\ManyToOne(targetEntity="EnumEstadoCivil", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="enumEstadoCivil_id", referencedColumnName="id", nullable=false)
     * })
     * @Expose
     */
    private $enumEstadoCivil;

    /**
     * @var EnumEstadoCliente
     * @ORM\ManyToOne(targetEntity="EnumEstadoCliente", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="enumEstadoCliente_id", referencedColumnName="id", nullable=false)
     * })
     *
     */
    private $enumEstadoCliente;

    /**
     * @var EnumSexo
     * @ORM\ManyToOne(targetEntity="EnumSexo", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="enumSexo_id", referencedColumnName="id", nullable=false)
     * })
     * @Expose
     */
    private $enumSexo;




    //Getters and Setters
    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $idCliente
     */
    public function setId(int $idCliente){
        $this->id = $idCliente;
    }

    /**
     * @return int
     */
    public function getDni(){
        return $this->dni;
    }

    /**
     * @param int $dni
     */
    public function setDni(int $dni){
        $this->dni = $dni;
    }

    /**
     * @return int
     */
    public function getCuilCuit(){
        return $this->cuilCuit;
    }

    /**
     * @param int $cuilCuit
     */
    public function setCuilCuit(int $cuilCuit){
        $this->cuilCuit = $cuilCuit;
    }

    /**
     * @return DateTime
     */
    public function getFechaNac(){
        return $this->fechaNac;
    }

    /**
     * @param DateTime $fechaNac
     */
    public function setFechaNac(DateTime $fechaNac){
        $this->fechaNac = $fechaNac;
    }

    /**
     * @return string
     */
    public function getApellido(){
        return $this->apellido;
    }

    /**
     * @param string $apellido
     */
    public function setApellido($apellido){
        $this->apellido = $apellido;
    }

    /**
     * @return string
     */
    public function getNombre(){
        return $this->nombre;
    }

    /**
     * @param string $nombre
     */
    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    /**
     * @return int
     */
    public function getCantidadSiniestros(){
        return $this->cantidadSiniestros;
    }

    /**
     * @param int $cantidadSiniestros
     */
    public function setCantidadSiniestros($cantidadSiniestros){
        $this->cantidadSiniestros = $cantidadSiniestros;
    }

    /**
     * @return string
     */
    public function getEmail(){
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email){
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getProfesion(){
        return $this->profesion;
    }

    /**
     * @param string $profesion
     */
    public function setProfesion($profesion){
        $this->profesion = $profesion;
    }

    /**
     * @return integer
     */
    public function getAnioRegistro(){
        return $this->anioRegistro;
    }

    /**
     * @param DateTime $anioRegistro
     */
    public function setAnioRegistro($anioRegistro){
        $this->anioRegistro = $anioRegistro;
    }

    /**
     * @return EnumTipoDni
     */
    public function getEnumtipodni(){
        return $this->enumTipoDni;
    }

    /**
     * @param EnumTipoDni $idEnumtipodni
     */
    public function setEnumtipodni($idEnumtipodni){
        $this->enumTipoDni = $idEnumtipodni;
    }

    /**
     * @return EnumCondIva
     */
    public function getEnumcondiva(){
        return $this->enumCondIva;
    }

    /**
     * @param EnumCondIva $idEnumcondiva
     */
    public function setEnumcondiva($idEnumcondiva){
        $this->enumCondIva = $idEnumcondiva;
    }

    /**
     * @return Direccion
     */
    public function getDireccion(){
        return $this->direccion;
    }

    /**
     * @param Direccion $idDireccion
     */
    public function setDireccion($idDireccion){
        $this->direccion = $idDireccion;
    }

    /**
     * @return EnumEstadoCivil
     */
    public function getEnumEstadoCivil(){
        return $this->enumEstadoCivil;
    }

    /**
     * @param EnumEstadoCivil $idEnumestadocivil
     */
    public function setEnumEstadoCivil($idEnumestadocivil){
        $this->enumEstadoCivil = $idEnumestadocivil;
    }

    /**
     * @return EnumEstadoCliente
     */
    public function getEnumEstadoCliente(){
        return $this->enumEstadoCliente;
    }

    /**
     * @param EnumEstadoCliente $idEnumestadocliente
     */
    public function setEnumEstadocliente($idEnumestadocliente){
        $this->enumEstadoCliente = $idEnumestadocliente;
    }

    /**
     * @return EnumSexo
     */
    public function getEnumSexo()
    {
        return $this->enumSexo;
    }

    /**
     * @param EnumSexo $idEnumsexo
     */
    public function setEnumsexo($idEnumsexo){
        $this->enumSexo = $idEnumsexo;
    }


}
