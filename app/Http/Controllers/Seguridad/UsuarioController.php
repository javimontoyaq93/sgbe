<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use App\Seguridad\Usuario;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function validarPermisos($usuario_id)
    {
        $usuario = Usuario::find($usuario_id);
        if ($usuario->super_user) {
            return true;
        }
        return false;
    }
    public function index()
    {
        return view('auth.passwords.reset');
    }
    public function actualizarClave(Request $request)
    {
        $validator = Validator::make(['password' => $request->clave], User::$rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        $clave         = $request->clave;
        $confirmaClave = $request->confirmar_clave;
        if ($clave != $confirmaClave) {
            Session::flash('error_message', 'Claves no coinciden');
            return redirect()->back();
        }
        $usuario                 = Session::get(Auth::user()->name);
        $usuario->user->password = bcrypt($request->clave);
        $usuario->user->save();
        Session::flash('flash_message', 'Clave actualizada exitosamente');
        return redirect('/cambiar-clave');
    }
}
