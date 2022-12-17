<?php

namespace App\Models;

use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 *
 * @property $id
 * @property $nombre
 * @property $apellidos
 * @property $fechadenacimiento
 * @property $iniciovacaciones
 * @property $finalvacaciones
 * @property $dni
 * @property $seccion
 * @property $festivos
 * @property $password
 * @property $contraseña
 * @property $is_admin
 * @property $remember_token
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class User extends Authenticatable
{

    static $rules = [
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre','apellidos','fechadenacimiento','vacaciones1','vacaciones2','vacaciones3','vacaciones4','vacaciones5','vacaciones6','vacaciones7','vacaciones8','vacaciones9','vacaciones10','jornada','dni','seccion','password','contraseña','is_admin','haceGuardias','jornada'];
}
