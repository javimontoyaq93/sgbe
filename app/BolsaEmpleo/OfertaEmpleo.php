<?php

namespace App\BolsaEmpleo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfertaEmpleo extends Model
{
    use SoftDeletes;
    protected $table      = 'bolsa_empleo_ofertas_empleos';
    protected $primaryKey = 'id';
    protected $fillable   = ['descripcion', 'fecha_inicio', 'fecha_fin', 'eliminado', 'empleador_id'];

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
    public static $rules = array(
        'descripcion'  => 'required|min:10',
        'fecha_inicio' => 'required|date',
        'fecha_fin'    => 'required|date',
        'empleador_id' => 'required',
    );
}
