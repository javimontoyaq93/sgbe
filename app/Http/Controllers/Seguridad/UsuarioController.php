<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use App\Seguridad\Usuario;

class UsuarioController extends Controller
{
    public function validarPermisos($usuario_id)
    {
        $usuario = Usuario::find($usuario_id);
        if ($usuario->super_user) {
            return true;
        }
        return false;
    }
}
