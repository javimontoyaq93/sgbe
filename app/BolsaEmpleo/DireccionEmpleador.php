<?php

namespace App\BolsaEmpleo;

use App\BolsaEmpleo\Empleador;
use App\Core\Direccion;

class DireccionEmpleador extends Direccion
{
    public function __construct()
    {
        $this->direccion = new Direccion();
    }
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
    public function direccion()
    {
        return $this->belongsTo(Direccion::class, 'id');
    }
}
