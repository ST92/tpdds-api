<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * HijoModificado
 * @ORM\Table(name="hijo_modificado", indexes={@ORM\Index(name="fk_estadoCivilHijoMod", columns={"enumEstadoCivil_id"}), @ORM\Index(name="fk_nroPolizaMod", columns={"nro_poliza_modif_id"}), @ORM\Index(name="fk_sexoHijoMod", columns={"enumSexo_id"})})
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */

//TODO Ver que se hará con esto. En teoría no lo vamos a usar.
class HijoModificado
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
     * @ORM\Column(name="dni", type="integer", nullable=false)
     */
    private $dni;

    /**
     * @var DateTime
     * @ORM\Column(name="fecha_nac", type="date", nullable=false)
     */
    private $fechaNac;

    /**
     * @var EnumEstadoCivil
     * @ORM\ManyToOne(targetEntity="EnumEstadoCivil")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="enumEstadoCivil_id", referencedColumnName="id")
     * })
     */
    private $enumEstadoCivil;

    /**
     * @var EnumSexo
     *
     * @ORM\ManyToOne(targetEntity="EnumSexo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="enumSexo_id", referencedColumnName="id")
     * })
     */
    private $enumSexo;

    /**
     * @var PolizaModificada
     *
     * @ORM\ManyToOne(targetEntity="PolizaModificada")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="nro_poliza_modif_id", referencedColumnName="id")
     * })
     */
    private $polizaModificada;



    //Getters and Setters

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id){
        $this->id = $id;
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
     * @return DateTime
     */
    public function getFechaNac(){
        return $this->fechaNac;
    }

    /**
     * @param DateTime $fechaNac
     */
    public function setFechaNac(\DateTime $fechaNac){
        $this->fechaNac = $fechaNac;
    }

    /**
     * @return EnumEstadoCivil
     */
    public function getEnumestadocivil(){
        return $this->enumEstadoCivil;
    }

    /**
     * @param EnumEstadoCivil $idEnumestadocivil
     */
    public function setEnumestadocivil(EnumEstadoCivil $idEnumestadocivil){
        $this->enumEstadoCivil = $idEnumestadocivil;
    }

    /**
     * @return EnumSexo
     */
    public function getEnumsexo(){
        return $this->enumSexo;
    }

    /**
     * @param EnumSexo $idEnumsexo
     */
    public function setIdEnumsexo(EnumSexo $idEnumsexo){
        $this->enumSexo = $idEnumsexo;
    }

    /**
     * @return PolizaModificada
     */
    public function getNroPolizaModif(){
        return $this->polizaModificada;
    }

    /**
     * @param PolizaModificada $nroPolizaModif
     */
    public function setNroPolizaModif(PolizaModificada $nroPolizaModif){
        $this->polizaModificada = $nroPolizaModif;
    }

}
