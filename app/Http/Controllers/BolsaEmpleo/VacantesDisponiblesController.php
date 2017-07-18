<?php

namespace App\Http\Controllers\BolsaEmpleo;

use App\BolsaEmpleo\Vacante;
use App\Http\Controllers\Controller;
use App\Seguridad\Usuario;
use App\User;
use App\Util\DataType;
use Auth;
use Session;

class VacantesDisponiblesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $usuario          = Session::get(Auth::user()->name);
        $validar_permisos = Usuario::validarPermisos($usuario->id, DataType::POSTULANTE);
        if (!$validar_permisos) {
            return redirect('home');
        }

        $vacantes_disponibles = Vacante::whereHas('ofertaEmpleo', function ($oe) {
            $now = date('Y-m-d');
            $oe->where('fecha_inicio', '<=', $now)->where('fecha_fin', '>=', $now);
        })->whereHas('puesto', function ($puesto) {
            $usuario = Session::get(Auth::user()->name);
            if ($usuario->usuarioPostulante) {
                $puesto->where('area_conocimiento', $usuario->usuarioPostulante->postulante->especialidad);
            }
        })->paginate(DataType::PAGINATE);
        return view('bolsaEmpleo.vacantesDisponibles')->with('vacantes_disponibles', $vacantes_disponibles);
    }

}
