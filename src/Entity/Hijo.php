<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * Hijo
 *
 * @ORM\Table(name="hijo", indexes={@ORM\Index(name="fk_estadoCivilHijo", columns={"enumEstadoCivil_id"}), @ORM\Index(name="fk_sexoHijo", columns={"enumSexo_id"}), @ORM\Index(name="fk_polizaHijo", columns={"poliza_id"})})
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */

class Hijo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(name="dni", type="bigint", nullable=false)
     * @Expose
     */
    private $dni;

    /**
     * @var DateTime
     * @ORM\Column(name="fecha_nac", type="date", nullable=false)
     * @Expose
     */
    private $fechaNac;

    /**
     * @var EnumEstadoCivil
     * @ORM\ManyToOne(targetEntity="EnumEstadoCivil", cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="enumEstadoCivil_id", referencedColumnName="id", nullable=false)
     * })
     * @Expose
     */
    private $estadoCivil;

    /**
     * @var EnumSexo
     *
     * @ORM\ManyToOne(targetEntity="EnumSexo", cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="enumSexo_id", referencedColumnName="id", nullable=false)
     * })
     * @Expose
     */
    private $sexo;

    /**
     * @var Poliza
     * @ORM\ManyToOne(targetEntity="Poliza", inversedBy="listaHijos", cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="poliza_id", referencedColumnName="nro_poliza", nullable=false)
     * })
     */
    private $poliza;




    //Getters and Setters

    /**
     * Hijo constructor.
     *
     */
    public function __construct()
    {
        $this->id = 0;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id_hijo
     */
    public function setIdHijo(int $id_hijo){
        $this->id = $id_hijo;
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
     * @return string
     */
    public function getFechaNac(){
        return $this->fechaNac;
    }

    /**
     * @param string $fechaNac
     */
    public function setFechaNac($fechaNac){
        $this->fechaNac = $fechaNac;

    }

    /**
     * @return EnumEstadoCivil
     */
    public function getEstadoCivil(){

        return $this->estadoCivil;
    }

    /**
     * @param EnumEstadoCivil $estado
     */
    public function setEstadoCivil($estado){

        $this->estadoCivil = $estado;

    }

    /**
     * @return mixed
     */
    public function getEnumSexo(){

        return $this->sexo;
    }

    /**
     * @param EnumSexo $s
     */
    public function setEnumSexo($s){

        $this->sexo = $s;
    }

    /**
     * @return Poliza
     */
    public function getPoliza(){
        return $this->poliza;
    }

    /**
     * @param Poliza $poliza
     */
    public function setPoliza(Poliza $poliza){
        $this->poliza = $poliza;
    }



}
