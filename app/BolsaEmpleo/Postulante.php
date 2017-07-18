<?php

namespace App\BolsaEmpleo;

use App\Core\CatalogoItem;
use App\Seguridad\UsuarioPostulante;
use Illuminate\Database\Eloquent\Model;

class Postulante extends Model
{
    protected $table      = 'bolsa_empleo_postulantes';
    protected $primaryKey = 'id';
    protected $fillable   = ['nombres', 'apellidos', 'numero_identificacion', 'eliminado', 'email', 'celular', 'estado_civil', 'genero', 'tipo_identificacion', 'fecha_nacimiento', 'especialidad', 'observacion'];

    /**
     *
     * Permite obtener las direcciones del Postulante.
     *
     */

    public function direcciones()
    {
        return $this->hasMany('App\BolsaEmpleo\DireccionPostulante', 'postulante_id', 'id');
    }
    public function tipoIdentificacion()
    {
        return $this->belongsTo(CatalogoItem::class, 'tipo_identificacion');
    }
    public function estadoCivil()
    {
        return $this->belongsTo(CatalogoItem::class, 'estado_civil');
    }
    public function getGenero()
    {
        return $this->belongsTo(CatalogoItem::class, 'genero');
    }
    public function usuarios()
    {
        return $this->hasMany(UsuarioPostulante::class, 'postulante_id', 'id');
    }
    /**
     *
     * Reglas de validación de campos.
     *
     */

    public static $rules = array(
        'nombres'               => 'required',
        'apellidos'             => 'required',
        'tipo_identificacion'   => 'required',
        'email'                 => 'required|email|unique:bolsa_empleo_postulantes',
        'estado_civil'          => 'required',
        'genero'                => 'required',
        'numero_identificacion' => 'required|min:4|unique:bolsa_empleo_postulantes',
        'fecha_nacimiento'      => 'required|date',
    );
}
