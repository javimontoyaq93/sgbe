<?php

namespace App\Core;

use App\Core\CatalogoItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Direccion extends Model
{
    use SoftDeletes;
    protected $table = 'core_direcciones';

    protected $primaryKey = 'id';
    protected $fillable   = ['referencia', 'calles', 'telefono', 'tipo_direccion', 'pais', 'ciudad', 'eliminado'];

    public function tipoDireccion()
    {
        return $this->belongsTo(CatalogoItem::class, 'tipo_direccion');
    }
    public static $rules = array(
        'calles'         => 'required|min:10',
        'referencia'     => 'required|min:10',
        'tipo_direccion' => 'required',
    );
}
