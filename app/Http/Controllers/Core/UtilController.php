<?php

namespace App\Http\Controllers\Core;

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
        $handle = fopen('/home/jorgemalla/Documentos/SGBE/catalogos.csv', "r");
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
        $user    = User::where('name', 'admin')->first();
        $usuario = null;
        $grupo   = GrupoUsuario::where('nombre', 'Administrador')->first();
        if ($user) {
            $usuario = Usuario::where('id', $user->id)->first();
        }

        if (!$usuario) {
            Usuario::create(['name' => 'admin', 'email' => 'administrador@gmail.com', 'password' => bcrypt('admin'), 'super_user' => true]);
        } else {
            $user->email    = 'administrador@gmail.com';
            $user->password = bcrypt('admin');
            $user->save();
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
}
