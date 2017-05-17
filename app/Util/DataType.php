<?php
namespace App\Util;

class DataType
{
    const TIPO_DIRECCION           = 'TIPO_DE_DIRECCION';
    const TIPO_DOCUMENTO           = 'TIPO_DE_DOCUMENTO';
    const TIPO_ACTIVIDAD_ECONOMICA = 'ACTIVIDAD_ECONOMICA';
    const TIPO_PERSONERIA          = 'RAZON_SOCIAL';
    const NIVEL_INSTRUCCION        = 'NIVEL_DE_INSTRUCCION';
    const PAIS                     = 'PAIS';
    const PAGINATE                 = 20;
    const EMPLEADOR                = 'Empleador';
    const POSTULANTE               = 'Postulante';
    const TIPO_SEXO                = 'TIPO_SEXO';
    const ESTADO_CIVIL             = 'ESTADO_CIVIL';
    const SERVER                   = 'sgbe.localhost.com';
    const RUTA_CAMBIAR_CLAVE       = 'solicitar-cambio-clave';
    const MAIL_USERNAME            = 'javimontoyaq93@gmail.com';
    const MAIL_NAME                = 'javimontoyaq93';
    public function Defines($const)
    {return in_array($const, $this->getConstants());}
}
