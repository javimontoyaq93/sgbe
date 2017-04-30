<?php

namespace App\\BolsaEmpleo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfertEmpleo extends Model
{
    use SoftDeletes;
    protected $table      = 'bolsa_empleo_ofertas_empleos';
    protected $primaryKey = 'id';
    protected $fillable   = ['nombres', 'apellidos', 'numero_documento', 'eliminado', 'email', 'celular', 'estado_civil', 'genero', 'tipo_identificacion', 'empleador_id'];

    /**
     *
     * Permite obtener las vacantes que se ofertan.
     *
     */

    public function vacantes()
    {
        return $this->hasMany('App\BolsaEmpleo\Vacante', 'oferta_empleo_id', 'id');
    }

    /**
     *
     * Permite obtener el empleador de las oferta de empleo.
     *
     */

    public function empleador()
    {
        return $this->belongsTo('App\BolsaEmpleo\Empleador', 'empleador_id');
    }
}
