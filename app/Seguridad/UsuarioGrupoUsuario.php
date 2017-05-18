<?php

namespace App\Seguridad;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsuarioGrupoUsuario extends Model
{
    use SoftDeletes;
    protected $table = 'seguridad_usuarios_grupos_usuario';
}
