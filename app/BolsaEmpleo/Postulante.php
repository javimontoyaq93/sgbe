<?php

namespace App\\BolsaEmpleo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Postulante extends Model
{
    use SoftDeletes;
    protected $table      = 'bolsa_empleo_postulantes';
    protected $primaryKey = 'id';
    protected $fillable   = ['nombres', 'apellidos', 'numero_documento', 'eliminado', 'email', 'celular', 'estado_civil', 'genero', 'tipo_identificacion'];

    /**
     *
     * Permite obtener las direcciones del Postulante.
     *
     */

    public function direcciones()
    {
        return $this->hasMany('App\BolsaEmpleo\DireccionPostulante', 'postulante_id', 'id');
    }
}
