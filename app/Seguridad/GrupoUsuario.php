<?php

namespace App\Seguridad;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GrupoUsuario extends Model
{
    use SoftDeletes;
    protected $table      = 'seguridad_grupos_usuarios';
    protected $primaryKey = 'id';
    protected $fillable   = ['nombre', 'descripcion', 'eliminado'];

    /**
     *
     * Permite obtener los usuarios del grupo.
     *
     */

    public function usuarios()
    {
        return $this->belongsToMany('App\Seguridad\Usuario', 'seguridad_usuarios_grupos_usuarios');
    }
    /**
     *
     * Permite obtener los menus del grupo.
     *
     */

    public function menus()
    {
        return $this->belongsToMany('App\Seguridad\Menu', 'seguridad_grupos_usuarios_menus', 'grupo_id', 'menu_id');
    }
    /**
     *
     * Permite obtener los permisos del grupo.
     *
     */

    public function permisos()
    {
        return $this->belongsToMany('App\Seguridad\Permiso', 'seguridad_usuarios_menus', 'grupo_id', 'permiso_id');
    }
}
