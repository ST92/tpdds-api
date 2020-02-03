<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;


/**
 * Modelo
 *
 * @ORM\Table(name="modelo", indexes={@ORM\Index(name="fk_marca", columns={"marca_id"})})
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */
class Modelo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @Expose
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="nombre", type="string", length=150, nullable=false)
     * @Expose
     */
    private $nombre;

    /**
     * @var float
     * @ORM\Column(name="robo_por_modelo", type="float", precision=10, scale=0, nullable=false)
     */
    private $roboPorModelo;

    /**
     * @var Marca
     *
     * @ORM\ManyToOne(targetEntity="Marca", cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="marca_id", referencedColumnName="id", nullable=false)
     * })
     * @Expose
     */
    private $marca;




    //Getters and Setters
    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * @param int $idModelo
     */
    public function setId(int $idModelo){
        $this->id = $idModelo;
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
    public function setNombre(string $nombre){
        $this->nombre = $nombre;
    }

    /**
     * @return float
     */
    public function getValor(){
        return $this->roboPorModelo;
    }

    /**
     * @param float $roboPorModelo
     */
    public function setValor(float $roboPorModelo){
        $this->roboPorModelo = $roboPorModelo;
    }

    /**
     * @return Marca
     */
    public function getMarca(){
        return $this->marca;
    }

    /**
     * @param Marca $idMarca
     */
    public function setMarca(Marca $idMarca){
        $this->marca = $idMarca;
    }


}
