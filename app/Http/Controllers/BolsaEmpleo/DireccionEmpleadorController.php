<?php

namespace App\Http\Controllers\BolsaEmpleo;

use App\BolsaEmpleo\DireccionEmpleador;
use App\Core\CatalogoItem;
use App\Core\Direccion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Session;

class DireccionEmpleadorController extends Controller
{
    public function crear($empleador_id)
    {

        $direccion         = new DireccionEmpleador();
        $tipos_direcciones = CatalogoItem::where('catalogo_id', 9)->get();
        return view('bolsaEmpleo.direccionEmpleador')->with('empleador_id', $empleador_id)->with('direccion', $direccion)->with('tipos_direcciones', $tipos_direcciones);
    }
    public function guardar(Request $request)
    {
        $id        = null;
        $datos     = ['calles' => $request->calles, 'referencia' => $request->referencia, 'tipo_direccion' => $request->tipo_direccion];
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
            $direccion                 = DireccionEmpleador::find($request->id);
            $direccion->calles         = $request->calles;
            $direccion->referencia     = $request->referencia;
            $direccion->tipo_direccion = $request->tipo_direccion;
            $direccion->save();
            $id = $direccion->id;
        }
        Session::flash('flash_message', 'Direccion grabada exitosamente');
        return redirect('/direccion-empleador/' . $id);
    }
    public function show($id)
    {
        $actividades_economicas = CatalogoItem::where('catalogo_id', 22)->get();
        $tipos_documentos       = CatalogoItem::where('catalogo_id', 10)->get();
        $tipos_personeria       = CatalogoItem::where('catalogo_id', 18)->get();
        $empleador              = Empleador::find($id);
        return view('bolsaEmpleo.empleador')->with('empleador', $empleador)->with('actividades_economicas', $actividades_economicas)->with('tipos_personeria', $tipos_personeria)->with('tipos_documentos', $tipos_documentos);
    }
}
