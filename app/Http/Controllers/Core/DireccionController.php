<?php

namespace App\Http\Controllers\Core;

use App\Core\CatalogoItem;
use App\Http\Controllers\Controller;
use Response;

class DireccionController extends Controller
{
    public function provincias($pais_id)
    {

        $provincias = CatalogoItem::where('padre_id', $pais_id)->get();

        return Response::json($provincias);
    }
}
