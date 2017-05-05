<?php

namespace App\Http\Controllers\BolsaEmpleo;

use App\BolsaEmpleo\DireccionEmpleador;
use App\BolsaEmpleo\Empleador;
use App\Core\CatalogoItem;
use App\Http\Controllers\Controller;
use App\Util\DataType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Session;

class EmpleadorController extends Controller
{
    /**
     *
     * Permite mostrar los empleadores creados
     *
     */

    public function index()
    {
        $empleadores = Empleador::where('eliminado', false)->paginate(DataType::PAGINATE);
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
        $direcciones            = array();
        $empleador              = new Empleador();
        return view('bolsaEmpleo.empleador')->with('actividades_economicas', $actividades_economicas)->with('tipos_personeria', $tipos_personeria)->with('tipos_documentos', $tipos_documentos)->with('empleador', $empleador)->with('direcciones', $direcciones);
    }

    /**
     *
     * Permite guardar un empleador.
     *
     */

    public function guardar(Request $request)
    {
        $id        = null;
        $datos     = ['email' => $request->email, 'razon_social' => $request->razon_social, 'celular' => $request->celular, 'numero_identificacion' => $request->numero_identificacion, 'tipo_personeria' => $request->tipo_personeria, 'tipo_identificacion' => $request->tipo_identificacion, 'actividad_economica' => $request->actividad_economica];
        $validator = Validator::make($datos, Empleador::$rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        if (!$request->id) {
            $id = Empleador::create($datos)->id;
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
            $id = $empleador->id;
        }
        Session::flash('flash_message', 'Empleador grabado exitosamente');
        return redirect('/empleador/' . $id);
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
        $direcciones            = DireccionEmpleador::where('empleador_id', $empleador->id)->paginate(1);
        return view('bolsaEmpleo.empleador')->with('empleador', $empleador)->with('actividades_economicas', $actividades_economicas)->with('tipos_personeria', $tipos_personeria)->with('tipos_documentos', $tipos_documentos)->with('direcciones', $direcciones);
    }

    public function borrar(Request $request)
    {
        $empleador            = Empleador::find($request->id);
        $empleador->eliminado = true;
        $empleador->save();
        return redirect()->back();
    }

}
