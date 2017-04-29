<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleador extends Model
{
    use SoftDeletes;
    protected $table = 'bolsa_empleo_empleadores';

    protected $primaryKey = 'id';
    protected $fillable   = ['nombre', 'descripcion', 'orden', 'eliminado'];
}
