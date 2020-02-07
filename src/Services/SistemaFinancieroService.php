<?php


namespace App\Services;


class SistemaFinancieroService{

    public function obtenerTasaDescuentoPagoSemestral(){

        //Simulación de conexión con el sistema financiero. Retorna un valor fijo
        return 0.10;
    }

    public function obtenerTasadeinteresAnual(){

        return 0.1;
    }

    public function obtenerTasadeinteresMensual(){

        return 0.01;
    }

    public function obtenerTasadeinteresDiaria(){

        return 0.001;
    }
}