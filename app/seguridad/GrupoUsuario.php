<?php

namespace App\\Seguridad;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GrupoUsuario extends Model
{
    use SoftDeletes;

    protected $fillable = ['nombre', 'descripcion', 'eliminado'];

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
    public function menus()
    {
        return $this->belongsToMany('App\Seguridad\Menu', 'seguridad_grupo_usuario_menu', 'grupo_id', 'menu_id');
    }
    public function permisos()
    {
        return $this->belongsToMany('App\Seguridad\Permiso', 'seguridad_grupo_usuario_permiso', 'grupo_id', 'permiso_id');
    }
}
