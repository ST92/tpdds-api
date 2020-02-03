<?php

namespace App\Entity;

use DateTime;
use App\Entity\Cuota;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;



/**
 * Poliza
 *
 * @ORM\Table(name="poliza", indexes={@ORM\Index(name="fk_vehiculo", columns={"vehiculo_id"}), @ORM\Index(name="fk_siniestros", columns={"siniestrosFc_id"}), @ORM\Index(name="fk_domicilioRiesgo", columns={"localidad_id"}), @ORM\Index(name="fk_poliza_poliza", columns={"poliza_id"}), @ORM\Index(name="fk_caract", columns={"caract_id"}), @ORM\Index(name="fk_cliente", columns={"cliente_id"}), @ORM\Index(name="fk_estadoPoliza", columns={"enumEstadoPoliza_id"}), @ORM\Index(name="fk_formaPago", columns={"enumFormaPago_id"}), @ORM\Index(name="fk_cobertura", columns={"tipoCobertura_id"}), @ORM\Index(name="fk_ajustes", columns={"ajustesKm_id"})})
 * @ORM\Entity
 * @ExclusionPolicy("all")
 */

class Poliza
{
    /**
     * @var integer
     * @ORM\Column(name="nro_poliza", type="bigint", nullable=false)
     * @ORM\Id
     * @Expose
     */
    private $nroPoliza;

    /**
     * @var float
     * @ORM\Column(name="suma_asegurada", type="float", precision=10, scale=0, nullable=false)
     * @Expose
     */
    private $sumaAsegurada;

    /**
     * @var float
     * @ORM\Column(name="km_anio", type="float", precision=10, scale=0, nullable=false)
     * @Expose
     */
    private $kmAnio;

    /**
     * @var DateTime
     * @ORM\Column(name="fecha_inicio_vigencia", type="date", nullable=false)
     * @Expose
     */
    private $fechaInicioVigencia;

    /**
     * @var DateTime
     * @ORM\Column(name="fecha_fin_vigencia", type="date", nullable=false)
     * @Expose
     */
    private $fechaFinVigencia;

    /**
     * @var float
     * @ORM\Column(name="premio", type="float", precision=10, scale=0, nullable=false)
     * @Expose
     */
    private $premio;

    /**
     * @var float
     * @ORM\Column(name="importe_por_descuento", type="float", precision=10, scale=0, nullable=false)
     * @Expose
     */
    private $importePorDescuento;

    /**
     * @var string
     * @ORM\Column(name="ultimo_dia_pago", type="date", nullable=false)
     * @Expose
     */
    private $ultimoDiaPago;

    /**
     * @var float
     * @ORM\Column(name="monto_total_a_abonar", type="float", precision=10, scale=0, nullable=false)
     * @Expose
     */
    private $montoTotalAAbonar;

    /**
     * @var AjustesPorKm
     * @ORM\ManyToOne(targetEntity="AjustesPorKm", cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ajustesKm_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $ajusteskm;

    /**
     * @var FactoresCaracteristicas
     * @ORM\ManyToOne(targetEntity="FactoresCaracteristicas", cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="caract_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $factores;

    /**
     * @var Cliente
     * @ORM\ManyToOne(targetEntity="Cliente", cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="cliente_id", referencedColumnName="id", nullable=false)
     * })
     * @Expose
     */
    private $cliente;

    /**
     * @var TipoCobertura
     * @ORM\ManyToOne(targetEntity="TipoCobertura", cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tipoCobertura_id", referencedColumnName="id", nullable=false)
     * })
     * @Expose
     */
    private $tipoCobertura;

    /**
     * @var Localidad
     * @ORM\ManyToOne(targetEntity="Localidad", cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="localidad_id", referencedColumnName="id", nullable=false)
     * })
     * @Expose
     */
    private $localidad;

