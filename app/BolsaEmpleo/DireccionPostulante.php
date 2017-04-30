<?php

namespace App\\BolsaEmpleo;

use App\Core\Direccion;
use Illuminate\Database\Eloquent\SoftDeletes;

class DireccionPostulante extends Direccion
{
    use SoftDeletes;
    protected $table    = 'core_direcciones_postulantes';
    protected $fillable = ['postulante_id'];

    /**
     *
     * Permite obtener el postulante de la dirección.
     *
     */

    public function postulante()
    {
        return $this->belongsTo('App\BolsaEmpleo\Postulante', 'postulante_id');
    }
}
