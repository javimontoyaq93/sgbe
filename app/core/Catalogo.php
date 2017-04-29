<?php

namespace App\\core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Catalogo extends Model
{
    use SoftDeletes;
    protected $table = 'core_catalogo';

    protected $primaryKey = 'id';
    protected $fillable   = ['nombre', 'descripcion', 'orden', 'eliminado'];

    public function items()
    {
        return $this->hasMany('App\core\CatalogoItem', 'catalogo_id', 'id');
    }
}
