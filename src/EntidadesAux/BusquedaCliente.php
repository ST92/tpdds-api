<?php


namespace App\EntidadesAux;


use App\Entity\EnumTipoDni;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * @ExclusionPolicy("all")
*/
class BusquedaCliente
{

    /**
     * @var int
     * @Expose
     */
    private $id;
    /**
     * @var int
     * @Expose
     */
    private $dni;
    /**
     * @var string
     * @Expose
     */
    private $nombre;
    /**
     * @var string
     * @Expose
     */

    private $apellido;

    /**
     * @var EnumTipoDni
     *
     */
    //private $enumTipoDni;


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * @param mixed $dni
     */
    public function setDni($dni)
    {
        $this->dni = $dni;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * @param mixed $apellido
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }

}
    /**
     * @return mixed
     */
    /*public function getEnumTipoDni()
    {
        return $this->enumTipoDni;
    }
*/
    /**
     * @param mixed $enumTipoDni
     */
  /*  public function setEnumTipoDni($enumTipoDni)
    {
        $this->enumTipoDni = $enumTipoDni;
    }



}*/