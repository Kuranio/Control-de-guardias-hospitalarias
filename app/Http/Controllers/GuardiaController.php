<?php

namespace App\Http\Controllers;

use App\Models\Festivo;
use App\Models\Guardia;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use PDF;

/**
 * Class GuardiaController
 * @package App\Http\Controllers
 */
class GuardiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return string
     */

    public function pdf()
    {
        $guardias = Guardia::paginate();
        $pdf = PDF::loadView('guardia.pdf', ['guardias' => $guardias]);
        return $pdf->stream();
        //return view('guardia.pdf', compact('guardias'));
    }

    public function UserPDF()
    {
        $guardias = Guardia::paginate();
        $pdf = PDF::loadView('guardia.UserPDF', ['guardias' => $guardias]);
        return $pdf->stream();
        //return view('guardia.pdf', compact('guardias'));
    }


    public function index(Request $request)
    {

        $guardias = Guardia::where([
            ['id', '!=', null],
            [function ($query) use ($request) {
                if (($term = $request->term)) {
                    $query->Where('fecha', 'LIKE', '%' . $term . '%')->get();
                }
                if (($term1 = $request->term1)) {
                    $query->Where('dni', 'LIKE', $term1)->get();
                    $query->orWhere('donde', 'LIKE', $term1)->get();
                }
            }]
        ])
            ->orderBy('id', 'asc')
            ->paginate(5000);

        Paginator::useBootstrap();

        return view('guardia.index', compact('guardias'))
            ->with('i', (request()->input('page', 1) - 1) * $guardias->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $guardia = new Guardia();
        return view('guardia.create', compact('guardia'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Guardia::$rules);

        $guardia = Guardia::create($request->all());

        return redirect()->route('guardias.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $guardia = Guardia::find($id);

        return view('guardia.show', compact('guardia'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $guardia = Guardia::find($id);

        return view('guardia.edit', compact('guardia'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Guardia $guardia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Guardia $guardia)
    {
        request()->validate(Guardia::$rules);

        $guardia->update($request->all());

        return redirect()->route('guardias.index');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $guardia = Guardia::find($id)->delete();

        return redirect()->route('guardias.index');
    }

    public function truncate()
    {
        Guardia::truncate();

        return redirect()->route('guardias.index');
    }

    public function generateGuardia(Request $request, $semestre) {
        Guardia::where('semestre', $semestre)->delete();
        switch ($semestre) {
            case 1:
                $primerDia = Carbon::parse(date('Y') . '-02-01');
                $ultimoDia = Carbon::parse(date('Y') . '-06-30');
                if (Carbon::now()->month > 6) {
                    $primerDia->addYear();
                    $ultimoDia->addYear();
                }
                break;
            case 2:
                $primerDia = Carbon::parse(date('Y') . '-07-01');
                $ultimoDia = Carbon::parse(date('Y') . '-12-15');
                break;
            default:
                abort(500);
        }

//         se añade 1 por que hay un fallo al calcular diferencias
        $totalGuardias = $primerDia->diffInDays($ultimoDia) + 1;

        $users = $this->getUsersTotalGuardias($primerDia, $ultimoDia);
        $festivos = Festivo::all();
        for ($i = 0; $i < $totalGuardias; $i++) {
            $date = $primerDia->copy()->addDays($i);
            $guardiasArray = [ 'MATERNO', 'INSULAR', 'REFUERZO' ];


            if( $this->checkFestivos($festivos, $date) ){
                foreach( $guardiasArray as $guardiaType) {
                    Guardia::create([
                            'fecha' => $date->toDateString(),
                            'donde' => $guardiaType,
                            'dni' => 'FESTIVO',
                            'semestre' => $semestre
                        ]
                    );
                }
                continue;
            }


            foreach( $guardiasArray as $guardiaType) {
                $user = $this->getValidUser($users, $date, $guardiaType);

                if(!$user){
                    $users = $this->getUsersTotalGuardias($date, $ultimoDia);
                    $user = $this->getValidUser($users, $date, $guardiaType);
                }

                Guardia::create([
                        'fecha' => $date->toDateString(),
                        'dni' => $user->dni,
                        'donde' => $guardiaType,
                        'semestre' => $semestre
                    ]
                );
                $positionUser = $users->search(function ($userSearched) use($user) {
                    return $userSearched->id === $user->id;
                });
                $user['totalGuardias'] -= 1;
                $users[$positionUser] = $user;

            }
        }
        return redirect(route('guardias.index'));
    }

    private function getValidUser($users, $date, $guardiaType) {
        $validUsers = $users->filter( function( $user ) use( $date, $guardiaType ) {

//          dias que le queden
            if( !$user->totalGuardias ){
                return false;
            }
//          -----------------------------------------

//          mirar VACACIONES
            $holidaysRange = $this->getHolidaysRange($user);
            foreach( $holidaysRange as $holidayRange )  {
                $hasHolidays = $date->between($holidayRange[0], $holidayRange[1]);
                if ( $hasHolidays ) {
                    return false;
                }
            }
//          -----------------------------------------


//          Cumple 55 o mas
            $edad = $this->calculaEdad($user->fechadenacimiento, $date);
            $validEdad = $edad < 55;
            if( ! $validEdad ) {
                return false;
            }
//          -----------------------------------------


//          guardias anteriores 24
            $lastDay = $date->copy()->subDay();
            if( $guardiaType === 'MATERNO' || $guardiaType === 'INSULAR' ) {
                $lastGuardia = Guardia::where( 'fecha', $lastDay )->where( 'dni', $user->dni )->where( function( $q ) {
                    $q->where( 'donde', 'MATERNO' )->orWhere( 'donde', 'INSULAR' );
                })->get();
                $cantGuardiaType = !!$lastGuardia->count();
                if( $cantGuardiaType ) {
                    return false;
                }
            }
//          -----------------------------------------

//          fin de semana lunes no tiene
            if( $date->isMonday() ){
                $lastGuardiasWeekend = Guardia::where( function($q) use($lastDay) {
                    $q->where( 'fecha', $lastDay )->orWhere('fecha', $lastDay->copy()->subDay());
                } )->where( 'dni', $user->dni )->get();
                if( !!$lastGuardiasWeekend->count() ) {
                    return false;
                }
            }
//          -----------------------------------------


//          Guardias especialidad diferente mismo dia
            $dayGuardias = Guardia::where( 'fecha', $date )->get();
            foreach( $dayGuardias as $dayGuardia ) {
                $userGuardia = User::where( 'dni', $dayGuardia->dni)->get()->firstOrFail();
                if($userGuardia->seccion == $user->seccion) {
                    return false;
                }
            }

//          -----------------------------------------


            return true;
        })->values();

        if( ! $validUsers->count() ){
            return false;
        }


        return $validUsers->sortByDesc('totalGuardias')->first();
    }

    private function calculaEdad($fecha_nacimiento, $diaActual) {
        $hoy = Carbon::parse($diaActual);
        $annos = $hoy->diff($fecha_nacimiento);
        return ($annos->y);
    }

    private function getHolidaysRange($user) {
        $datesHolidays = collect();
        for( $i = 1 ; $i <= 10 ; $i++ ){
            if( ! $user['vacaciones'.$i] ) continue;
            $datesHolidays->push([
                Carbon::parse(substr($user['vacaciones'.$i], 0, 10)),
                Carbon::parse(substr($user['vacaciones'.$i], 13, 22))
            ]);
        }
        return $datesHolidays;
    }

    private function getUsersTotalGuardias($primerDia, $ultimoDia){
        $totalGuardias = $primerDia->diffInDays($ultimoDia) + 1;

        $users = User::where('haceGuardias', 1)->get()->filter(function ($user, $key) use ($primerDia) {
            return $this->calculaEdad($user->fechadenacimiento, $primerDia) < 55;
        })->values();

        $totalJornadas = $users->sum('jornada');

        $jornadaPorDia = $totalGuardias * 3 / $totalJornadas;

        $users = $users->map(function ($user) use ($jornadaPorDia) {
            $user['totalGuardias'] = (int)ceil($user->jornada * $jornadaPorDia);
            return $user;
        })->shuffle();

        return $users;
    }

    private function checkFestivos( $festivos, Carbon $fechaAComprobar ){
        $festivos = $festivos->pluck('fecha')->map( function( $fecha ) {
            if(strlen($fecha) === 10){
                return Carbon::parse(substr($fecha, 0, 10));
            }
            return [
                Carbon::parse(substr($fecha, 0, 10)),
                Carbon::parse(substr($fecha, 13, 22))
            ];
        });
        foreach( $festivos as $festivo ){
            if( gettype( $festivo ) === 'array' ) {
                if( $fechaAComprobar->between($festivo[0], $festivo[1]) ){
                    return true;
                }
                continue;
            }
            if( ! $fechaAComprobar->diffInDays($festivo)){
                return true;
            }
        }
        return false;
    }

}
