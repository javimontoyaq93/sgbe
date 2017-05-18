<?php

namespace App\Http\Controllers\BolsaEmpleo;

use App\BolsaEmpleo\Empleador;
use App\BolsaEmpleo\OfertaEmpleo;
use App\BolsaEmpleo\Vacante;
use App\Http\Controllers\Controller;
use App\Seguridad\Usuario;
use App\Util\DataType;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Session;

class OfertaEmpleoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     *
     * Permute devolver las ofertas de empleo aun no eliminadas.
     *
     */

    public function index()
    {
        $usuario          = Session::get(Auth::user()->name);
        $validar_permisos = Usuario::validarPermisos($usuario->id, DataType::EMPLEADOR);
        if (!$validar_permisos) {
            return redirect('home');
        }
        $ofertasEmpleo = array();
        if ($usuario && $usuario->usuarioEmpleador) {
            $ofertasEmpleo = OfertaEmpleo::where('eliminado', false)->where('empleador_id', $usuario->usuarioEmpleador->empleador_id)->paginate(DataType::PAGINATE);
        } else {
            $ofertasEmpleo = OfertaEmpleo::where('eliminado', false)->paginate(DataType::PAGINATE);
        }
        return view('bolsaEmpleo.ofertasEmpleo')->with('ofertasEmpleo', $ofertasEmpleo);
    }
    /**
     *
     * Permite crea una oferta de empleo.
     *
     */

    public function crear()
    {
        $usuario          = Session::get(Auth::user()->name);
        $validar_permisos = Usuario::validarPermisos($usuario->id, DataType::EMPLEADOR);
        if (!$validar_permisos) {
            return redirect('home');
        }
        $ofertaEmpleo = new OfertaEmpleo();
        $empleadores  = array();
        if (!$usuario->usuarioEmpleador) {
            $empleadores = Empleador::where('eliminado', false)->get();
        }
        $vacantes = array();
        return view('bolsaEmpleo.ofertaEmpleo')->with('empleadores', $empleadores)->with('ofertaEmpleo', $ofertaEmpleo)->with('usuario', $usuario)->with('vacantes', $vacantes);
    }

    /**
     *
     * Permite guardar una oferta de empleo.
     *
     */

    public function guardar(Request $request)
    {
        DB::beginTransaction();
        try {
            $usuario          = Session::get(Auth::user()->name);
            $validar_permisos = Usuario::validarPermisos($usuario->id, DataType::EMPLEADOR);
            if (!$validar_permisos) {
                return redirect('home');
            }
            $id        = null;
            $datos     = ['descripcion' => $request->descripcion, 'fecha_inicio' => $request->fecha_inicio, 'fecha_fin' => $request->fecha_fin, 'empleador_id' => $request->empleador_id];
            $validator = Validator::make($datos, OfertaEmpleo::$rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors());
            }

            if (!$request->id) {
                $id = OfertaEmpleo::create($datos)->id;

            } else {
                $ofertaEmpleo = OfertaEmpleo::find($request->id);

                $ofertaEmpleo->descripcion  = $request->descripcion;
                $ofertaEmpleo->fecha_inicio = $request->fecha_inicio;
                $ofertaEmpleo->fecha_fin    = $request->fecha_fin;
                $ofertaEmpleo->empleador_id = $request->empleador_id;
                $ofertaEmpleo->save();
                $id = $ofertaEmpleo->id;

            }
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
        DB::commit();
        Session::flash('flash_message', 'Oferta de Empleo grabada exitosamente');
        return redirect('/ofertaEmpleo/' . $id);
    }

    /**
     *
     * Permite oferta de empleo.
     *
     */
    public function show($id)
    {
        $usuario          = Session::get(Auth::user()->name);
        $validar_permisos = Usuario::validarPermisos($usuario->id, DataType::EMPLEADOR);
        if (!$validar_permisos) {
            return redirect('home');
        }

        $ofertaEmpleo = OfertaEmpleo::find($id);
        $empleadores  = array();
        if (!$usuario->usuarioEmpleador) {
            $empleadores = Empleador::where('eliminado', false)->get();
        }
        $vacantes = Vacante::where('oferta_empleo_id', $ofertaEmpleo->id)->where('eliminado', false)->paginate(DataType::PAGINATE);
        return view('bolsaEmpleo.ofertaEmpleo')->with('empleadores', $empleadores)->with('ofertaEmpleo', $ofertaEmpleo)->with('usuario', $usuario)->with('vacantes', $vacantes);
    }
    /**
     *
     * Permite Borrar un oferta seleccionado
     *
     */

    public function borrar(Request $request)
    {
        $usuario          = Session::get(Auth::user()->name);
        $validar_permisos = Usuario::validarPermisos($usuario->id, DataType::EMPLEADOR);
        if (!$validar_permisos) {
            return redirect('home');
        }
        $ofertaEmpleo            = OfertaEmpleo::find($request->id);
        $ofertaEmpleo->eliminado = true;
        $ofertaEmpleo->save();
        return redirect()->back();
    }
}
