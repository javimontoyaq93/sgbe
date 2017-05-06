<?php

namespace App\Http\Controllers\BolsaEmpleo;

use App\BolsaEmpleo\DireccionEmpleador;
use App\Core\Catalogo;
use App\Core\CatalogoItem;
use App\Core\Direccion;
use App\Http\Controllers\Controller;
use App\Util\DataType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Session;

class DireccionEmpleadorController extends Controller
{
    public function crear($empleador_id)
    {

        $direccion               = new DireccionEmpleador();
        $catalogo_tipo_documento = Catalogo::where('nombre', DataType::TIPO_DIRECCION)->first();
        $catalogo_paises         = Catalogo::where('nombre', DataType::PAIS)->first();
        if (!$catalogo_tipo_documento && $catalogo_paises) {
            return redirect('/empleador/' . $empleador_id);
        }
        $tipos_direcciones = CatalogoItem::where('catalogo_id', $catalogo_tipo_documento->id)->get();
        $paises            = CatalogoItem::where('catalogo_id', $catalogo_paises->id)->orderBy('descripcion', 'asc')->get();
        $provincias        = array();
        $ciudades          = array();
        return view('bolsaEmpleo.direccionEmpleador')->with('empleador_id', $empleador_id)->with('direccion', $direccion)->with('tipos_direcciones', $tipos_direcciones)->with('paises', $paises)->with('provincias', $provincias)->with('ciudades', $ciudades);
    }
    public function guardar(Request $request)
    {
        $id        = null;
        $datos     = ['calles' => $request->calles, 'referencia' => $request->referencia, 'tipo_direccion' => $request->tipo_direccion, 'pais' => $request->pais, 'provincia' => $request->provincia, 'ciudad' => $request->ciudad, 'telefono' => $request->telefono];
        $validator = Validator::make($datos, Direccion::$rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        if (!$request->id) {
            $id                                = Direccion::create($datos)->id;
            $direccion_empleador               = new DireccionEmpleador();
            $direccion_empleador->empleador_id = $request->empleador_id;
            $direccion_empleador->id;
            $direccion_empleador->save();
        } else {
            $direccion                            = DireccionEmpleador::find($request->id);
            $direccion->direccion->calles         = $request->calles;
            $direccion->direccion->referencia     = $request->referencia;
            $direccion->direccion->tipo_direccion = $request->tipo_direccion;
            $direccion->direccion->pais           = $request->pais;
            $direccion->direccion->provincia      = $request->provincia;
            $direccion->direccion->ciudad         = $request->ciudad;
            $direccion->direccion->telefono       = $request->telefono;
            $direccion->direccion->save();
            $id = $direccion->id;
        }
        Session::flash('flash_message', 'Direccion grabada exitosamente');
        return redirect('/direccion-empleador/' . $id);
    }
    public function show($id)
    {
        $catalogo_tipo_documento = Catalogo::where('nombre', DataType::TIPO_DIRECCION)->first();
        $catalogo_paises         = Catalogo::where('nombre', DataType::PAIS)->first();
        if (!$catalogo_tipo_documento && $catalogo_paises) {
            return redirect('/empleador/' . $empleador_id);
        }
        $tipos_direcciones = CatalogoItem::where('catalogo_id', $catalogo_tipo_documento->id)->get();
        $paises            = CatalogoItem::where('catalogo_id', $catalogo_paises->id)->orderBy('descripcion', 'asc')->get();
        $provincias        = array();
        $ciudades          = array();
        $direccion         = DireccionEmpleador::find($id);
        if ($direccion->direccion->pais) {
            $provincias = CatalogoItem::where('padre_id', $direccion->direccion->pais)->orderBy('descripcion', 'asc')->get();
        }
        if ($direccion->direccion->provincia) {
            $ciudades = CatalogoItem::where('padre_id', $direccion->direccion->provincia)->orderBy('descripcion', 'asc')->get();
        }
        return view('bolsaEmpleo.direccionEmpleador')->with('empleador_id', $direccion->empleador_id)->with('direccion', $direccion)->with('tipos_direcciones', $tipos_direcciones)->with('paises', $paises)->with('provincias', $provincias)->with('ciudades', $ciudades);
    }
}
