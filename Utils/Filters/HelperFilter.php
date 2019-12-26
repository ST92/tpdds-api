<?php

namespace App\Utils\Filters;

class HelperFilter
{
    static function makeNumeric($alias, $campo, $value, $operadors, &$filterArray, &$paramsArray)
    {
        $posibleOperators = ["=", "<>", "<", ">", "<=", ">=", "between", "in"];
        $operador = '=';
        if (isset($operadors[$campo]) && in_array($operadors[$campo], $posibleOperators)) {
            $operador = $operadors[$campo];
        }

        if ($operador == 'between') {
            $filterArray[] = $alias . '.' . $campo . ' >= :desde' . $campo . ' AND ' . $alias . '.' . $campo . ' <= :hasta' . $campo . ' ';
            $valores = explode(',', $value);
            $paramsArray['desde' . $campo] = $valores[0];
            $paramsArray['hasta' . $campo] = $valores[1];
        } elseif ($operador == 'in') {
            $filterArray[] = $alias . '.' . $campo . ' IN(:' . $campo . ')';
            $paramsArray[$campo] = explode(',', $value);
        } else {
            $filterArray[] = $alias . '.' . $campo . ' ' . $operador . ' :' . $campo;
            $paramsArray[$campo] = $value;
        }
    }

    static function makeString($alias, $campo, $value, $operadors, &$filterArray, &$paramsArray)
    {
        $posibleOperators = ["contains", "notcontains", "startswith", "endswith", "=", "<>"];
        $operador = 'contains';
        if (isset($operadors[$campo]) && in_array($operadors[$campo], $posibleOperators)) {
            $operador = $operadors[$campo];
        }
        switch ($operador) {
            case 'contains':
                $filterArray[] = $alias . '.' . $campo . ' LIKE :' . $campo;
                $paramsArray[$campo] = '%' . $value . '%';
                break;
            case 'notcontains':
                $filterArray[] = $alias . '.' . $campo . ' NOT LIKE :' . $campo;
                $paramsArray[$campo] = '%' . $value . '%';
                break;
            case 'startswith':
                $filterArray[] = $alias . '.' . $campo . ' LIKE :' . $campo;
                $paramsArray[$campo] = $value . '%';
                break;
            case 'endswith':
                $filterArray[] = $alias . '.' . $campo . ' LIKE :' . $campo;
                $paramsArray[$campo] = '%' . $value;
                break;
            case '=':

                $filterArray[] = $alias . '.' . $campo . ' = :' . $campo;
                $paramsArray[$campo] = $value;
                break;
            case '<>':
                $filterArray[] = $alias . '.' . $campo . ' <> :' . $campo;
                $paramsArray[$campo] = $value;
                break;
        }
    }

    static function makeId($alias, $campo, $value, $operadors, &$filterArray, &$paramsArray)
    {
        $filterArray[] = $alias . '.' . $campo . ' = :' . $campo;
        $paramsArray[$campo] = $value;
    }


    static function makeBoolean($alias, $campo, $value, &$filterArray, &$paramsArray)
    {
        switch ($value) {
            case 'true':
                $filterArray[] = $alias . '.' . $campo . ' = :' . $campo;
                $paramsArray[$campo] = true;
                break;
            case 'false':
                $filterArray[] = $alias . '.' . $campo . ' = :' . $campo;
                $paramsArray[$campo] = false;
                break;
            case '1':
                $filterArray[] = $alias . '.' . $campo . ' = :' . $campo;
                $paramsArray[$campo] = true;
                break;
            case '0':
                $filterArray[] = $alias . '.' . $campo . ' = :' . $campo;
                $paramsArray[$campo] = false;
                break;
        }
    }

    static function makeDate($alias, $campo, $value, $operadors, &$filterArray, &$paramsArray)
    {
        $posibleOperators = ["and", "or", "<", ">=", "between"];
        $operador = 'and';
        if (isset($operadors[$campo]) && in_array($operadors[$campo], $posibleOperators)) {
            $operador = $operadors[$campo];
        }
        switch ($operador) {
            case 'and':
                $filterArray[] = $alias . '.' . $campo . ' BETWEEN :' . $campo . 'desde AND :' . $campo . 'hasta';
                $paramsArray[$campo . 'desde'] = $value . ' 00:00:00';
                $paramsArray[$campo . 'hasta'] = $value . ' 23:59:59';
                break;
            case 'or':
                $filterArray[] = $alias . '.' . $campo . ' < :' . $campo . 'desde OR ' . $alias . '.' . $campo . ' > :' . $campo . 'hasta';
                $paramsArray[$campo . 'desde'] = $value . ' 00:00:00';
                $paramsArray[$campo . 'hasta'] = $value . ' 23:59:59';
                break;
            case '<':
                $filterArray[] = $alias . '.' . $campo . $operador . ' :' . $campo;
                $paramsArray[$campo] = $value . ' 00:00:00';
                break;
            case '>=':
                $filterArray[] = $alias . '.' . $campo . $operador . ' :' . $campo;
                $paramsArray[$campo] = $value . ' 00:00:00';
                break;
            case 'between':
                $filterArray[] = $alias . '.' . $campo . ' BETWEEN :' . $campo . 'desde AND :' . $campo . 'hasta';
                $valores = explode(',', $value);
                $paramsArray[$campo . 'desde'] = $valores[0];
                $paramsArray[$campo . 'hasta'] = str_replace(' 00:00:00', "", $valores[1]) . ' 23:59:59';
                break;
        }
    }

    static function makeOperatorIn($alias, $campo, $variable, $value, $operadors, &$filterArray, &$paramsArray)
    {
        $filterArray[] = $alias . '.' . $campo . ' IN(:' . $variable . ')';
        $paramsArray[$variable] = explode(',', $value);
    }

    static function makeJoinString($alias, $campo, $value, $operadors, &$filterArray, &$paramsArray)
    {
        $posibleOperators = ["contains", "notcontains", "startswith", "endswith", "=", "<>"];

        $operador = 'contains';
        if (isset($operadors[$campo]) && in_array($operadors[$campo], $posibleOperators)) {
            $operador = $operadors[$campo];
        }

        $joinCampo = explode('.', $campo)[1];

        switch ($operador) {
            case 'contains':
                $filterArray[] = $alias . '.' . $joinCampo . ' LIKE :' . $joinCampo;
                $paramsArray[$joinCampo] = '%' . $value . '%';
                break;
            case 'notcontains':
                $filterArray[] = $alias . '.' . $joinCampo . ' NOT LIKE :' . $joinCampo;
                $paramsArray[$joinCampo] = '%' . $value . '%';
                break;
            case 'startswith':
                $filterArray[] = $alias . '.' . $joinCampo . ' LIKE :' . $joinCampo;
                $paramsArray[$joinCampo] = $value . '%';
                break;
            case 'endswith':
                $filterArray[] = $alias . '.' . $joinCampo . ' LIKE :' . $joinCampo;
                $paramsArray[$joinCampo] = '%' . $value;
                break;
            case '=':
                $filterArray[] = $alias . '.' . $joinCampo . ' = :' . $joinCampo;
                $paramsArray[$joinCampo] = $value;
                break;
            case '<>':
                $filterArray[] = $alias . '.' . $joinCampo . ' <> :' . $joinCampo;
                $paramsArray[$joinCampo] = $value;
                break;
        }
    }
}