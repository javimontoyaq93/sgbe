<?php

namespace App\Seguridad;

use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Usuario extends User
{
    use SoftDeletes;
    protected $table    = 'seguridad_usuarios';
    protected $fillable = ['super_user', 'user_id'];

    /**
     *
     * Permite obtener los grupos de un usuario, relación de muchos a muchos.
     *
     */

    public function grupos()
    {
        return $this->belongsToMany('App\Seguridad\GrupoUsuario', 'seguridad_usuarios_grupos_usuarios', 'usuario_id', 'grupo_id');
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
        return $this->belongsTo('App\User');
    }
}
