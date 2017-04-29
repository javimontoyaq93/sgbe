<?php

namespace App\\seguridad;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;
    protected $fillable = ['nombre', 'descripcion', 'orden', 'eliminado', 'formulario', 'padre_id'];

    public function menus()
    {
        return $this->hasMany('App\core\Menu', 'padre_id', 'id');
    }
    public function grupos()
    {
        return $this->belongsToMany('App\Seguridad\GrupoUsuario');
    }
    public function usuarios()
    {
        return $this->belongsToMany('App\Seguridad\User');
    }

}
