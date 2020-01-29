<?php


namespace App\Interfaces\IDAO;


interface IPagoDAO{

    public function getObj(int $id);
    public function save($pago);

}