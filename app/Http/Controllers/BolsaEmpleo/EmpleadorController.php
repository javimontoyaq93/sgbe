<?php

namespace App\Http\Controllers\BolsaEmpleo;

use App\BolsaEmpleo\DireccionEmpleador;
use App\BolsaEmpleo\Empleador;
use App\Core\Catalogo;
use App\Core\CatalogoItem;
use App\Http\Controllers\Controller;
use App\Seguridad\GrupoUsuario;
use App\Seguridad\Usuario;
use App\Seguridad\UsuarioEmpleador;
use App\User;
use App\Util\DataType;
use App\Util\ValidacionCampos;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Session;

class EmpleadorController extends Controller
{
    public function __construct()
    {

    }

    /**
     *
     * Permite mostrar los empleadores creados
     *
     */

    public function index()
    {
        $usuario          = Session::get(Auth::user()->name);
        $validar_permisos = Usuario::validarPermisos($usuario->id);
        if (!$validar_permisos) {
            return redirect('home')->with('usuario', $usuario);
        }
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

        $catalogo_tipo_documento  = Catalogo::where('nombre', DataType::TIPO_DOCUMENTO)->first();
        $catalogo_tipo_personeria = Catalogo::where('nombre', DataType::TIPO_PERSONERIA)->first();
        $catalogo_actividad       = Catalogo::where('nombre', DataType::TIPO_ACTIVIDAD_ECONOMICA)->first();
        if (!$catalogo_tipo_personeria || !$catalogo_tipo_documento || !$catalogo_actividad) {
            return redirect()->back();
        }

        $actividades_economicas = CatalogoItem::where('catalogo_id', $catalogo_actividad->id)->get();
        $tipos_documentos       = CatalogoItem::where('catalogo_id', $catalogo_tipo_documento->id)->get();
        $tipos_personeria       = CatalogoItem::where('catalogo_id', $catalogo_tipo_personeria->id)->get();
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
        DB::beginTransaction();
        try {
            if (!$this->validarNumeroIdentificacion($request->numero_identificacion, $request->tipo_identificacion)) {
                Session::flash('error_message', 'Cédula Incorrecta');
                return redirect()->back();
            }
            $usuario_session = null;
            if (Auth::user()) {
                $usuario_session = Session::get(Auth::user()->name);
            }
            $id            = null;
            $rules         = Empleador::$rules;
            $rules_usuario = Usuario::$rules;
            $datos         = ['email' => $request->email, 'razon_social' => $request->razon_social, 'celular' => $request->celular, 'numero_identificacion' => $request->numero_identificacion, 'tipo_personeria' => $request->tipo_personeria, 'tipo_identificacion' => $request->tipo_identificacion, 'actividad_economica' => $request->actividad_economica];

            if (!$request->id) {
                $validator = Validator::make($datos, $rules);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator->errors());
                }
                $grupo = GrupoUsuario::where('nombre', DataType::EMPLEADOR)->first();
                $id    = Empleador::create($datos)->id;

                $user_id = User::create(['name' => $request->email, 'email' => $request->email, 'password' => bcrypt($request->numero_identificacion), 'api_token' => $token])->id;

                $validator_usuario = Validator::make(['numero_identificacion' => $request->numero_identificacion], $rules_usuario);
                if ($validator_usuario->fails()) {
                    return redirect()->back()->withErrors($validator_usuario->errors());
                }
                $usuario             = new Usuario();
                $usuario->super_user = false;
                $usuario->id         = $user_id;
                $usuario->save();
                $usuario->grupos()->attach($grupo->id);
                $usuario_empleador               = new UsuarioEmpleador();
                $usuario_empleador->id           = $usuario->id;
                $usuario_empleador->empleador_id = $id;
                $usuario_empleador->save();
                $this->enviarEmail($request->email, $token);
                Session::flash('flash_message', 'Empleador grabado exitosamente, se le ha enviado un correo a su email para que modifique su clave');
            } else {
                $rules['numero_identificacion'] = 'required|min:4|unique:bolsa_empleo_empleadores,numero_identificacion,' . $request->id;
                $rules['email']                 = 'required|min:4|unique:bolsa_empleo_empleadores,email,' . $request->id;
                $validator                      = Validator::make($datos, $rules);
                $validar_permisos               = Usuario::validarPermisos($usuario_session->id, DataType::EMPLEADOR);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator->errors());
                }
                if (!$validar_permisos) {
                    return redirect('home');
                }
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

                if (count($empleador->usuarios) == 0) {
                    $validator_usuario = Validator::make(['numero_identificacion' => $request->numero_identificacion], $rules_usuario);
                    if ($validator_usuario->fails()) {
                        return redirect()->back()->withErrors($validator_usuario->errors());
                    }
                    $grupo = GrupoUsuario::where('nombre', DataType::EMPLEADOR)->first();

                    $user_id           = User::create(['name' => $request->email, 'email' => $request->email, 'password' => bcrypt($request->numero_identificacion)])->id;
                    $rules_usuario     = Usuario::$rules;
                    $validator_usuario = Validator::make(['numero_identificacion' => $request->numero_identificacion], $rules);
                    if ($validator_usuario->fails()) {
                        return redirect()->back()->withErrors($validator_usuario->errors());
                    }
                    $usuario             = new Usuario();
                    $usuario->super_user = false;
                    $usuario->id         = $user_id;
                    $usuario->save();
                    $usuario->grupos()->attach($grupo->id);
                    $usuario_empleador               = new UsuarioEmpleador();
                    $usuario_empleador->id           = $usuario->id;
                    $usuario_empleador->empleador_id = $id;
                    $usuario_empleador->save();
                } else {
                    $user_update       = null;
                    $usuario_empleador = UsuarioEmpleador::where('empleador_id', $empleador->id)->first();
                    if ($usuario_empleador && $usuario_empleador->usuario && $usuario_empleador->usuario->user) {
                        $user_update = $usuario_empleador->usuario->user;
                    }
                    $rules_usuario['numero_identificacion'] = 'required|min:4|unique:seguridad_usuarios,numero_identificacion,' . $usuario_empleador->usuario->id;
                    $validator_usuario                      = Validator::make(['numero_identificacion' => $request->numero_identificacion], $rules_usuario);
                    if ($validator_usuario->fails()) {
                        return redirect()->back()->withErrors($validator_usuario->errors());
                    }
                    $user_update->name  = $request->email;
                    $user_update->email = $request->email;
                    Session::put($user_update->name, $user_update);
                    $user_update->save();
                }
                Session::flash('flash_message', 'Empleador grabado exitosamente');
            }
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
        DB::commit();

        if (Auth::user() == null) {
            Session::flash('flash_message', 'Empleador grabado exitosamente, se le ha enviado un correo a su email para que modifique su clave');
            return view('bolsaEmpleo.registroFinalizadoEmpleador');
        }
        return redirect('/empleador/' . $id);
    }

    /**
     *
     * Permite mmostrar un empleador.
     *
     */
    public function show($id)
    {
        $user         = Session::get(Auth::user()->name);
        $es_empleador = false;
        if ($user->usuario && $user->usuario->usuarioEmpleador && $id != $user->usuario->usuarioEmpleador->empleador_id) {
            $es_empleador = true;
        }
        $validar_permisos = Usuario::validarPermisos($user->id);
        if (!$validar_permisos && $es_empleador) {
            return redirect('home');
        }
        $catalogo_tipo_documento  = Catalogo::where('nombre', DataType::TIPO_DOCUMENTO)->first();
        $catalogo_tipo_personeria = Catalogo::where('nombre', DataType::TIPO_PERSONERIA)->first();
        $catalogo_actividad       = Catalogo::where('nombre', DataType::TIPO_ACTIVIDAD_ECONOMICA)->first();
        if (!$catalogo_tipo_personeria || !$catalogo_tipo_documento || !$catalogo_actividad) {
            return redirect()->back();
        }

        $actividades_economicas = CatalogoItem::where('catalogo_id', $catalogo_actividad->id)->get();
        $tipos_documentos       = CatalogoItem::where('catalogo_id', $catalogo_tipo_documento->id)->get();
        $tipos_personeria       = CatalogoItem::where('catalogo_id', $catalogo_tipo_personeria->id)->get();
        $empleador              = Empleador::find($id);
        $direcciones            = DireccionEmpleador::where('empleador_id', $empleador->id)->where('eliminado', false)->paginate(DataType::PAGINATE);
        return view('bolsaEmpleo.empleador')->with('empleador', $empleador)->with('actividades_economicas', $actividades_economicas)->with('tipos_personeria', $tipos_personeria)->with('tipos_documentos', $tipos_documentos)->with('direcciones', $direcciones);
    }
    /**
     *
     * Permite Borrar un empleador seleccionado
     *
     */

    public function borrar(Request $request)
    {
        $validar_permisos = Usuario::validarPermisos(Session::get(Auth::user()->name)->id);
        if (!$validar_permisos) {
            return redirect('home');
        }
        $empleador            = Empleador::find($request->id);
        $empleador->eliminado = true;
        $empleador->save();
        return redirect()->back();
    }
    public function validarNumeroIdentificacion($cedula, $tipo_identificacion)
    {
        $cedula_item = CatalogoItem::find($tipo_identificacion);
        if ($cedula_item->nombre == DataType::CEDULA) {
            $validacion     = new ValidacionCampos();
            $validar_cedula = $validacion->validarCedula($cedula);
            if ($validar_cedula) {
                return true;
            } else {
                return false;
            }
        }
        return true;
    }
    public function enviarEmail($email, $token)
    {
        $data = array('from' => DataType::MAIL_USERNAME, 'name' => DataType::MAIL_NAME, 'to' => $email, 'content' => "" . DataType::SERVER . "/" . DataType::RUTA_CAMBIAR_CLAVE . "/" . $token . "");
        \Mail::send([], $data, function ($message) use ($data) {
            $message->to($data['to'], 'Bolsa de Empleo-Instituto Juan Montalvo')->subject
            (' Ruta para Cambiar Clave')->setBody('Bienvenido al Sistema de Gestión de Bolsa de Empleo del Instituto Juan Montalvo; su usuario es: ' . $data['to'] . ', ' . 'ingrese al siguiente link para el cambio de clave: ' . $data['content']);;
            $message->from($data['to'], $data['name']);
        });
    }
}
