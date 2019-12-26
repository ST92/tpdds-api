<?php


namespace App\Services\DAO;



use App\Entity\EnumEstadoPoliza;
use App\Entity\Marca;
use App\Interfaces\IDAO\IFactoryDAO;
use Doctrine\ORM\EntityManager;

class DoctrineFactoryDAO implements IFactoryDAO{

    private static $_instance;

    public function __construct()
    {
    }

    /**
     * Set the factory instance
     * @param DoctrineFactoryDAO $f
     */
    public static function setFactory(DoctrineFactoryDAO $f){

        self::$_instance = $f;

    }

    /**
     * Get a factory instance.
     * @return DoctrineFactoryDAO
     */
    public static function getFactory(){
        if(!self::$_instance)
            self::$_instance = new self;

        return self::$_instance;
    }



    public function getAjustesKMDAO($em){

        return new AjustesKMDAO($em);

    }

    public function getClienteDAO($em){

        return new ClienteDAO($em);

    }

    public function getCuotaDAO($em){

        return new CuotaDAO($em);

    }

    public function getEnumCondIvaDAO($em){

        return new EnumCondIvaDAO($em);

    }

    public function getEnumEstadoCivilDAO($em){

        return new EnumEstadoCivilDAO($em);
    }

    public function getEnumEstadoPolizaDAO($em){

        return new EnumEstadoPolizaDAO($em);
    }

    public function getEnumFormaPagoDAO($em){

        return new EnumFormaPagoDAO($em);

    }

    public function getEnumSexoDAO($em){

        return new EnumSexoDAO($em);
    }

    public function getEnumTipoDNIDAO($em){

        return new EnumTipoDNIDAO($em);

    }

    public function getFactoresCDAO($em){

        return new FactoresCDAO($em);

    }

    public function getHijoDAO($em){

        return new HijoDAO($em);

    }

    public function getLocalidadDAO($em){

        return new LocalidadDAO($em);

    }

    public function getMarcaDAO($em){

        return new MarcaDAO($em);
    }

    public function getMedidasSeguridadDAO($em){

        return new MedidasSeguridadDAO($em);

    }

    public function getModeloDAO($em){

        return new ModeloDAO($em);
    }

    public function getPolizaDAO($em){

        return new PolizaDAO($em);

    }

    public function getProvinciaDAO($em){

        return new ProvinciaDAO($em);

    }

    public function getSiniestrosDAO($em){

        return new SiniestrosDAO($em);

    }

    public function getTipoCoberturaDAO($em){

        return new TipoCoberturaDAO($em);

    }

    public function getVehiculoDAO($em){

        return new VehiculoDAO($em);

    }

}