<?php

namespace App\\seguridad;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permiso extends Model
{
    use SoftDeletes;
    protected $fillable = ['nombre', 'descripcion', 'eliminado'];
    public function grupos()
    {
        return $this->belongsToMany('App\Seguridad\GrupoUsuario');
    }
    public function usuarios()
    {
        return $this->belongsToMany('App\Seguridad\User');
    }
}
