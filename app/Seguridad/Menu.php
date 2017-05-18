<?php

namespace App\Seguridad;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;
    protected $table      = 'seguridad_menus';
    protected $primaryKey = 'id';
    protected $fillable   = ['nombre', 'descripcion', 'orden', 'eliminado', 'formulario', 'padre_id'];

    /**
     *
     * Block comment
     *
     */

    public function menus()
    {
        return $this->hasMany('App\Seguridad\Menu', 'padre_id', 'id');
    }

    /**
     *
     * Block comment
     *
     */
    public function grupos()
    {
        return $this->belongsToMany('App\Seguridad\GrupoUsuario');
    }

    /**
     *
     * Block comment
     *
     */
    public function usuarios()
    {
        return $this->belongsToMany('App\Seguridad\Usuario');
    }

}
