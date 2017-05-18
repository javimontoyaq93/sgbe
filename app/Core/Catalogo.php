<?php

namespace App\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Catalogo extends Model
{
    use SoftDeletes;
    protected $table      = 'core_catalogos';
    protected $primaryKey = 'id';
    protected $fillable   = ['nombre', 'descripcion', 'orden', 'eliminado'];

    /**
     *
     * Permite obtener los items de un catalogo.
     *
     */
    public function items()
    {
        return $this->hasMany('App\Core\CatalogoItem', 'catalogo_id', 'id');
    }
    public function prueba()
    {
        return [
            'ACTIVIDAD_ECONOMICA' => "",
            'HOME'                => "Home",
            'WORK'                => "Work",
        ];
    }
}
