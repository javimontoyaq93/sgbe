<?php

namespace App\Seguridad;

use App\BolsaEmpleo\Postulante;
use App\Seguridad\Usuario;
use Illuminate\Database\Eloquent\Model;

class UsuarioPostulante extends Model
{
    protected $table    = 'seguridad_usuarios_postulantes';
    protected $fillable = ['postulante_id'];
    public function __construct()
    {
        $this->postulante_id = new Postulante();
    }

    public function postulante()
    {
        return $this->belongsTo(Postulante::class, 'postulante_id');
    }
    public function usuario()
    {
        return $this->belongsTo('App\Seguridad\Usuario', 'id');
    }
}
