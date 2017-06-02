<?php

namespace App\Seguridad;

use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends User
{
    use SoftDeletes;
    protected $table    = 'seguridad_usuarios';
    protected $fillable = ['super_user', 'numero_identificacion'];

    /**
     *
     * Permite obtener los grupos de un usuario, relación de muchos a muchos.
     *
     */

    public function grupos()
    {
        return $this->belongsToMany('App\Seguridad\GrupoUsuario', 'seguridad_usuarios_grupos_usuarios');
    }

    /**
     *
     * Permite obtener los menus de un usuario, relación de muchos a muchos.
     *
     */

    public function menus()
    {
        return $this->belongsToMany('App\Seguridad\Menu', 'seguridad_usuarios_menus', 'usuario_id', 'menu_id');
    }

    /**
     *
     * Permite obtener los permisos de un usuario, relación de muchos a muchos
     *
     */

    public function permisos()
    {
        return $this->belongsToMany('App\Seguridad\Permiso', 'seguridad_usuarios_permisos', 'usuario_id', 'permiso_id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'id');
    }
    public function usuarioEmpleador()
    {
        return $this->hasOne('App\Seguridad\UsuarioEmpleador', 'id');
    }
    public function usuarioPostulante()
    {
        return $this->hasOne('App\Seguridad\UsuarioPostulante', 'id');
    }
    /**
     *
     * Permite validar si un usuario puede hacer una acción de acuerdo a si es un superusuario
     *o pertenece a un grupo de usuario
     */

    public static function validarPermisos($usuario_id, $grupoUsuario = null)
    {
        $usuario = Usuario::find($usuario_id);
        if ($usuario->super_user) {
            return true;
        }
        if ($grupoUsuario) {
            $grupos = $usuario->grupos()->get();
            foreach ($grupos as $grupo) {
                if ($grupo->nombre == $grupoUsuario) {
                    return true;
                }
            }
            return false;
        }

    }
    public static $rules = array(
        'numero_identificacion' => 'required|min:4|unique:seguridad_usuarios',
    );
}
