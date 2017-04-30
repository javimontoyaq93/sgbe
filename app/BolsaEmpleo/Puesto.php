<?php

namespace App\\BolsaEmpleo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Puesto extends Model
{
    use SoftDeletes;
    protected $table      = 'bolsa_empleo_puestos';
    protected $primaryKey = 'id';
    protected $fillable   = ['denominacion', 'area_conocimiento', 'nivel_instruccion', 'eliminado', 'tiempo_experiencia', 'remuneracion'];

    /**
     *
     * Permite obtener las vacantes del puesto.
     *
     */

    public function vacantes()
    {
        return $this->hasMany('App\BolsaEmpleo\Vacante', 'puesto_id', 'id');
    }
}
