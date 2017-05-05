<?php
namespace App\Util;

class DataType
{
    const TIPO_DIRECCION = 'TIPO_DE_DIRECCION';
    const PAIS           = 'PAIS';
    const PAGINATE       = 20;

    public function Defines($const)
    {return in_array($const, $this->getConstants());}
}