    /**
     * @var EnumEstadoPoliza
     * @ORM\ManyToOne(targetEntity="EnumEstadoPoliza", cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="enumEstadoPoliza_id", referencedColumnName="id", nullable=false)
     * })
     */
    private $estadoPoliza;

    /**
     * @var EnumFormaPago
     * @ORM\ManyToOne(targetEntity="EnumFormaPago", cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="enumFormaPago_id", referencedColumnName="id", nullable=false)
     * })
     * @Expose
     */
    private $formapago;

    //Poliza anterior a ésta poliza. La primera puede ser nula, por eso el nullable=true
    /**
     * @var Poliza
     * @ORM\ManyToOne(targetEntity="Poliza", cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="poliza_id", referencedColumnName="nro_poliza", nullable=true)
     * })
     */
    private $idPoliza;

    /**
     * @var SiniestrosFc
     * @ORM\ManyToOne(targetEntity="SiniestrosFc", cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="siniestrosFc_id", referencedColumnName="id", nullable=false)
     * })
     *  @Expose
     */
    private $siniestroFC;

    /**
     * @var Vehiculo
     * @ORM\OneToOne(targetEntity="Vehiculo", cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="vehiculo_id", referencedColumnName="id", nullable=false)
     * })
     * @Expose
     */
    private $vehiculo;

    //Relación bidireccional
    /**
     * @ORM\OneToMany(targetEntity="Hijo", mappedBy="poliza", cascade={"persist", "remove"})
     * @var ArrayCollection
     * @Expose
    */
    private $listaHijos;

    /**
     * @ORM\OneToMany(targetEntity="Cuota", mappedBy="poliza", cascade={"persist", "remove"})
     * @var ArrayCollection
     * @Expose
    */
    private $listaCuotas;



    /**
     * Poliza constructor.
     *
     */
    public function __construct()
    {
        $this->listaHijos = new ArrayCollection();
        $this->listaCuotas= new ArrayCollection();
    }


    //Getters and Setters
    /**
     * @return Integer
     */
    public function getNroPoliza(){
        return $this->nroPoliza;
    }

    /**
     * @param integer $nroPoliza
     */
    public function setNroPoliza($nroPoliza){
        $this->nroPoliza = $nroPoliza;

    }

    /**
     * @return float
     */
    public function getSumaAsegurada(){
        return $this->sumaAsegurada;
    }

    /**
     * @param float $sumaAsegurada
     */
    public function setSumaAsegurada(float $sumaAsegurada){
        $this->sumaAsegurada = $sumaAsegurada;
    }

    /**
     * @return float
     */
    public function getKmAnio(){
        return $this->kmAnio;
    }

    /**
     * @param float $kmAnio
     */
    public function setKmAnio($kmAnio){
        $this->kmAnio = $kmAnio;

    }

    /**
     * @return DateTime
     */
    public function getFechaInicioVigencia(){
        return $this->fechaInicioVigencia;
    }

    /**
     * @param DateTime $fechaInicioVigencia
     */
    public function setFechaInicioVigencia($fechaInicioVigencia){
        $this->fechaInicioVigencia = $fechaInicioVigencia;
    }

    /**
     * @return DateTime
     */
    public function getFechaFinVigencia() {
        return $this->fechaFinVigencia;

    }

    /**
     * @param mixed $fechaFinVigencia
     */
    public function setFechaFinVigencia($fechaFinVigencia){
        $this->fechaFinVigencia = $fechaFinVigencia;

    }

    /**
     * @return float
     */
    public function getPremio(){
        return $this->premio;
    }

    /**
     * @param float $premio
     */
    public function setPremio(float $premio){
        $this->premio = $premio;
    }

    /**
     * @return float
     */
    public function getImportePorDescuento(){
        return $this->importePorDescuento;
    }

    /**
     * @param float $importePorDescuento
     */
    public function setImportePorDescuento(float $importePorDescuento){
        $this->importePorDescuento = $importePorDescuento;
    }

