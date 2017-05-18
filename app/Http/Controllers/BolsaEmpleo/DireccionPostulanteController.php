<?php

namespace App\Http\Controllers\BolsaEmpleo;

use App\BolsaEmpleo\DireccionPostulante;
use App\BolsaEmpleo\Postulante;
use App\Core\Catalogo;
use App\Core\CatalogoItem;
use App\Core\Direccion;
use App\Http\Controllers\Controller;
use App\Seguridad\Usuario;
use App\User;
use App\Util\DataType;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Session;

class DireccionPostulanteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     *
     * Permite crear la dirección de un postulante
     *
     */

    public function crear($postulante_id)
    {
        $usuario          = Session::get(Auth::user()->name);
        $validar_permisos = Usuario::validarPermisos($usuario->id, DataType::POSTULANTE);
        if (!$validar_permisos) {
            return redirect('home');
        }
        $direccion               = new DireccionPostulante();
        $direccion->direccion    = new Direccion();
        $catalogo_tipo_documento = Catalogo::where('nombre', DataType::TIPO_DIRECCION)->first();
        $catalogo_paises         = Catalogo::where('nombre', DataType::PAIS)->first();
        if (!$catalogo_tipo_documento && $catalogo_paises) {
            return redirect('/postulante/' . $postulante_id);
        }
        $tipos_direcciones = CatalogoItem::where('catalogo_id', $catalogo_tipo_documento->id)->get();
        $paises            = CatalogoItem::where('catalogo_id', $catalogo_paises->id)->orderBy('descripcion', 'asc')->get();
        $provincias        = array();
        $ciudades          = array();
        return view('bolsaEmpleo.direccionPostulante')->with('postulante_id', $postulante_id)->with('direccion', $direccion)->with('tipos_direcciones', $tipos_direcciones)->with('paises', $paises)->with('provincias', $provincias)->with('ciudades', $ciudades);
    }

    /**
     *
     * Permite guardar la dirección de un postulante.
     *
     */

    public function guardar(Request $request)
    {
        DB::beginTransaction();
        try {
            $id        = null;
            $datos     = ['calles' => $request->calles, 'referencia' => $request->referencia, 'tipo_direccion' => $request->tipo_direccion, 'pais' => $request->pais, 'provincia' => $request->provincia, 'ciudad' => $request->ciudad, 'telefono' => $request->telefono];
            $validator = Validator::make($datos, Direccion::$rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors());
            }
            if (!$request->id) {
                $direccion_id                        = Direccion::create($datos)->id;
                $direccion_postulante                = new DireccionPostulante();
                $direccion_postulante->postulante_id = $request->postulante_id;
                $direccion_postulante->id            = $direccion_id;
                $direccion_postulante->save();
                $id = $direccion_postulante->id;
            } else {
                $direccion                            = DireccionPostulante::find($request->id);
                $direccion->direccion->calles         = $request->calles;
                $direccion->direccion->referencia     = $request->referencia;
                $direccion->direccion->tipo_direccion = $request->tipo_direccion;
                $direccion->direccion->pais           = $request->pais;
                $direccion->direccion->provincia      = $request->provincia;
                $direccion->direccion->ciudad         = $request->ciudad;
                $direccion->direccion->telefono       = $request->telefono;
                $direccion->direccion->save();
                $id = $direccion->id;
            }
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
        DB::commit();
        Session::flash('flash_message', 'Direccion grabada exitosamente');
        return redirect('/direccion-postulante/' . $id);
    }
    /**
     *
     * Permite mostrar la dirección de un Postulante.
     *
     */

    public function show($id)
    {
        $catalogo_tipo_documento = Catalogo::where('nombre', DataType::TIPO_DIRECCION)->first();
        $catalogo_paises         = Catalogo::where('nombre', DataType::PAIS)->first();
        if (!$catalogo_tipo_documento && $catalogo_paises) {
            return redirect('/empleador/' . $empleador_id);
        }
        $tipos_direcciones = CatalogoItem::where('catalogo_id', $catalogo_tipo_documento->id)->get();
        $paises            = CatalogoItem::where('catalogo_id', $catalogo_paises->id)->orderBy('descripcion', 'asc')->get();
        $provincias        = array();
        $ciudades          = array();
        $direccion         = DireccionPostulante::find($id);
        if ($direccion->direccion->pais) {
            $provincias = CatalogoItem::where('padre_id', $direccion->direccion->pais)->orderBy('descripcion', 'asc')->get();
        }
        if ($direccion->direccion->provincia) {
            $ciudades = CatalogoItem::where('padre_id', $direccion->direccion->provincia)->orderBy('descripcion', 'asc')->get();
        }
        return view('bolsaEmpleo.direccionPostulante')->with('postulante_id', $direccion->postulante_id)->with('direccion', $direccion)->with('tipos_direcciones', $tipos_direcciones)->with('paises', $paises)->with('provincias', $provincias)->with('ciudades', $ciudades);
    }
}
