<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * Localidad
 *
 * @ORM\Table(name="localidad", indexes={@ORM\Index(name="fk_provincia", columns={"provincia_id"})})
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */

class Localidad
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
     * @ORM\Column(name="nombre_localidad", type="string", length=150, nullable=false)
     * @Expose
     */
    private $nombreLocalidad;

    /**
     * @var int
     * @ORM\Column(name="codigo_postal", type="integer", nullable=false)
     * @Expose
     */
    private $codigoPostal;

    /**
     * @var int
     * @ORM\Column(name="valor", type="float", nullable=false)
     */
    private $valor;

    /**
     * @var Provincia
     * @ORM\ManyToOne(targetEntity="Provincia")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="provincia_id", referencedColumnName="id")
     * })
     */
    private $provincia;



    //Getters and Setters
    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $idLocalidad
     */
    public function setId(int $idLocalidad){
        $this->id = $idLocalidad;
    }

    /**
     * @return string
     */
    public function getNombreLocalidad(){
        return $this->nombreLocalidad;
    }

    /**
     * @param string $nombreLocalidad
     */
    public function setNombreLocalidad(string $nombreLocalidad){
        $this->nombreLocalidad = $nombreLocalidad;
    }

    /**
     * @return int
     */
    public function getCodigoPostal(){
        return $this->codigoPostal;
    }

    /**
     * @param int $codigoPostal
     */
    public function setCodigoPostal(int $codigoPostal){
        $this->codigoPostal = $codigoPostal;
    }

    /**
     * @return int
     */
    public function getValor(){
        return $this->valor;
    }

    /**
     * @param int $valor
     */
    public function setValor(int $valor){
        $this->valor = $valor;
    }

    /**
     * @return Provincia
     */
    public function getProvincia(){
        return $this->provincia;
    }

    /**
     * @param Provincia $idProvincia
     */
    public function setProvincia(Provincia $idProvincia){
        $this->provincia = $idProvincia;
    }


}
