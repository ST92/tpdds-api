<?php


namespace App\Interfaces\IDAO;


interface IClienteDAO
{
    public function getObj(int $id);
    public function getAllObj($filters, $operators, $order_by, $limit, $offset);

}