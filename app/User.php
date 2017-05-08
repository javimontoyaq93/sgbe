<?php

namespace App;

use App\Seguridad\Usuario;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function usuario()
    {
        return $this->hasOne('App\Seguridad\Usuario', 'id');
    }
    public static $rules = array(
        'password' => 'required|min:10',
    );
}
