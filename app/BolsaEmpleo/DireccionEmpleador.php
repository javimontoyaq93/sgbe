<?php

namespace App\BolsaEmpleo;

use App\BolsaEmpleo\Empleador;
use App\Core\Direccion;

class DireccionEmpleador extends Direccion
{

    protected $table    = 'bolsa_empleo_direcciones_empleadores';
    protected $fillable = ['empleador_id', 'eliminado'];

    /**
     *
     * Permite obtener el empleador de la direccion.
     *
     */

    public function empleador()
    {
        return $this->belongsTo(Empleador::class, 'empleador_id');
    }
    public function direccion()
    {
        return $this->belongsTo(Direccion::class, 'id');
    }
}
