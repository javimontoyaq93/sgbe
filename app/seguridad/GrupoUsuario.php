<?php

namespace App\\Seguridad;

use Illuminate\Database\Eloquent\Model;

class GrupoUsuario extends Model
{
    protected $fillable = ['nombre', 'descripcion', 'eliminado'];

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