    /**
     * @return string
     */
    public function getUltimoDiaPago(){
        return $this->ultimoDiaPago;
    }

    /**
     * @param string $ultimoDiaPago
     */
    public function setUltimoDiaPago($ultimoDiaPago){
        $this->ultimoDiaPago = $ultimoDiaPago;
    }

    /**
     * @return float
     */
    public function getMontoTotalAAbonar(){
        return $this->montoTotalAAbonar;
    }

    /**
     * @param float $montoTotalAAbonar
     */
    public function setMontoTotalAAbonar(float $montoTotalAAbonar){
        $this->montoTotalAAbonar = $montoTotalAAbonar;
    }

    /**
     * @return AjustesPorKm
     */
    public function getAjusteskm(){
        return $this->ajusteskm;
    }

    /**
     * @param AjustesPorKm $ajusteskm
     */
    public function setAjusteskm($ajusteskm){
        $this->ajusteskm = $ajusteskm;

    }

    /**
     * @return FactoresCaracteristicas
     */
    public function getFactores(){
        return $this->factores;
    }

    /**
     * @param FactoresCaracteristicas $f
     */
    public function setFactores($f){
        $this->factores = $f;
    }

    /**
     * @return mixed
     */
    public function getCliente(){
        return $this->cliente;

    }

    /**
     * @param Cliente $c
     */
    public function setCliente($c){
        $this->cliente = $c;

    }

    /**
     * @return TipoCobertura
     */
    public function getTipoCobertura(){
        return $this->tipoCobertura;
    }

    /**
     * @param TipoCobertura $tipo
     */
    public function setTipoCobertura($tipo){
        $this->tipoCobertura = $tipo;

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

    /**
     * @return EnumEstadoPoliza
     */
    public function getEstadoPoliza(){
        return $this->estadoPoliza;
    }

    /**
     * @param EnumEstadoPoliza $estadoPoliza
     */
    public function setEstadoPoliza($estadoPoliza){
        $this->estadoPoliza = $estadoPoliza;
    }

    /**
     * @return EnumFormaPago $forma
     */
    public function getFormapago(){
        return $this->formapago;
    }

    /**
     * @param EnumFormaPago $forma
     */
    public function setFormapago($forma){

        $this->formapago = $forma;

    }

    /**
     * @return Poliza
     */
    public function getIdPoliza()
    {
        return $this->idPoliza;
    }

    /**
     * @param Poliza $idPoliza
     */
    public function setIdPoliza($idPoliza)
    {
        $this->idPoliza = $idPoliza;
    }

    /**
     * @return SiniestrosFc
     */
    public function getSiniestroFC(){

        return $this->siniestroFC;
    }

    /**
     * @param SiniestrosFc $sin
     */
    public function setSiniestroFC($sin){

        $this->siniestroFC = $sin;
    }

    /**
     * @return Vehiculo
     */
    public function getVehiculo()
    {
        return $this->vehiculo;
    }

    /**
     * @param Vehiculo $veh
     */
    public function setVehiculo($veh){
        $this->vehiculo = $veh;
    }


    /**
     * @param Hijo $hijo
    */
    public function agregarHijo($hijo){
        $this->listaHijos->add($hijo);

    }

    /**
     * @param Cuota $cuota
     */
     public function agregarCuota($cuota){

        $this->listaCuotas->add($cuota);

    }

    /**
     * @return ArrayCollection
     */
    public function getListaHijos(){
        return $this->listaHijos;
    }

    /**
     * @param ArrayCollection $listaHijos
     */
    public function setListaHijos(ArrayCollection $listaHijos){
        $this->listaHijos = $listaHijos;
    }

    /**
     * @return ArrayCollection
     */
    public function getListaCuotas(){
        return $this->listaCuotas;
    }

    /**
     * @param ArrayCollection $listaCuotas
     */
    public function setListaCuotas(ArrayCollection $listaCuotas){
        $this->listaCuotas = $listaCuotas;
    }


}
