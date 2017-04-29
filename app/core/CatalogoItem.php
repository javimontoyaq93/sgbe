<?php

namespace App\\core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatalogoItem extends Model
{
    use SoftDeletes;
    protected $fillable = ['nombre', 'descripcion', 'orden', 'eliminado', 'catalogo_id', 'padre_id'];

    public function catalogo()
    {
        return $this->belongsTo('App\core\Catalogo', 'catalogo_id');
    }
    public function items()
    {
        return $this->hasMany('App\core\CatalogoItem', 'padre_id', 'id');
    }
}
