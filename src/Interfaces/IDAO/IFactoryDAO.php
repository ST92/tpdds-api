<?php


namespace App\Interfaces\IDAO;


interface IFactoryDAO
{

    //Retornan instancias de DAO
    public function getAjustesKMDAO($em);
    public function getClienteDAO($em);
    public function getCuotaDAO($em);
    public function getEnumCondIvaDAO($em);
    public function getEnumEstadoCivilDAO($em);
    public function getEnumEstadoPolizaDAO($em);
    public function getEnumFormaPagoDAO($em);
    public function getEnumSexoDAO($em);
    public function getEnumTipoDNIDAO($em);
    public function getFactoresCDAO($em);
    public function getHijoDAO($em);
    public function getLocalidadDAO($em);
    public function getMarcaDAO($em);
    public function getMedidasSeguridadDAO($em);
    public function getModeloDAO($em);
    public function getPolizaDAO($em);
    public function getProvinciaDAO($em);
    public function getSiniestrosDAO($em);
    public function getTipoCoberturaDAO($em);
    public function getVehiculoDAO($em);
}