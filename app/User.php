<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ]
    public function grupos()
    {
        return $this->belongsToMany('App\Seguridad\GrupoUsuario', 'role_user', 'user_id', 'grupo_id');
    }
    function menus()
    {
        return $this->belongsToMany('App\Seguridad\Menu', 'menu_user', 'user_id', 'menu_id');
    }
    function permisos()
    {
        return $this->belongsToMany('App\Seguridad\Permiso', 'seguridad_users_permiso', 'user_id', 'permiso_id');
    }
}
