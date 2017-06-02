<?php

namespace App\BolsaEmpleo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vacante extends Model
{
    use SoftDeletes;
    protected $table      = 'bolsa_empleo_vacantes';
    protected $primaryKey = 'id';
    protected $fillable   = ['numero_vacante', 'descripcion', 'puesto_id', 'eliminado', 'oferta_empleo_id'];

    /**
     *
     * Permute obtener los detalles de la vacante.
     *
     */
    public function detallesVacante()
    {
        return $this->hasMany('App\BolsaEmpleo\DetalleVacante', 'vacante_id', 'id');
    }

    /**
     *
     * Permite obtener la oferta de empleo de la vacante.
     *
     */
    public function ofertaEmpleo()
    {
        return $this->belongsTo('App\BolsaEmpleo\OfertaEmpleo', 'oferta_empleo_id');
    }

    /**
     *
     * Permite obtener el puesto de la vacante.
     *
     */
    public function puesto()
    {
        return $this->belongsTo('App\BolsaEmpleo\Puesto', 'puesto_id');
    }
    public static $rules = array(
        'numero_vacante'   => 'required',
        'descripcion'      => 'required|min:4',
        'puesto_id'        => 'required|alpha_num',
        'oferta_empleo_id' => 'required',
    );
}
