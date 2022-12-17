<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Jornada;
use App\Models\Seccione;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /*guest*/
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nombre' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'haceGuardias' => ['required', 'string', 'max:255'],
            'dni' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'contraseña' => ['required', 'string', 'max:255'],
            'is_admin' => ['required', 'string', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'nombre' => strtoupper($data['nombre']),
            'apellidos' => strtoupper($data['apellidos']),
            'haceGuardias' => $data['haceGuardias'],
            'fechadenacimiento' => $data['fechadenacimiento'],
            'vacaciones1' => $data['vacaciones1'],
            'vacaciones2' => $data['vacaciones2'],
            'vacaciones3' => $data['vacaciones3'],
            'vacaciones4' => $data['vacaciones4'],
            'vacaciones5' => $data['vacaciones5'],
            'vacaciones6' => $data['vacaciones6'],
            'vacaciones7' => $data['vacaciones7'],
            'vacaciones8' => $data['vacaciones8'],
            'vacaciones9' => $data['vacaciones9'],
            'vacaciones10' => $data['vacaciones10'],
            'dni' => strtoupper($data['dni']),
            'jornada' => strtoupper($data['jornada']),
            'seccion' => $data['seccion'],
            'is_admin' => $data['is_admin'],
            'password' => Hash::make($data['password']),
            'contraseña' => Hash::make(($data['contraseña']))
        ]);
    }/*
    public function showRegistrationForm()
    {
        return view('auth.register', compact());
    }*/
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        return $this->registered($request, $user)
            // ?: redirect($this->redirectPath());
            ?: redirect()->route('users.index');
    }
}
