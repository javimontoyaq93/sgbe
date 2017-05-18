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
    protected $fillable   = ['referencia', 'calles', 'telefono', 'tipo_direccion', 'pais', 'provincia', 'ciudad', 'eliminado'];

    public function tipoDireccion()
    {
        return $this->belongsTo(CatalogoItem::class, 'tipo_direccion');
    }
    public function getPais()
    {
        return $this->belongsTo(CatalogoItem::class, 'pais');
    }
    public function getProvincia()
    {
        return $this->belongsTo(CatalogoItem::class, 'provincia');
    }
    public function getCiudad()
    {
        return $this->belongsTo(CatalogoItem::class, 'ciudad');
    }
    public static $rules = array(
        'calles'         => 'required|min:10',
        'referencia'     => 'required|min:10',
        'tipo_direccion' => 'required',
        'pais'           => 'required',
        'provincia'      => 'required',
        'ciudad'         => 'required',
    );
}
