<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use App\Seguridad\Usuario;
use App\User;
use App\Util\DataType;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Session;

class UsuarioController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
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
    public function recuperarClave()
    {
        return view('seguridad.recuperarClave');
    }

    public function enviarCambioClave(Request $request)
    {
        try {
            DB::beginTransaction();
            $user = User::where('email', $request->email)->first();
            if (!$user) {
                Session::flash('error_message', 'El email no existe');
                return redirect()->back();
            }
            $token           = str_random(64);
            $user->api_token = $token;
            $user->save();
            $data = array('from' => DataType::MAIL_USERNAME, 'name' => DataType::MAIL_NAME, 'to' => $request->email, 'content' => "" . DataType::SERVER . "/" . DataType::RUTA_CAMBIAR_CLAVE . "/" . $token . "");
            \Mail::send([], $data, function ($message) use ($data) {
                $message->to($data['to'], 'Tutorials Point')->subject
                ('Ruta para Cambiar Clave')->setBody('Ruta para cambio de clave: ' . $data['content']);;
                $message->from($data['to'], $data['name']);
            });
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
        DB::commit();
        Session::flash('flash_message', 'Se le ha enviado al correo electrónico la ruta para que pueda cambiar la contreseña');
        return redirect()->back();
    }

    public function vistaCambiarClave($token)
    {
        $user = User::where('api_token', $token)->first();
        return view('seguridad.cambiarClave')->with('user', $user);
    }
    public function actualizarCambioClave(Request $request)
    {
        $rules_usuario = User::$rules;
        $clave         = $request->clave;
        $confirmaClave = $request->confirmar_clave;
        if ($clave != $confirmaClave) {
            Session::flash('error_message', 'Claves no coinciden');
            return redirect()->back();
        }
        $user                   = User::find($request->id);
        $rules_usuario['email'] = 'unique:users,email' . $user->id;
        $validator              = Validator::make(['password' => $request->clave], $rules_usuario);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        $user->password  = bcrypt($request->clave);
        $token           = str_random(64);
        $user->api_token = $token;
        $user->save();
        Session::flash('flash_message', 'Clave actualizada exitosamente');
        return redirect()->back();
    }
}
