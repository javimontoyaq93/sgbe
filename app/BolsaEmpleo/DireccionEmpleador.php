<?php

namespace App\\BolsaEmpleo;

use App\Core\Direccion;
use Illuminate\Database\Eloquent\SoftDeletes;

class DireccionEmpleador extends Direccion
{
    use SoftDeletes;
    protected $table    = 'core_direcciones_empleadores';
    protected $fillable = ['empleador_id'];

    /**
     *
     * Permite obtener el empleador de la direccion.
     *
     */

    public function empleador()
    {
        return $this->belongsTo('App\BolsaEmpleo\Empleador', 'empleador_id');
    }
}
