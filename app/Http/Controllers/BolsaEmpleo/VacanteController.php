<?php

namespace App\Http\Controllers\BolsaEmpleo;

use App\BolsaEmpleo\Puesto;
use App\BolsaEmpleo\Vacante;
use App\Http\Controllers\Controller;
use App\Seguridad\Usuario;
use App\Util\DataType;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Session;

class VacanteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *
     * Permite crea una vacante.
     *
     */

    public function crear($oferta_empleo_id)
    {
        $usuario          = Session::get(Auth::user()->name);
        $validar_permisos = Usuario::validarPermisos($usuario->id, DataType::EMPLEADOR);
        if (!$validar_permisos) {
            return redirect('home');
        }
        $vacante = new Vacante();
        $puestos = Puesto::where('eliminado', false)->get();

        return view('bolsaEmpleo.vacante')->with('puestos', $puestos)->with('vacante', $vacante)->with('oferta_empleo_id', $oferta_empleo_id);
    }

    /**
     *
     * Permite guardar una vacante.
     *
     */

    public function guardar(Request $request)
    {
        $usuario          = Session::get(Auth::user()->name);
        $validar_permisos = Usuario::validarPermisos($usuario->id, DataType::EMPLEADOR);
        if (!$validar_permisos) {
            return redirect('home');
        }
        $id        = null;
        $datos     = ['numero_vacante' => $request->numero_vacante, 'descripcion' => $request->descripcion, 'puesto_id' => $request->puesto_id, 'oferta_empleo_id' => $request->oferta_empleo_id];
        $validator = Validator::make($datos, Vacante::$rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        if (!$request->id) {
            $id = Vacante::create($datos)->id;

        } else {
            $vacante = Vacante::find($request->id);

            $vacante->numero_vacante   = $request->numero_vacante;
            $vacante->descripcion      = $request->descripcion;
            $vacante->puesto_id        = $request->puesto_id;
            $vacante->oferta_empleo_id = $request->oferta_empleo_idSS;
            $vacante->save();
            $id = $vacante->id;

        }
        Session::flash('flash_message', 'Vacante grabada exitosamente');
        return redirect('/vacante/' . $id);
    }

    /**
     *
     * Permite mostrar una vacante.
     *
     */
    public function show($id)
    {
        $usuario          = Session::get(Auth::user()->name);
        $validar_permisos = Usuario::validarPermisos($usuario->id, DataType::EMPLEADOR);
        if (!$validar_permisos) {
            return redirect('home');
        }

        $vacante = Vacante::find($id);
        $puestos = Puesto::where('eliminado', false)->get();
        return view('bolsaEmpleo.vacante')->with('puestos', $puestos)->with('vacante', $vacante)->with('oferta_empleo_id', $vacante->oferta_empleo_id);
    }
    /**
     *
     * Permite Borrar una vacante seleccionada.
     *
     */

    public function borrar(Request $request)
    {
        $usuario          = Session::get(Auth::user()->name);
        $validar_permisos = Usuario::validarPermisos($usuario->id, DataType::EMPLEADOR);
        if (!$validar_permisos) {
            return redirect('home');
        }
        $vacante            = Vacante::find($request->id);
        $vacante->eliminado = true;
        $vacante->save();
        return redirect()->back();
    }
}
