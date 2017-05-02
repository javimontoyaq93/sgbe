<?php

namespace App\Http\Controllers\BolsaEmpleo;

use App\BolsaEmpleo\Empleador;
use App\Core\CatalogoItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmpleadorController extends Controller
{
    /**
     *
     * Permite mostrar los empleadores creados
     *
     */

    public function index()
    {
        $empleadores = Empleador::where('eliminado', false)->get();
        return view('bolsaEmpleo.empleadores')->with('empleadores', $empleadores);
    }

    /**
     *
     * Permite crear un nuevo empleador.
     *
     */

    public function crear()
    {
        $actividades_economicas = CatalogoItem::where('catalogo_id', 22)->get();
        $tipos_documentos       = CatalogoItem::where('catalogo_id', 10)->get();
        $tipos_personeria       = CatalogoItem::where('catalogo_id', 18)->get();
        $empleador              = new Empleador();
        return view('bolsaEmpleo.empleador')->with('actividades_economicas', $actividades_economicas)->with('tipos_personeria', $tipos_personeria)->with('tipos_documentos', $tipos_documentos)->with('empleador', $empleador);
    }

    /**
     *
     * Permite guardar un empleador.
     *
     */

    public function guardar(Request $request)
    {

        $datos     = ['email' => $request->email, 'razon_social' => $request->razon_social, 'celular' => $request->celular, 'numero_identificacion' => $request->numero_identificacion, 'tipo_personeria' => $request->tipo_personeria, 'tipo_identificacion' => $request->tipo_identificacion, 'actividad_economica' => $request->actividad_economica];
        $validator = Validator::make($datos, Empleador::$rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        if (!$request->id) {
            Empleador::create($datos);
        } else {
            $empleador                        = Empleador::find($request->id);
            $empleador->razon_social          = $request->razon_social;
            $empleador->email                 = $request->email;
            $empleador->numero_identificacion = $request->numero_identificacion;
            $empleador->tipo_identificacion   = $request->tipo_identificacion;
            $empleador->tipo_personeria       = $request->tipo_personeria;
            $empleador->actividad_economica   = $request->actividad_economica;
            $empleador->celular               = $request->celular;
            $empleador->save();
        }
        return redirect('/empleadores');
    }

    /**
     *
     * Permite mmostrar un empleador.
     *
     */
    public function show($id)
    {
        $actividades_economicas = CatalogoItem::where('catalogo_id', 22)->get();
        $tipos_documentos       = CatalogoItem::where('catalogo_id', 10)->get();
        $tipos_personeria       = CatalogoItem::where('catalogo_id', 18)->get();
        $empleador              = Empleador::find($id);
        return view('bolsaEmpleo.empleador')->with('empleador', $empleador)->with('actividades_economicas', $actividades_economicas)->with('tipos_personeria', $tipos_personeria)->with('tipos_documentos', $tipos_documentos);
    }
    public function borrar($id)
    {
        $empleador            = Empleador::find($id);
        $empleador->eliminado = false;
        $empleador->save();
        return redirect('/empleadores');
    }
}
