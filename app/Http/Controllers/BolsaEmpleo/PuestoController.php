<?php

namespace App\Http\Controllers\BolsaEmpleo;

use App\BolsaEmpleo\Empleador;
use App\BolsaEmpleo\Puesto;
use App\Core\Catalogo;
use App\Core\CatalogoItem;
use App\Http\Controllers\Controller;
use App\Seguridad\Usuario;
use App\User;
use App\Util\DataType;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Response;
use Session;

class PuestoController extends Controller
{
    public function index()
    {
        $usuario          = Session::get(Auth::user()->name);
        $validar_permisos = Usuario::validarPermisos($usuario->id, DataType::EMPLEADOR);
        $puestos          = array();
        if (!$validar_permisos) {
            return redirect('home');
        }
        if ($usuario->usuarioEmpleador) {
            $puestos = Puesto::where('eliminado', false)->where('empleador_id', $usuario->usuarioEmpleador->empleador_id)->paginate(DataType::PAGINATE);
        } else {
            $puestos = Puesto::where('eliminado', false)->paginate(DataType::PAGINATE);
        }
        return view('bolsaEmpleo.puestos')->with('puestos', $puestos);
    }
    public function crear()
    {
        $usuario          = Session::get(Auth::user()->name);
        $validar_permisos = Usuario::validarPermisos($usuario->id, DataType::EMPLEADOR);
        if (!$validar_permisos) {
            return redirect('home');
        }
        $catalogo_nivel_instruccion = Catalogo::where('nombre', DataType::NIVEL_INSTRUCCION)->first();
        if (!$catalogo_nivel_instruccion) {
            return redirect()->back();
        }
        $catalogo_especialidad = Catalogo::where('nombre', DataType::ESPECIALIDAD)->first();
        $especialidades        = CatalogoItem::where('catalogo_id', $catalogo_especialidad->id)->get();
        $empleadores           = array();
        if (!$usuario->usuarioEmpleador) {
            $empleadores = Empleador::where('eliminado', false)->get();
        }
        $niveles_instruccion = CatalogoItem::where('catalogo_id', $catalogo_nivel_instruccion->id)->get();
        $puesto              = new Puesto();
        return view('bolsaEmpleo.puesto')->with('niveles_instruccion', $niveles_instruccion)->with('puesto', $puesto)->with('empleadores', $empleadores)->with('usuario', $usuario)->with('especialidades', $especialidades);
    }

    /**
     *
     * Permite guardar un puesto.
     *
     */

    public function guardar(Request $request)
    {
        DB::beginTransaction();
        try {
            $id        = null;
            $datos     = ['denominacion' => $request->denominacion, 'nivel_instruccion' => $request->nivel_instruccion, 'area_conocimiento' => $request->area_conocimiento, 'remuneracion' => $request->remuneracion, 'tiempo_experiencia' => $request->tiempo_experiencia, 'empleador_id' => $request->empleador_id];
            $validator = Validator::make($datos, Puesto::$rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors());
            }

            if (!$request->id) {
                $id = Puesto::create($datos)->id;

            } else {
                $puesto                     = Puesto::find($request->id);
                $puesto->denominacion       = $request->denominacion;
                $puesto->area_conocimiento  = $request->area_conocimiento;
                $puesto->remuneracion       = $request->remuneracion;
                $puesto->tiempo_experiencia = $request->tiempo_experiencia;
                $puesto->empleador_id       = $request->empleador_id;
                $puesto->save();
                $id = $puesto->id;

            }
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
        DB::commit();
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
        $usuario          = Session::get(Auth::user()->name);
        $validar_permisos = Usuario::validarPermisos($usuario->id, DataType::EMPLEADOR);
        if (!$validar_permisos) {
            return redirect('home');
        }
        $catalogo_nivel_instruccion = Catalogo::where('nombre', DataType::NIVEL_INSTRUCCION)->first();
        $catalogo_especialidad      = Catalogo::where('nombre', DataType::ESPECIALIDAD)->first();
        if (!$catalogo_nivel_instruccion && !$catalogo_especialidad) {
            return redirect()->back();
        }
        $empleadores = array();
        if (!$usuario->usuarioEmpleador) {
            $empleadores = Empleador::where('eliminado', false)->get();
        }
        $especialidades      = CatalogoItem::where('catalogo_id', $catalogo_especialidad->id)->get();
        $niveles_instruccion = CatalogoItem::where('catalogo_id', $catalogo_nivel_instruccion->id)->get();
        $puesto              = Puesto::find($id);

        return view('bolsaEmpleo.puesto')->with('puesto', $puesto)->with('niveles_instruccion', $niveles_instruccion)->with('especialidades', $especialidades)->with('usuario', $usuario)->with('empleadores', $empleadores);
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
    /**
     *
     * Permite retornar un puesto por id en formato json.
     *
     */

    public function puestoPorId($puesto_id)
    {
        $puesto = Puesto::find($puesto_id);
        return Response::json($puesto);
    }
}
