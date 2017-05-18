<?php

namespace App\BolsaEmpleo;

use App\Core\Direccion;

class DireccionPostulante extends Direccion
{
    protected $table    = 'bolsa_empleo_direcciones_postulantes';
    protected $fillable = ['postulante_id', 'eliminado'];

    /**
     *
     * Permite obtener el postulante de la dirección.
     *
     */

    public function postulante()
    {
        return $this->belongsTo('App\BolsaEmpleo\Postulante', 'postulante_id');
    }
    public function direccion()
    {
        return $this->belongsTo(Direccion::class, 'id');
    }
}
