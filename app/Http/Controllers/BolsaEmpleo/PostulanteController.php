<?php

namespace App\Http\Controllers\BolsaEmpleo;

use App\BolsaEmpleo\DireccionPostulante;
use App\BolsaEmpleo\Postulante;
use App\Core\Catalogo;
use App\Core\CatalogoItem;
use App\Http\Controllers\Controller;
use App\Seguridad\GrupoUsuario;
use App\Seguridad\Usuario;
use App\Seguridad\UsuarioPostulante;
use App\User;
use App\Util\DataType;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Session;

class PostulanteController extends Controller
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
        $postulantes = Postulante::where('eliminado', false)->paginate(DataType::PAGINATE);
        return view('bolsaEmpleo.postulantes')->with('postulantes', $postulantes);
    }

    /**
     *
     * Permite crear un nuevo postulante.
     *
     */

    public function crear()
    {
        $usuario          = Session::get(Auth::user()->name);
        $validar_permisos = Usuario::validarPermisos($usuario->id, DataType::POSTULANTE);
        if (!$validar_permisos) {
            return redirect('home');
        }
        $catalogo_tipo_documento = Catalogo::where('nombre', DataType::TIPO_DOCUMENTO)->first();
        $catalogo_tipo_sexo      = Catalogo::where('nombre', DataType::TIPO_SEXO)->first();
        $catalogo_estado_civil   = Catalogo::where('nombre', DataType::ESTADO_CIVIL)->first();
        if (!$catalogo_estado_civil || !$catalogo_tipo_documento || !$catalogo_tipo_sexo) {
            return redirect()->back();
        }

        $tipos_sexo       = CatalogoItem::where('catalogo_id', $catalogo_tipo_sexo->id)->get();
        $tipos_documentos = CatalogoItem::where('catalogo_id', $catalogo_tipo_documento->id)->get();
        $estados_civiles  = CatalogoItem::where('catalogo_id', $catalogo_estado_civil->id)->get();
        $direcciones      = array();
        $postulante       = new Postulante();
        return view('bolsaEmpleo.postulante')->with('tipos_sexo', $tipos_sexo)->with('estados_civiles', $estados_civiles)->with('tipos_documentos', $tipos_documentos)->with('postulante', $postulante)->with('direcciones', $direcciones);
    }

    /**
     *
     * Permite guardar un postulante.
     *
     */

    public function guardar(Request $request)
    {
        $usuario          = Session::get(Auth::user()->name);
        $validar_permisos = Usuario::validarPermisos($usuario->id, DataType::POSTULANTE);
        if (!$validar_permisos) {
            return redirect('home');
        }
        $id        = null;
        $datos     = ['email' => $request->email, 'nombres' => $request->nombres, 'celular' => $request->celular, 'numero_identificacion' => $request->numero_identificacion, 'apellidos' => $request->apellidos, 'tipo_identificacion' => $request->tipo_identificacion, 'estado_civil' => $request->estado_civil, 'genero' => $request->genero, 'fecha_nacimiento' => $request->fecha_nacimiento];
        $validator = Validator::make($datos, Postulante::$rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        $user_existe = User::where('email', $request->email)->first();
        if (!$request->id) {
            if ($user_existe) {
                Session::flash('error_message', 'Ya existe un usuario con el email: ' . $request->email);
                return redirect()->back();
            }
            $grupo   = GrupoUsuario::where('nombre', DataType::POSTULANTE)->first();
            $id      = Postulante::create($datos)->id;
            $user_id = User::create(['name' => $request->email, 'email' => $request->email, 'password' => bcrypt($request->numero_identificacion)])->id;

            $usuario             = new Usuario();
            $usuario->super_user = false;
            $usuario->id         = $user_id;
            $usuario->save();
            $usuario->grupos()->attach($grupo->id);
            $usuario_postulante                = new UsuarioPostulante();
            $usuario_postulante->id            = $usuario->id;
            $usuario_postulante->postulante_id = $id;
            $usuario_postulante->save();

        } else {
            $postulante = Postulante::find($request->id);
            if ($user_existe && $user_existe->usuario && $user_existe->usuario && $user_existe->usuario->usuarioPostulante->postulante_id != $postulante->id) {
                Session::flash('error_message', 'Ya existe un usuario con el email: ' . $request->email);
                return redirect()->back();
            }
            $postulante->nombres               = $request->nombres;
            $postulante->apellidos             = $request->apellidos;
            $postulante->email                 = $request->email;
            $postulante->numero_identificacion = $request->numero_identificacion;
            $postulante->tipo_identificacion   = $request->tipo_identificacion;
            $postulante->estado_civil          = $request->estado_civil;
            $postulante->genero                = $request->genero;
            $postulante->celular               = $request->celular;
            $postulante->fecha_nacimiento      = $request->fecha_nacimiento;
            $postulante->save();
            Session::flash('flash_message', 'Postulante grabado exitosamente, su usuario es su email y clave es su numero de dentificacion');
            $id = $postulante->id;
            if (count($postulante->usuarios) == 0) {
                $grupo = GrupoUsuario::where('nombre', DataType::POSTULANTE)->first();

                $user_id             = User::create(['name' => $request->email, 'email' => $request->email, 'password' => bcrypt($request->numero_identificacion)])->id;
                $usuario             = new Usuario();
                $usuario->super_user = false;
                $usuario->id         = $user_id;
                $usuario->save();
                $usuario->grupos()->attach($grupo->id);
                $usuario_postulante                = new UsuarioPostulante();
                $usuario_postulante->id            = $usuario->id;
                $usuario_postulante->postulante_id = $id;
                $usuario_postulante->save();
            } elseif ($user_existe) {
                $user_existe->email = $request->email;
                $user_existe->name  = $request->email;
                Session::put($user_existe->name, $user_existe);
                $user_existe->save();
            }
            Session::flash('flash_message', 'Postulante grabado exitosamente');
        }

        return redirect('/postulante/' . $id);
    }

    /**
     *
     * Permite mmostrar un empleador.
     *
     */
    public function show($id)
    {
        $user          = Session::get(Auth::user()->name);
        $es_postulante = false;
        if ($user->usuario && $user->usuario->usuarioPostulante && $id != $user->usuario->usuarioPostulante->postulante_id) {
            $es_postulante = true;
        }
        $validar_permisos = Usuario::validarPermisos($user->id);
        if (!$validar_permisos && $es_postulante) {
            return redirect('home');
        }
        $catalogo_tipo_documento = Catalogo::where('nombre', DataType::TIPO_DOCUMENTO)->first();
        $catalogo_tipo_sexo      = Catalogo::where('nombre', DataType::TIPO_SEXO)->first();
        $catalogo_estado_civil   = Catalogo::where('nombre', DataType::ESTADO_CIVIL)->first();
        if (!$catalogo_estado_civil || !$catalogo_tipo_documento || !$catalogo_tipo_sexo) {
            return redirect()->back();
        }

        $tipos_sexo       = CatalogoItem::where('catalogo_id', $catalogo_tipo_sexo->id)->get();
        $tipos_documentos = CatalogoItem::where('catalogo_id', $catalogo_tipo_documento->id)->get();
        $estados_civiles  = CatalogoItem::where('catalogo_id', $catalogo_estado_civil->id)->get();
        $postulante       = Postulante::find($id);
        $direcciones      = DireccionPostulante::where('postulante_id', $postulante->id)->where('eliminado', false)->paginate(DataType::PAGINATE);
        return view('bolsaEmpleo.postulante')->with('postulante', $postulante)->with('estados_civiles', $estados_civiles)->with('tipos_sexo', $tipos_sexo)->with('tipos_documentos', $tipos_documentos)->with('direcciones', $direcciones);
    }
    /**
     *
     * Permite Borrar un empleador seleccionado
     *
     */

    public function borrar(Request $request)
    {
        $usuario          = Session::get(Auth::user()->name);
        $validar_permisos = Usuario::validarPermisos($usuario->id, DataType::POSTULANTE);
        if (!$validar_permisos) {
            return redirect('home');
        }
        $postulante            = Postulante::find($request->id);
        $postulante->eliminado = true;
        $postulante_id->save();
        return redirect()->back();
    }
}
