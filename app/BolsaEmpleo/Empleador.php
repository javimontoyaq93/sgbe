<?php

namespace App\BolsaEmpleo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empleador extends Model
{
    use SoftDeletes;
    protected $table      = 'bolsa_empleo_empleadores';
    protected $primaryKey = 'id';
    protected $fillable   = ['razon_social', 'email', 'numero_identicacion', 'actividad_economica', 'tipo_identificacion', 'tipo_personeria', 'celular', 'eliminado'];

    /**
     *
     * Permite obtener las ofertas de empleo de un empleador.
     *
     */

    public function ofertasEmpleo()
    {
        return $this->hasMany('App\BolsaEmpleo\OfertaEmpleo', 'empleador_id', 'id');
    }

    /**
     *
     * Permite obtener las direcciones de un empleador.
     *
     */

    public function direcciones()
    {
        return $this->hasMany('App\BolsaEmpleo\DireccionEmpleador', 'empleador_id', 'id');
    }
