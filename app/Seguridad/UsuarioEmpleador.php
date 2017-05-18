<?php

namespace App\Seguridad;

use App\BolsaEmpleo\Empleador;
use App\Seguridad\Usuario;

class UsuarioEmpleador extends Usuario
{

    protected $table    = 'seguridad_usuarios_empleadores';
    protected $fillable = ['empleador_id'];
    public function __construct()
    {
        $this->empleador_id = new Empleador();
    }

    public function empleador()
    {
        return $this->belongsTo(Empleador::class, 'empleador_id');
    }
    public function usuario()
    {
        return $this->belongsTo('App\Seguridad\Usuario', 'id');
    }
}
