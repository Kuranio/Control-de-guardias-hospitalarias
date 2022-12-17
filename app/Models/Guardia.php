<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class Guardia
 *
 * @property $id
 * @property $fecha
 * @property $dni
 * @property $donde
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Guardia extends Model
{

    static $rules = [
		'fecha' => 'required',
    ];

    protected $perPage = 2000;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['fecha','dni','donde', 'semestre'];



}
