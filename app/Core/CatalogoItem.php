<?php

namespace App\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatalogoItem extends Model
{
    use SoftDeletes;
    protected $table      = 'core_catalogos_items';
    protected $primaryKey = 'id';
    protected $fillable   = ['nombre', 'descripcion', 'orden', 'eliminado', 'catalogo_id', 'padre_id'];

    /**
     *
     * Permite obtener el catalogo el cual pertence el catalogo item.
     *
     */
    public function catalogo()
    {
        return $this->belongsTo('App\Core\Catalogo', 'catalogo_id');
    }

    /**
     *
     * Recursividad
     *
     */
    public function items()
    {
        return $this->hasMany('App\Core\CatalogoItem', 'padre_id', 'id');
    }

    /**
     *
     * Padre del catalogo item.
     *
     */
    public function padre()
    {
        return $this->belongsTo('App\Core\CatalogoItem', 'padre_id');
    }

}
