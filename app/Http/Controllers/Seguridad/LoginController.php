<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use App\Seguridad\Usuario;
use Auth;
use Illuminate\Http\Request;
use Session;

class LoginController extends Controller
{

    public function index()
    {
        $error = array('mensaje' => '');
        return view('seguridad.login')->with('error', '');

    }

    public function autenticar(Request $request)
    {

        $email       = $request->email;
        $password    = $request->password;
        $remember_me = $request->has('remember_me') ? true : false;

        $credenciales = array('email' => $email, 'password' => $password);
        if (Auth::attempt($credenciales, $remember_me)) {
            $usuario = Usuario::where('id', Auth::user()->id)->first();
            Session::put(Auth::user()->name, $usuario);
            return view('home')->with('usuario', $usuario);
        }
        return view('seguridad.login')->with('error', 'Datos Incorrectos');

    }

    public function logout()
    {

        Auth::logout();
        Session::flush();
        return redirect('/')->with('error', '');

    }

}
