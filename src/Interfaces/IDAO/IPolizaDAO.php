<?php


namespace App\Interfaces\IDAO;


interface IPolizaDAO{

    public function getObj(int $id);
    public function save($poliza);
    public function countObj($obj);
    public function findVehiculoActivo($campo, $valor, $estado);


}