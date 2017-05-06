<?php

namespace App\Seguridad;

use App\BolsaEmpleo\Empleador;
use App\Seguridad\Usuario;

class UsuarioEmpleador extends Usuario
{

    protected $table    = 'seguridad_usuarios_empleadores';
    protected $fillable = ['empleador_id'];

    public function empleador()
    {
        return $this->belongsTo(Empleador::class, 'id');
    }

}
