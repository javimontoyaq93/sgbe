<?php

namespace App\BolsaEmpleo;

use App\BolsaEmpleo\DireccionEmpleador;
use App\Core\CatalogoItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empleador extends Model
{
    use SoftDeletes;
    protected $table      = 'bolsa_empleo_empleadores';
    protected $primaryKey = 'id';
    protected $fillable   = ['razon_social', 'email', 'numero_identificacion', 'actividad_economica', 'tipo_identificacion', 'tipo_personeria', 'celular', 'eliminado'];

    /**
     *
     * Permite obtener las ofertas de empleo de un empleador.
     *
     */

    public function ofertasEmpleo()
    {
        return $this->hasMany('App\BolsaEmpleo\OfertaEmpleo', 'empleador_id', 'id');
    }

    /**
     *
     * Permite obtener las direcciones de un empleador.
     *
     */

    public function direcciones()
    {
        return $this->hasMany(DireccionEmpleador::class, 'empleador_id', 'id');
    }
    public function tipoIdentificacion()
    {
        return $this->belongsTo(CatalogoItem::class, 'tipo_identificacion');
    }
    public function actividadEconomica()
    {
        return $this->belongsTo(CatalogoItem::class, 'actividad_economica');
    }
    public static $rules = array(
        'actividad_economica'   => 'required',
        'tipo_identificacion'   => 'required',
        'tipo_personeria'       => 'required',
        'email'                 => 'required|email',
        'razon_social'          => 'required|min:4',
        'numero_identificacion' => 'required|min:10',
    );
}
