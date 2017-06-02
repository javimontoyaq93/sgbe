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
use App\Util\ValidacionCampos;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $catalogo_especialidad   = Catalogo::where('nombre', DataType::ESPECIALIDAD)->first();
        if (!$catalogo_estado_civil || !$catalogo_tipo_documento || !$catalogo_tipo_sexo) {
            return redirect()->back();
        }

        $tipos_sexo       = CatalogoItem::where('catalogo_id', $catalogo_tipo_sexo->id)->get();
        $tipos_documentos = CatalogoItem::where('catalogo_id', $catalogo_tipo_documento->id)->get();
        $estados_civiles  = CatalogoItem::where('catalogo_id', $catalogo_estado_civil->id)->get();
        $especialidades   = CatalogoItem::where('catalogo_id', $catalogo_especialidad->id)->get();
        $direcciones      = array();
        $postulante       = new Postulante();
        return view('bolsaEmpleo.postulante')->with('tipos_sexo', $tipos_sexo)->with('estados_civiles', $estados_civiles)->with('tipos_documentos', $tipos_documentos)->with('postulante', $postulante)->with('direcciones', $direcciones)->with('especialidades', $especialidades);
    }

    /**
     *
     * Permite guardar un postulante.
     *
     */

    public function guardar(Request $request)
    {
        DB::beginTransaction();
        try {
            $usuario          = Session::get(Auth::user()->name);
            $validar_permisos = Usuario::validarPermisos($usuario->id, DataType::POSTULANTE);
            if (!$validar_permisos) {
                return redirect('home');
            }
            if (!$this->validarNumeroIdentificacion($request->numero_identificacion, $request->tipo_identificacion)) {
                Session::flash('error_message', 'Cédula Incorrecta');
                return redirect()->back();
            }
            $id = null;

            $rules         = Postulante::$rules;
            $rules_usuario = Usuario::$rules;
            $datos         = ['email' => $request->email, 'nombres' => $request->nombres, 'celular' => $request->celular, 'numero_identificacion' => $request->numero_identificacion, 'apellidos' => $request->apellidos, 'tipo_identificacion' => $request->tipo_identificacion, 'estado_civil' => $request->estado_civil, 'genero' => $request->genero, 'fecha_nacimiento' => $request->fecha_nacimiento, 'especialidad' => $request->especialidad];
            if (!$request->id) {
                $validator = Validator::make($datos, $rules);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator->errors());
                }
                $grupo             = GrupoUsuario::where('nombre', DataType::POSTULANTE)->first();
                $id                = Postulante::create($datos)->id;
                $validator_usuario = Validator::make(['numero_identificacion' => $request->numero_identificacion], $rules_usuario);
                if ($validator_usuario->fails()) {
                    return redirect()->back()->withErrors($validator_usuario->errors());
                }
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
                $this->enviarEmail($request->email, $token);
            } else {
                $rules['numero_identificacion'] = 'required|min:4|unique:bolsa_empleo_postulantes,numero_identificacion,' . $request->id;
                $rules['email']                 = 'required|email|unique:bolsa_empleo_postulantes,email,' . $request->id;
                $validator                      = Validator::make($datos, $rules);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator->errors());
                }

                $postulante                        = Postulante::find($request->id);
                $postulante->nombres               = $request->nombres;
                $postulante->apellidos             = $request->apellidos;
                $postulante->email                 = $request->email;
                $postulante->numero_identificacion = $request->numero_identificacion;
                $postulante->tipo_identificacion   = $request->tipo_identificacion;
                $postulante->estado_civil          = $request->estado_civil;
                $postulante->genero                = $request->genero;
                $postulante->celular               = $request->celular;
                $postulante->fecha_nacimiento      = $request->fecha_nacimiento;
                $postulante->especialidad          = $request->especialidad;
                $postulante->save();
                $id = $postulante->id;
                if (count($postulante->usuarios) == 0) {
                    $grupo             = GrupoUsuario::where('nombre', DataType::POSTULANTE)->first();
                    $validator_usuario = Validator::make(['numero_identificacion' => $request->numero_identificacion], $rules);
                    if ($validator_usuario->fails()) {
                        return redirect()->back()->withErrors($validator_usuario->errors());
                    }
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
                    Session::flash('flash_message', 'Postulante grabado exitosamente, su usuario es su email y clave es su numero de dentificacion');
                } else {
                    $user_update        = null;
                    $usuario_postulante = UsuarioPostulante::where('postulante_id', $postulante->id)->first();
                    if ($usuario_postulante && $usuario_postulante->usuario && $usuario_postulante->usuario->user) {
                        $user_update = $usuario_postulante->usuario->user;
                    }
                    $rules_usuario['numero_identificacion'] = 'required|min:4|unique:seguridad_usuarios,numero_identificacion,' . $usuario_postulante->usuario->id;
                    $validator_usuario                      = Validator::make(['numero_identificacion' => $request->numero_identificacion], $rules_usuario);
                    if ($validator_usuario->fails()) {
                        return redirect()->back()->withErrors($validator_usuario->errors());
                    }
                    $usuario_postulante->usuario->numero_identificacion = $request->numero_identificacion;
                    $usuario_postulante->usuario->save();
                    $user_update->name  = $request->email;
                    $user_update->email = $request->email;
                    $user_update->save();
                    if (Auth::user()->name != $request->email) {
                        Session::put($user_update->name, $user_update);
                    }
                }
                Session::flash('flash_message', 'Postulante grabado exitosamente');
            }

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
        DB::commit();
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
        $catalogo_especialidad   = Catalogo::where('nombre', DataType::ESPECIALIDAD)->first();
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
        $especialidades   = CatalogoItem::where('catalogo_id', $catalogo_especialidad->id)->get();
        return view('bolsaEmpleo.postulante')->with('postulante', $postulante)->with('estados_civiles', $estados_civiles)->with('tipos_sexo', $tipos_sexo)->with('tipos_documentos', $tipos_documentos)->with('direcciones', $direcciones)->with('especialidades', $especialidades);
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
        $postulante->save();
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
            }
        } elseif ($cedula_item->nombre == DataType::RUC) {
            if (strlen($cedula) == 13) {
                $validacion     = new ValidacionCampos();
                $validar_cedula = $validacion->validarCedula(substr($cedula, 0, -3));
                if ($validar_cedula) {
                    if (substr($cedula, 10) == '001') {
                        return true;
                    }
                }
            }
        } else {
            return true;
        }
        return false;
    }

}
