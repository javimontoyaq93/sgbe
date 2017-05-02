<?php

namespace App\Http\Controllers\Core;

use App\Core\Catalogo;
use App\Core\CatalogoItem;
use App\Http\Controllers\Controller;
use App\Seguridad\GrupoUsuario;
use App\Seguridad\Menu;
use App\Seguridad\Usuario;
use App\User;

class UtilController extends Controller
{
    public function index()
    {
        return 'hola';
    }
    /**
     *
     * Esta función permite crear los grupos de usuario del sistema.
     *
     */

    public function crearGruposUsuario()
    {
        $handle = fopen('/home/jorgemalla/Documentos/SGBE/grupos.csv', "r");
        $header = true;

        while ($csvLine = fgetcsv($handle, 1000, ";")) {

            if ($header) {
                $header = false;
            } else {
                $grupo = GrupoUsuario::where('nombre', $csvLine[0])->first();
                if (!$grupo) {
                    GrupoUsuario::create(['nombre' => $csvLine[0], 'descripcion' => $csvLine[1]]);
                } else {
                    $grupo->descripcion = $csvLine[1];
                    $grupo->save();
                }
            }
        }

    }

    /**
     *
     * Esta función permite crear un superusuario para el sistema.
     *
     */

    public function crearSuperUsuario()
    {
        $user  = User::where('name', 'admin')->first();
        $grupo = GrupoUsuario::where('nombre', 'Administrador')->first();
        if (!$user) {
            $user           = new User();
            $user->name     = 'admin';
            $user->email    = 'administrador@gmail.com';
            $user->password = bcrypt('admin');
            $user->save();
            Usuario::create(
                ['user_id' => $user->id, 'super_user' => true]);
            $user->usuario->save();
        }

    }

    /**
     *
     * Esta función permite crear los menus del sistema.
     *
     */

    public function crearMenu()
    {
        $handle = fopen('/home/jorgemalla/Documentos/SGBE/menus.csv', "r");
        $header = true;

        while ($csvLine = fgetcsv($handle, 1000, ";")) {

            if ($header) {
                $header = false;
            } else {
                $menu = Menu::where('nombre', $csvLine[0])->first();
                if (!$menu) {
                    $padre    = Menu::where('nombre', $csvLine[3])->first();
                    $padre_id = null;
                    if ($padre) {
                        $padre_id = $padre->id;
                    }
                    Menu::create(['nombre' => $csvLine[0], 'descripcion' => $csvLine[1], 'formulario' => $csvLine[2], 'padre_id' => $padre_id, 'orden' => $csvLine[4]]);
                }
            }
        }

    }
    public function crearCatalogos()
    {
        $handle = fopen('/home/jorgemalla/Documentos/SGBE/catalogos.csv', "r");
        $header = true;

        while ($csvLine = fgetcsv($handle, 1000, ";")) {

            if ($header) {
                $header = false;
            } else {
                $catalogo = Catalogo::where('nombre', $csvLine[0])->first();
                if (!$catalogo) {

                    Catalogo::create(['nombre' => $csvLine[0], 'descripcion' => $csvLine[1]]);
                }
            }
        }
    }
    public function crearCatalogosItems()
    {
        $handle = fopen('/home/jorgemalla/Documentos/SGBE/catalogos_items.csv', "r");
        $header = true;

        while ($csvLine = fgetcsv($handle, 1000, ";")) {
            echo $csvLine[2];
            if ($header) {
                $header = false;
            } else {

                $catalogo = Catalogo::where('nombre', $csvLine[2])->first();
                if ($catalogo) {
                    $catalogoItem = CatalogoItem::where(['nombre' => $csvLine[0], 'catalogo_id' => $catalogo->id])->first();
                    if (!$catalogoItem) {
                        CatalogoItem::create(['nombre' => $csvLine[0], 'descripcion' => $csvLine[1], 'catalogo_id' => $catalogo->id]);
                    }

                }

            }
        }

    }
}
