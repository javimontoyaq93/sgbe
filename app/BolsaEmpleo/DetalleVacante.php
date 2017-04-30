<?php

namespace App\\BolsaEmpleo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleVacante extends Model
{
    use SoftDeletes;
    protected $table      = 'bolsa_empleo_detalles_vacantes';
    protected $primaryKey = 'id';
    protected $fillable   = ['nombre', 'descripcion', 'padre_id', 'eliminado', 'vacante_id'];

    /**
     *
     * Permite obtener la vacante la cual pertenece el detalle.
     *
     */

    public function vacante()
    {
        return $this->belongsTo('App\BolsaEmpleo\Vacante', 'vacante_id');
    }

    /**
     *
     * Recursividad
     *
     */

    public function detallesVacante()
    {
        return $this->hasMany('App\BolsaEmpleo\DetalleVacante', 'padre_id', 'id');
    }
    /**
     *
     * Padre del detalle de vacante.
     *
     */

    public function vacante()
    {
        return $this->belongsTo('App\BolsaEmpleo\DetalleVacante', 'padre_id');
    }
}
