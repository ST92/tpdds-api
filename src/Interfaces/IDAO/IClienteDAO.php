<?php


namespace App\Interfaces\IDAO;


interface IClienteDAO
{
    public function getObj(int $id);
    public function getAllObj($id, $nombre, $apellido, $dni, $tipoDni);

}