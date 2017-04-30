<?php

namespace App\\Seguridad;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permiso extends Model
{
    use SoftDeletes;
    protected $table      = 'seguridad_permisos';
    protected $primaryKey = 'id';
    protected $fillable   = ['nombre', 'descripcion', 'codigo', 'eliminado'];

    public function grupos()
    {
        return $this->belongsToMany('App\Seguridad\GrupoUsuario');
    }

    public function usuarios()
    {
        return $this->belongsToMany('App\Seguridad\Usuarios');
    }
}
