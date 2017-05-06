<?php

namespace App\Http\Controllers\Core;

use App\Core\CatalogoItem;
use App\Http\Controllers\Controller;
use Response;

class DireccionController extends Controller
{
    public function provincias($pais_id)
    {

        $provincias = CatalogoItem::where('padre_id', $pais_id)->orderBy('descripcion', 'asc')->get();

        return Response::json($provincias);
    }
    public function ciudades($provincia_id)
    {

        $ciudades = CatalogoItem::where('padre_id', $provincia_id)->orderBy('descripcion', 'asc')->get();

        return Response::json($ciudades);
    }
}
