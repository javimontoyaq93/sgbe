<?php

namespace App\\bolsa_empleo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Postulante extends Model
{
    use SoftDeletes;

    protected $fillable = ['nombres', 'apellidos', 'numero_documento', 'eliminado', 'telefono', 'celular'];
}
