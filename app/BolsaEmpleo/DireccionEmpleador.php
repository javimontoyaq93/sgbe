<?php

namespace App\BolsaEmpleo;

use App\BolsaEmpleo\Empleador;
use App\Core\Direccion;

class DireccionEmpleador extends Direccion
{

    protected $table    = 'bolsa_empleo_direcciones_empleadores';
    protected $fillable = ['empleador_id'];

    /**
     *
     * Permite obtener el empleador de la direccion.
     *
     */

    public function empleador()
    {
        return $this->belongsTo(Empleador::class, 'id');
    }
}
