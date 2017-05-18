<?php

namespace App\BolsaEmpleo;

use App\Core\CatalogoItem;
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
    public function nivelInstruccion()
    {
        return $this->belongsTo(CatalogoItem::class, 'nivel_instruccion');
    }
    public static $rules = array(
        'denominacion'       => 'required|min:10',
        'nivel_instruccion'  => 'required',
        'remuneracion'       => 'required',
        'area_conocimiento'  => 'required|min:10',
        'tiempo_experiencia' => 'required',
    );
}
