<?php

namespace App\Http\Controllers\BolsaEmpleo;

use App\BolsaEmpleo\Puesto;
use App\Core\Catalogo;
use App\Core\CatalogoItem;
use App\Http\Controllers\Controller;
use App\Util\DataType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Session;

class PuestoController extends Controller
{
    public function index()
    {
        $puestos = Puesto::where('eliminado', false)->paginate(DataType::PAGINATE);
        return view('bolsaEmpleo.puestos')->with('puestos', $puestos);
    }
    public function crear()
    {
        $catalogo_nivel_instruccion = Catalogo::where('nombre', DataType::NIVEL_INSTRUCCION)->first();
        if (!$catalogo_nivel_instruccion) {
            return redirect()->back();
        }

        $niveles_instruccion = CatalogoItem::where('catalogo_id', $catalogo_nivel_instruccion->id)->get();
        $puesto              = new Puesto();
        return view('bolsaEmpleo.puesto')->with('niveles_instruccion', $niveles_instruccion)->with('puesto', $puesto);
    }

    /**
     *
     * Permite guardar un puesto.
     *
     */

    public function guardar(Request $request)
    {
        $id        = null;
        $datos     = ['denominacion' => $request->denominacion, 'nivel_instruccion' => $request->nivel_instruccion, 'area_conocimiento' => $request->area_conocimiento, 'remuneracion' => $request->remuneracion, 'tiempo_experiencia' => $request->tiempo_experiencia];
        $validator = Validator::make($datos, Puesto::$rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        if (!$request->id) {
            $id = $puesto = Puesto::create($datos)->id;

        } else {
            $puesto = Puesto::find($request->id);

            $puesto->denominacion       = $request->denominacion;
            $puesto->area_conocimiento  = $request->area_conocimiento;
            $puesto->remuneracion       = $request->remuneracion;
            $puesto->tiempo_experiencia = $request->tiempo_experiencia;
            $puesto->save();
            $id = $puesto->id;

        }
        Session::flash('flash_message', 'Puesto grabado exitosamente');
        return redirect('/puesto/' . $id);
    }

    /**
     *
     * Permite mmostrar un empleador.
     *
     */
    public function show($id)
    {
        $catalogo_nivel_instruccion = Catalogo::where('nombre', DataType::NIVEL_INSTRUCCION)->first();
        if (!$catalogo_nivel_instruccion) {
            return redirect()->back();
        }

        $niveles_instruccion = CatalogoItem::where('catalogo_id', $catalogo_nivel_instruccion->id)->get();
        $puesto              = Puesto::find($id);

        return view('bolsaEmpleo.puesto')->with('puesto', $puesto)->with('niveles_instruccion', $niveles_instruccion);
    }
    /**
     *
     * Permite Borrar un puesto seleccionado
     *
     */

    public function borrar(Request $request)
    {
        $puesto            = Puesto::find($request->id);
        $puesto->eliminado = true;
        $puesto->save();
        return redirect()->back();
    }
}
