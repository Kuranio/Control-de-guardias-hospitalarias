<?php

namespace App\Http\Controllers;

use App\Models\Festivo;
use App\Models\Guardia;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class GuardiaController
 * @package App\Http\Controllers
 */



class GuardiaControllerSS extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return string
     */

    /*
     * CONDICIONES APLICADAS HASTA EL MOMENTO
     * - SI TIENE 55 AÑOS, HACE GUARDIAS HASTA EL DÍA ANTES DEL CUMPLEAÑOS
     * - SI ESTÁ DE VACACIONES NO HACE GUARDIAS
     * - HACE GUARDIAS EN FUNCIÓN DEL PORCENTAJE DE TRABAJO EFECTIVO APLICADO (JORNADA)
     * */

    public function calculaedad($fecha_nacimiento, $diaActual){
        $cumpleanos = new DateTime($fecha_nacimiento);
        $hoy = Carbon::parse($diaActual);
        $annos= $hoy->diff($cumpleanos);
        return ($annos->y);
    }

    public function fechadentrodeotra(DateTime $fechaActual, DateTime $fechaInicio, DateTime $fechaFinal){
        return ($fechaActual >= $fechaInicio and $fechaActual <= $fechaFinal);
    }
    public function guardias(){

        if(Carbon::now()->month < 7){
            $primerDia = Carbon::parse(date('Y') . '-07-01')->addYear();
            $ultimoDia = Carbon::parse(date('Y') . '-12-15')->addYear();
            $diferencia = $primerDia->diffInDays($ultimoDia);

        } else{
            $primerDia = Carbon::parse(date('Y') . '-07-01');
            $ultimoDia = Carbon::parse(date('Y') . '-12-15');
            $diferencia = $primerDia->diffInDays($ultimoDia);

        }

        //SE CREA UNA LISTA DE CANDIDATOS QUE SE IRÁ RELLENANDO EN FUNCIÓN DE LAS CONDICIONES

        //SE OBTIENEN TODOS LOS USUARIOS
        $usuarios = User::all();

        $festivos = array();

        $guardadas = Guardia::all();
        foreach($guardadas as $g) {
            if($g['semestre'] != 1){
                $id = $g['id'];
                DB::table('guardias')->delete($id);
            }
        }
        foreach (Festivo::all() as $cadaFestivo){
            if(strlen($cadaFestivo['fecha']) > 11){
                $inicioFestivo = Carbon::create(substr($cadaFestivo['fecha'],0,10));
                $finalFestivo = Carbon::create(substr($cadaFestivo['fecha'],13,22));
                $periodoFestivos = CarbonPeriod::create($inicioFestivo, $finalFestivo);
                foreach ($periodoFestivos as $cadaDiaPeriodo){
                    array_push($festivos, $cadaDiaPeriodo->toDateString());
                }
            }else{
                array_push($festivos, (Carbon::create($cadaFestivo['fecha'])->toDateString()));
            }
        }


        $totalMed = count($usuarios->where('haceGuardias', '=', 1));
        $maxGuardias= ceil(($diferencia * 3)/$totalMed);

        //SE CREA UNA LISTA DE CANDIDATOS QUE SE IRÁ RELLENANDO EN FUNCIÓN DE LAS CONDICIONES

        //SE CREA UN ARRAY DONDE SE METERÁN LOS CANDIDATOS APLICANDO EL PORCENTAJE DE TRABAJO EFECTIVO
        $candidatosEnFuncionDias= array();
        foreach ($usuarios as $candidato) {
            if($candidato->haceGuardias){
                $posibilidades = (intval($candidato->jornada,10) * intval($maxGuardias, 10))/100;
                for ($j = 0; $j < $posibilidades; $j++) {
                    array_push( $candidatosEnFuncionDias, $candidato);
                }
            }
        }



        shuffle($candidatosEnFuncionDias);
        shuffle($candidatosEnFuncionDias);
        shuffle($candidatosEnFuncionDias);
        shuffle($candidatosEnFuncionDias);
        shuffle($candidatosEnFuncionDias);
        shuffle($candidatosEnFuncionDias);
        shuffle($candidatosEnFuncionDias);
        shuffle($candidatosEnFuncionDias);

        if( Carbon::now()->month < 7 ){
            //SE RECORREN TODOS LOS DIAS DEL AÑO
            for ($i = 0; $i <= $diferencia; $i++) {
                if(in_array((Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()->toDateString()), $festivos)){
                    DB::table('guardias')->insert([
                        'fecha' => Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()->toDateString(),
                        'dni' => 'FESTIVO',
                        'donde' => 'MATERNO',
                        'semestre' => 2
                    ]);
                    DB::table('guardias')->insert([
                        'fecha' => Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()->toDateString(),
                        'dni' => 'FESTIVO',
                        'donde' => 'INSULAR',
                        'semestre' => 2
                    ]);
                    DB::table('guardias')->insert([
                        'fecha' => Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()->toDateString(),
                        'dni' => 'FESTIVO',
                        'donde' => 'REFUERZO',
                        'semestre' => 2
                    ]);
                }else {
                    $candidatos = array();
                    foreach ($usuarios as $usuario) {


                        if ($usuario->haceGuardias == 1) {
                            if (isset($usuario->vacaciones10)
                                and isset($usuario->vacaciones9)
                                and isset($usuario->vacaciones8)
                                and isset($usuario->vacaciones7)
                                and isset($usuario->vacaciones6)
                                and isset($usuario->vacaciones5)
                                and isset($usuario->vacaciones4)
                                and isset($usuario->vacaciones3)
                                and isset($usuario->vacaciones2)
                                and isset($usuario->vacaciones1)
                                and (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones1, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones1, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones2, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones2, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones3, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones3, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones4, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones4, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones5, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones5, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones6, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones6, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones7, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones7, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones8, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones8, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones9, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones9, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones10, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones10, 13, 22))))
                            ) {
                                array_push($candidatos, $usuario);
                            }


                            if (!isset($usuario->vacaciones10)
                                and isset($usuario->vacaciones9)
                                and isset($usuario->vacaciones8)
                                and isset($usuario->vacaciones7)
                                and isset($usuario->vacaciones6)
                                and isset($usuario->vacaciones5)
                                and isset($usuario->vacaciones4)
                                and isset($usuario->vacaciones3)
                                and isset($usuario->vacaciones2)
                                and isset($usuario->vacaciones1)
                                and //SE COMPRUEBA SI ESE DÍA ESTÁ DE VACACIONES
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones1, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones1, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones2, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones2, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones3, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones3, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones4, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones4, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones5, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones5, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones6, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones6, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones7, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones7, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones8, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones8, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones9, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones9, 13, 22))))
                            ) {
                                array_push($candidatos, $usuario);
                            }


                            if (!isset($usuario->vacaciones10)
                                and !isset($usuario->vacaciones9)
                                and isset($usuario->vacaciones8)
                                and isset($usuario->vacaciones7)
                                and isset($usuario->vacaciones6)
                                and isset($usuario->vacaciones5)
                                and isset($usuario->vacaciones4)
                                and isset($usuario->vacaciones3)
                                and isset($usuario->vacaciones2)
                                and isset($usuario->vacaciones1)
                                and //SE COMPRUEBA SI ESE DÍA ESTÁ DE VACACIONES
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones1, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones1, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones2, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones2, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones3, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones3, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones4, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones4, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones5, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones5, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones6, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones6, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones7, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones7, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones8, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones8, 13, 22))))
                            ) {
                                array_push($candidatos, $usuario);
                            }


                            if (!isset($usuario->vacaciones10)
                                and !isset($usuario->vacaciones9)
                                and !isset($usuario->vacaciones8)
                                and isset($usuario->vacaciones7)
                                and isset($usuario->vacaciones6)
                                and isset($usuario->vacaciones5)
                                and isset($usuario->vacaciones4)
                                and isset($usuario->vacaciones3)
                                and isset($usuario->vacaciones2)
                                and isset($usuario->vacaciones1)
                                and //SE COMPRUEBA SI ESE DÍA ESTÁ DE VACACIONES
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones1, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones1, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones2, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones2, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones3, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones3, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones4, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones4, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones5, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones5, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones6, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones6, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones7, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones7, 13, 22))))
                            ) {
                                array_push($candidatos, $usuario);
                            }


                            if (!isset($usuario->vacaciones10)
                                and !isset($usuario->vacaciones9)
                                and !isset($usuario->vacaciones8)
                                and !isset($usuario->vacaciones7)
                                and isset($usuario->vacaciones6)
                                and isset($usuario->vacaciones5)
                                and isset($usuario->vacaciones4)
                                and isset($usuario->vacaciones3)
                                and isset($usuario->vacaciones2)
                                and isset($usuario->vacaciones1)
                                and //SE COMPRUEBA SI ESE DÍA ESTÁ DE VACACIONES
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones1, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones1, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones2, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones2, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones3, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones3, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones4, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones4, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones5, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones5, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones6, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones6, 13, 22))))
                            ) {
                                array_push($candidatos, $usuario);
                            }


                            if (!isset($usuario->vacaciones10)
                                and !isset($usuario->vacaciones9)
                                and !isset($usuario->vacaciones8)
                                and !isset($usuario->vacaciones7)
                                and !isset($usuario->vacaciones6)
                                and isset($usuario->vacaciones5)
                                and isset($usuario->vacaciones4)
                                and isset($usuario->vacaciones3)
                                and isset($usuario->vacaciones2)
                                and isset($usuario->vacaciones1)
                                and (!fechadentrodeotra((Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones1, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones1, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones2, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones2, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones3, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones3, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones4, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones4, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones5, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones5, 13, 22))))
                            ) {
                                array_push($candidatos, $usuario);
                            }


                            if (!isset($usuario->vacaciones10)
                                and !isset($usuario->vacaciones9)
                                and !isset($usuario->vacaciones8)
                                and !isset($usuario->vacaciones7)
                                and !isset($usuario->vacaciones6)
                                and !isset($usuario->vacaciones5)
                                and isset($usuario->vacaciones4)
                                and isset($usuario->vacaciones3)
                                and isset($usuario->vacaciones2)
                                and isset($usuario->vacaciones1)
                                and //SE COMPRUEBA SI ESE DÍA ESTÁ DE VACACIONES
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones1, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones1, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones2, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones2, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones3, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones3, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones4, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones4, 13, 22))))
                            ) {
                                array_push($candidatos, $usuario);

                            }


                            if (!isset($usuario->vacaciones10)
                                and !isset($usuario->vacaciones9)
                                and !isset($usuario->vacaciones8)
                                and !isset($usuario->vacaciones7)
                                and !isset($usuario->vacaciones6)
                                and !isset($usuario->vacaciones5)
                                and !isset($usuario->vacaciones4)
                                and isset($usuario->vacaciones3)
                                and isset($usuario->vacaciones2)
                                and isset($usuario->vacaciones1)
                                and //SE COMPRUEBA SI ESE DÍA ESTÁ DE VACACIONES
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones1, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones1, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones2, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones2, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones3, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones3, 13, 22))))
                            ) {
                                array_push($candidatos, $usuario);
                            }


                            if (!isset($usuario->vacaciones10)
                                and !isset($usuario->vacaciones9)
                                and !isset($usuario->vacaciones8)
                                and !isset($usuario->vacaciones7)
                                and !isset($usuario->vacaciones6)
                                and !isset($usuario->vacaciones5)
                                and !isset($usuario->vacaciones4)
                                and !isset($usuario->vacaciones3)
                                and isset($usuario->vacaciones2)
                                and isset($usuario->vacaciones1)
                                and //SE COMPRUEBA SI ESE DÍA ESTÁ DE VACACIONES
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones1, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones1, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones2, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones2, 13, 22))))
                            ) {
                                array_push($candidatos, $usuario);
                            }

                            if (!isset($usuario->vacaciones10)
                                and !isset($usuario->vacaciones9)
                                and !isset($usuario->vacaciones8)
                                and !isset($usuario->vacaciones7)
                                and !isset($usuario->vacaciones6)
                                and !isset($usuario->vacaciones5)
                                and !isset($usuario->vacaciones4)
                                and !isset($usuario->vacaciones3)
                                and !isset($usuario->vacaciones2)
                                and isset($usuario->vacaciones1)
                                and (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()),
                                    Carbon::parse(substr($usuario->vacaciones1, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones1, 13, 22))))
                            ) {
                                array_push($candidatos, $usuario);
                            }

                            if (!isset($usuario->vacaciones10)
                                and !isset($usuario->vacaciones9)
                                and !isset($usuario->vacaciones8)
                                and !isset($usuario->vacaciones7)
                                and !isset($usuario->vacaciones6)
                                and !isset($usuario->vacaciones5)
                                and !isset($usuario->vacaciones4)
                                and !isset($usuario->vacaciones3)
                                and !isset($usuario->vacaciones2)
                                and !isset($usuario->vacaciones1)) {
                                array_push($candidatos, $usuario);
                            }
                        }
                    }
                    $candidatosEnFuncionJornadaEfectiva = array();
                    foreach($candidatosEnFuncionDias as $actual){
                        if(in_array( $actual, $candidatos)){
                            array_push($candidatosEnFuncionJornadaEfectiva,$actual);
                        }
                    }
                    if(count($candidatosEnFuncionDias)>3){;
                        $posMaterno = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                        $candidatoMaterno = $candidatosEnFuncionJornadaEfectiva[$posMaterno];



                        $posInsular = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                        $candidatoInsular = $candidatosEnFuncionJornadaEfectiva[$posInsular];



                        $posRefuerzo = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                        $candidatoRefuerzo = $candidatosEnFuncionJornadaEfectiva[$posRefuerzo];



                    }

                    if ((Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear())->dayOfWeek == Carbon::SUNDAY) {
                        if (
                            (isset($candidatoInsularAntes) and isset($candidatoMaternoAntes))
                            and
                            (isset($candidatoMaternoAntesSabados))
                        ) {
                            while (
                                //EL MISMO CANDIDATO NO PUEDE ESTAR REPETIDO
                                ($candidatoMaterno == $candidatoInsular)
                                or ($candidatoMaterno == $candidatoRefuerzo)
                                or ($candidatoInsular == $candidatoRefuerzo)
                                or ($candidatoInsular == $candidatoMaterno)
                                or ($candidatoRefuerzo == $candidatoInsular)
                                or ($candidatoRefuerzo == $candidatoMaterno)

                                //NO PUEDEN HABER DE LA MISMA SECCION UN DIA
                                or ($candidatoMaterno->seccion == $candidatoInsular->seccion)
                                or ($candidatoMaterno->seccion == $candidatoRefuerzo->seccion)
                                or ($candidatoMaterno->seccion == $candidatoRefuerzo->seccion)
                                or ($candidatoInsular->seccion == $candidatoRefuerzo->seccion)
                                or ($candidatoInsular->seccion == $candidatoMaterno->seccion)
                                or ($candidatoInsular->seccion == $candidatoMaterno->seccion)
                                or ($candidatoRefuerzo->seccion == $candidatoInsular->seccion)
                                or ($candidatoRefuerzo->seccion == $candidatoMaterno->seccion)
                                or ($candidatoRefuerzo->seccion == $candidatoMaterno->seccion)

                                //NO PUEDE HACER GUARDIAS DE 24H SEGUIDAS
                                or ($candidatoMaterno == $candidatoMaternoAntes)
                                or ($candidatoInsular == $candidatoInsularAntes)
                                or ($candidatoInsular == $candidatoMaternoAntes)
                                or ($candidatoMaterno == $candidatoInsularAntes)

                                //SABADOS
                                or ($candidatoMaterno == $candidatoMaternoAntesSabados)
                                or ($candidatoInsular == $candidatoMaternoAntesSabados)
                                or ($candidatoRefuerzo == $candidatoMaternoAntesSabados)


                                //SABADOS
                                or ($candidatoMaterno == $candidatoInsularAntesSabados)
                                or ($candidatoInsular == $candidatoInsularAntesSabados)
                                or ($candidatoRefuerzo == $candidatoInsularAntesSabados)


                                //SABADOS
                                or ($candidatoMaterno == $candidatoRefuerzoAntesSabados)
                                or ($candidatoInsular == $candidatoRefuerzoAntesSabados)
                                or ($candidatoRefuerzo == $candidatoRefuerzoAntesSabados)


                                //SE COMPRUEBA SI ESE DÍA TIENE 55 AÑOS
                                or (!calculaedad(($candidatoMaterno->fechadenacimiento), Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()) >= 55)
                                or (!calculaedad(($candidatoInsular->fechadenacimiento), Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()) >= 55)
                                or (!calculaedad(($candidatoRefuerzo->fechadenacimiento), Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()) >= 55)
                            ) {
                                if(count($candidatosEnFuncionDias)>3){
                                    $posMaterno = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                                    $candidatoMaterno = $candidatosEnFuncionJornadaEfectiva[$posMaterno];

                                    $posInsular = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                                    $candidatoInsular = $candidatosEnFuncionJornadaEfectiva[$posInsular];


                                    $posRefuerzo = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                                    $candidatoRefuerzo = $candidatosEnFuncionJornadaEfectiva[$posRefuerzo];

                                }
                            }
                        }

                        else {

                            while (
                                //EL MISMO CANDIDATO NO PUEDE ESTAR REPETIDO
                                ($candidatoMaterno == $candidatoInsular)
                                or ($candidatoMaterno == $candidatoRefuerzo)
                                or ($candidatoInsular == $candidatoRefuerzo)
                                or ($candidatoInsular == $candidatoMaterno)
                                or ($candidatoRefuerzo == $candidatoInsular)
                                or ($candidatoRefuerzo == $candidatoMaterno)

                                //NO PUEDEN HABER DE LA MISMA SECCION UN DIA
                                or ($candidatoMaterno->seccion == $candidatoInsular->seccion)
                                or ($candidatoMaterno->seccion == $candidatoRefuerzo->seccion)
                                or ($candidatoMaterno->seccion == $candidatoRefuerzo->seccion)
                                or ($candidatoInsular->seccion == $candidatoRefuerzo->seccion)
                                or ($candidatoInsular->seccion == $candidatoMaterno->seccion)
                                or ($candidatoInsular->seccion == $candidatoMaterno->seccion)
                                or ($candidatoRefuerzo->seccion == $candidatoInsular->seccion)
                                or ($candidatoRefuerzo->seccion == $candidatoMaterno->seccion)
                                or ($candidatoRefuerzo->seccion == $candidatoMaterno->seccion)


                                //SE COMPRUEBA SI ESE DÍA TIENE 55 AÑOS
                                or (!calculaedad(($candidatoMaterno->fechadenacimiento), Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()) >= 55)
                                or (!calculaedad(($candidatoInsular->fechadenacimiento), Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()) >= 55)
                                or (!calculaedad(($candidatoRefuerzo->fechadenacimiento), Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()) >= 55)

                            ) {
                                if(count($candidatosEnFuncionDias)>3){
                                    $posMaterno = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                                    $candidatoMaterno = $candidatosEnFuncionJornadaEfectiva[$posMaterno];



                                    $posInsular = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                                    $candidatoInsular = $candidatosEnFuncionJornadaEfectiva[$posInsular];



                                    $posRefuerzo = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                                    $candidatoRefuerzo = $candidatosEnFuncionJornadaEfectiva[$posRefuerzo];
                                    if ((Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear())->dayOfWeek == Carbon::SATURDAY) {
                                        $candidatoMaternoAntesSabados = $candidatoMaterno;
                                        $candidatoInsularAntesSabados = $candidatoInsular;
                                        $candidatoRefuerzoAntesSabados = $candidatoRefuerzo;

                                    }


                                }

                            }
                        }
                    }
                    else if (isset($candidatoInsularAntes) and isset($candidatoMaternoAntes)) {
                        while (
                            //EL MISMO CANDIDATO NO PUEDE ESTAR REPETIDO
                            ($candidatoMaterno == $candidatoInsular)
                            or ($candidatoMaterno == $candidatoRefuerzo)
                            or ($candidatoInsular == $candidatoRefuerzo)
                            or ($candidatoInsular == $candidatoMaterno)
                            or ($candidatoRefuerzo == $candidatoInsular)
                            or ($candidatoRefuerzo == $candidatoMaterno)

                            //NO PUEDEN HABER DE LA MISMA SECCION UN DIA
                            or ($candidatoMaterno->seccion == $candidatoInsular->seccion)
                            or ($candidatoMaterno->seccion == $candidatoRefuerzo->seccion)
                            or ($candidatoMaterno->seccion == $candidatoRefuerzo->seccion)
                            or ($candidatoInsular->seccion == $candidatoRefuerzo->seccion)
                            or ($candidatoInsular->seccion == $candidatoMaterno->seccion)
                            or ($candidatoInsular->seccion == $candidatoMaterno->seccion)
                            or ($candidatoRefuerzo->seccion == $candidatoInsular->seccion)
                            or ($candidatoRefuerzo->seccion == $candidatoMaterno->seccion)
                            or ($candidatoRefuerzo->seccion == $candidatoMaterno->seccion)

                            //NO PUEDE HACER GUARDIAS DE 24H SEGUIDAS
                            or ($candidatoMaterno == $candidatoMaternoAntes)
                            or ($candidatoInsular == $candidatoInsularAntes)
                            or ($candidatoInsular == $candidatoMaternoAntes)
                            or ($candidatoMaterno == $candidatoInsularAntes)

                            //SE COMPRUEBA SI ESE DÍA TIENE 55 AÑOS
                            or (!calculaedad(($candidatoMaterno->fechadenacimiento), Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()) >= 55)
                            or (!calculaedad(($candidatoInsular->fechadenacimiento), Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()) >= 55)
                            or (!calculaedad(($candidatoRefuerzo->fechadenacimiento), Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()) >= 55)
                        ) {
                            if(count($candidatosEnFuncionDias)>3){;
                                $posMaterno = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                                $candidatoMaterno = $candidatosEnFuncionJornadaEfectiva[$posMaterno];



                                $posInsular = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                                $candidatoInsular = $candidatosEnFuncionJornadaEfectiva[$posInsular];



                                $posRefuerzo = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                                $candidatoRefuerzo = $candidatosEnFuncionJornadaEfectiva[$posRefuerzo];
                                if ((Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear())->dayOfWeek == Carbon::SATURDAY) {
                                    $candidatoMaternoAntesSabados = $candidatoMaterno;
                                    $candidatoInsularAntesSabados = $candidatoInsular;
                                    $candidatoRefuerzoAntesSabados = $candidatoRefuerzo;

                                }


                            }
                        }
                    } else {

                        while (
                            //EL MISMO CANDIDATO NO PUEDE ESTAR REPETIDO
                            ($candidatoMaterno == $candidatoInsular)
                            or ($candidatoMaterno == $candidatoRefuerzo)
                            or ($candidatoInsular == $candidatoRefuerzo)
                            or ($candidatoInsular == $candidatoMaterno)
                            or ($candidatoRefuerzo == $candidatoInsular)
                            or ($candidatoRefuerzo == $candidatoMaterno)

                            //SE COMPRUEBA SI ESE DÍA TIENE 55 AÑOS
                            or (!calculaedad(($candidatoMaterno->fechadenacimiento), Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()) >= 55)
                            or (!calculaedad(($candidatoInsular->fechadenacimiento), Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()) >= 55)
                            or (!calculaedad(($candidatoRefuerzo->fechadenacimiento), Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()) >= 55)
                        ) {
                            if(count($candidatosEnFuncionDias)>3){;
                                $posMaterno = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                                $candidatoMaterno = $candidatosEnFuncionJornadaEfectiva[$posMaterno];



                                $posInsular = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                                $candidatoInsular = $candidatosEnFuncionJornadaEfectiva[$posInsular];



                                $posRefuerzo = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                                $candidatoRefuerzo = $candidatosEnFuncionJornadaEfectiva[$posRefuerzo];
                                if ((Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear())->dayOfWeek == Carbon::SATURDAY) {
                                    $candidatoMaternoAntesSabados = $candidatoMaterno;
                                    $candidatoInsularAntesSabados = $candidatoInsular;
                                    $candidatoRefuerzoAntesSabados = $candidatoRefuerzo;

                                }

                            }

                        }
                    }

                    $posiciones = array_keys($candidatosEnFuncionDias, $candidatoMaterno);
                    unset($candidatosEnFuncionDias[$posiciones[0]]);


                    $posiciones = array_keys($candidatosEnFuncionDias, $candidatoInsular);
                    unset($candidatosEnFuncionDias[$posiciones[0]]);


                    $posiciones = array_keys($candidatosEnFuncionDias, $candidatoRefuerzo);

                    DB::table('guardias')->insert([
                        'fecha' => Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()->toDateString(),
                        'dni' => $candidatoMaterno->dni,
                        'donde' => 'MATERNO',
                        'semestre' => 2
                    ]);
                    DB::table('guardias')->insert([
                        'fecha' => Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()->toDateString(),
                        'dni' => $candidatoInsular->dni,
                        'donde' => 'INSULAR',
                        'semestre' => 2
                    ]);
                    DB::table('guardias')->insert([
                        'fecha' => Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear()->toDateString(),
                        'dni' => $candidatoRefuerzo->dni,
                        'donde' => 'REFUERZO',
                        'semestre' => 2
                    ]);


                    $candidatoMaternoAntes = $candidatoMaterno;
                    $candidatoInsularAntes = $candidatoInsular;


                    //SABADOS
                    if ((Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear())->dayOfWeek == Carbon::SATURDAY) {
                        $candidatoMaternoAntesSabados = $candidatoMaterno;
                        $candidatoInsularAntesSabados = $candidatoInsular;
                        $candidatoRefuerzoAntesSabados = $candidatoRefuerzo;

                    }
                    //DOMINGOS
                    if ((Carbon::parse(date('Y') . '-07-01')->addDays($i)->addYear())->dayOfWeek == Carbon::SUNDAY) {
                        $candidatoMaternoAntesDomingos = $candidatoMaterno;
                        $candidatoInsularAntesDomingos = $candidatoInsular;
                        $candidatoRefuerzoAntesDomingos = $candidatoRefuerzo;

                    }
                }
                if(Carbon::parse(date('Y') . '-07-01')->addDays($i) == Carbon::parse(date('Y') . '-12-15') ){

                }
            }
        }else{

            //SE RECORREN TODOS LOS DIAS DEL AÑO
            for ($i = 0; $i <= $diferencia; $i++) {
                if(in_array((Carbon::parse(date('Y') . '-07-01')->addDays($i)->toDateString()), $festivos)){
                    DB::table('guardias')->insert([
                        'fecha' => Carbon::parse(date('Y') . '-07-01')->addDays($i)->toDateString(),
                        'dni' => 'FESTIVO',
                        'donde' => 'MATERNO',
                        'semestre' => 2
                    ]);
                    DB::table('guardias')->insert([
                        'fecha' => Carbon::parse(date('Y') . '-07-01')->addDays($i)->toDateString(),
                        'dni' => 'FESTIVO',
                        'donde' => 'INSULAR',
                        'semestre' => 2
                    ]);
                    DB::table('guardias')->insert([
                        'fecha' => Carbon::parse(date('Y') . '-07-01')->addDays($i)->toDateString(),
                        'dni' => 'FESTIVO',
                        'donde' => 'REFUERZO',
                        'semestre' => 2
                    ]);
                }else {
                    $candidatos = array();
                    foreach ($usuarios as $usuario) {

                        if ($usuario->haceGuardias == 1) {
                            if (isset($usuario->vacaciones10)
                                and isset($usuario->vacaciones9)
                                and isset($usuario->vacaciones8)
                                and isset($usuario->vacaciones7)
                                and isset($usuario->vacaciones6)
                                and isset($usuario->vacaciones5)
                                and isset($usuario->vacaciones4)
                                and isset($usuario->vacaciones3)
                                and isset($usuario->vacaciones2)
                                and isset($usuario->vacaciones1)
                                and (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones1, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones1, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones2, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones2, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones3, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones3, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones4, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones4, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones5, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones5, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones6, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones6, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones7, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones7, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones8, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones8, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones9, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones9, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones10, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones10, 13, 22))))
                            ) {


                                array_push($candidatos, $usuario);
                            }
                            $totalMed = count(User::all()->where('haceGuardias', '=', 1));
                            $maxGuardias= ceil(($diferencia * 3)/$totalMed);
                            //SE OBTIENEN TODOS LOS USUARIOS
                            $usuarios = User::all();
                            //SE CREA UNA LISTA DE CANDIDATOS QUE SE IRÁ RELLENANDO EN FUNCIÓN DE LAS CONDICIONES


                            if (!isset($usuario->vacaciones10)
                                and isset($usuario->vacaciones9)
                                and isset($usuario->vacaciones8)
                                and isset($usuario->vacaciones7)
                                and isset($usuario->vacaciones6)
                                and isset($usuario->vacaciones5)
                                and isset($usuario->vacaciones4)
                                and isset($usuario->vacaciones3)
                                and isset($usuario->vacaciones2)
                                and isset($usuario->vacaciones1)
                                and //SE COMPRUEBA SI ESE DÍA ESTÁ DE VACACIONES
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones1, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones1, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones2, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones2, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones3, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones3, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones4, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones4, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones5, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones5, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones6, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones6, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones7, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones7, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones8, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones8, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones9, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones9, 13, 22))))
                            ) {

                                array_push($candidatos, $usuario);
                            }


                            if (!isset($usuario->vacaciones10)
                                and !isset($usuario->vacaciones9)
                                and isset($usuario->vacaciones8)
                                and isset($usuario->vacaciones7)
                                and isset($usuario->vacaciones6)
                                and isset($usuario->vacaciones5)
                                and isset($usuario->vacaciones4)
                                and isset($usuario->vacaciones3)
                                and isset($usuario->vacaciones2)
                                and isset($usuario->vacaciones1)
                                and //SE COMPRUEBA SI ESE DÍA ESTÁ DE VACACIONES
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones1, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones1, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones2, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones2, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones3, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones3, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones4, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones4, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones5, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones5, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones6, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones6, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones7, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones7, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones8, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones8, 13, 22))))
                            ) {

                                array_push($candidatos, $usuario);
                            }


                            if (!isset($usuario->vacaciones10)
                                and !isset($usuario->vacaciones9)
                                and !isset($usuario->vacaciones8)
                                and isset($usuario->vacaciones7)
                                and isset($usuario->vacaciones6)
                                and isset($usuario->vacaciones5)
                                and isset($usuario->vacaciones4)
                                and isset($usuario->vacaciones3)
                                and isset($usuario->vacaciones2)
                                and isset($usuario->vacaciones1)
                                and //SE COMPRUEBA SI ESE DÍA ESTÁ DE VACACIONES
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones1, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones1, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones2, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones2, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones3, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones3, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones4, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones4, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones5, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones5, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones6, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones6, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones7, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones7, 13, 22))))
                            ) {

                                array_push($candidatos, $usuario);
                            }


                            if (!isset($usuario->vacaciones10)
                                and !isset($usuario->vacaciones9)
                                and !isset($usuario->vacaciones8)
                                and !isset($usuario->vacaciones7)
                                and isset($usuario->vacaciones6)
                                and isset($usuario->vacaciones5)
                                and isset($usuario->vacaciones4)
                                and isset($usuario->vacaciones3)
                                and isset($usuario->vacaciones2)
                                and isset($usuario->vacaciones1)
                                and //SE COMPRUEBA SI ESE DÍA ESTÁ DE VACACIONES
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones1, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones1, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones2, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones2, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones3, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones3, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones4, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones4, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones5, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones5, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones6, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones6, 13, 22))))
                            ) {

                                array_push($candidatos, $usuario);
                            }


                            if (!isset($usuario->vacaciones10)
                                and !isset($usuario->vacaciones9)
                                and !isset($usuario->vacaciones8)
                                and !isset($usuario->vacaciones7)
                                and !isset($usuario->vacaciones6)
                                and isset($usuario->vacaciones5)
                                and isset($usuario->vacaciones4)
                                and isset($usuario->vacaciones3)
                                and isset($usuario->vacaciones2)
                                and isset($usuario->vacaciones1)
                                and (!fechadentrodeotra((Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones1, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones1, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones2, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones2, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones3, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones3, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones4, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones4, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones5, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones5, 13, 22))))
                            ) {

                                array_push($candidatos, $usuario);
                            }


                            if (!isset($usuario->vacaciones10)
                                and !isset($usuario->vacaciones9)
                                and !isset($usuario->vacaciones8)
                                and !isset($usuario->vacaciones7)
                                and !isset($usuario->vacaciones6)
                                and !isset($usuario->vacaciones5)
                                and isset($usuario->vacaciones4)
                                and isset($usuario->vacaciones3)
                                and isset($usuario->vacaciones2)
                                and isset($usuario->vacaciones1)
                                and //SE COMPRUEBA SI ESE DÍA ESTÁ DE VACACIONES
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones1, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones1, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones2, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones2, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones3, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones3, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones4, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones4, 13, 22))))
                            ) {

                                array_push($candidatos, $usuario);

                            }


                            if (!isset($usuario->vacaciones10)
                                and !isset($usuario->vacaciones9)
                                and !isset($usuario->vacaciones8)
                                and !isset($usuario->vacaciones7)
                                and !isset($usuario->vacaciones6)
                                and !isset($usuario->vacaciones5)
                                and !isset($usuario->vacaciones4)
                                and isset($usuario->vacaciones3)
                                and isset($usuario->vacaciones2)
                                and isset($usuario->vacaciones1)
                                and //SE COMPRUEBA SI ESE DÍA ESTÁ DE VACACIONES
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones1, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones1, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones2, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones2, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones3, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones3, 13, 22))))
                            ) {


                                array_push($candidatos, $usuario);
                            }


                            if (!isset($usuario->vacaciones10)
                                and !isset($usuario->vacaciones9)
                                and !isset($usuario->vacaciones8)
                                and !isset($usuario->vacaciones7)
                                and !isset($usuario->vacaciones6)
                                and !isset($usuario->vacaciones5)
                                and !isset($usuario->vacaciones4)
                                and !isset($usuario->vacaciones3)
                                and isset($usuario->vacaciones2)
                                and isset($usuario->vacaciones1)
                                and //SE COMPRUEBA SI ESE DÍA ESTÁ DE VACACIONES
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones1, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones1, 13, 22))))
                                and
                                (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones2, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones2, 13, 22))))
                            ) {

                                array_push($candidatos, $usuario);
                            }


                            if (!isset($usuario->vacaciones10)
                                and !isset($usuario->vacaciones9)
                                and !isset($usuario->vacaciones8)
                                and !isset($usuario->vacaciones7)
                                and !isset($usuario->vacaciones6)
                                and !isset($usuario->vacaciones5)
                                and !isset($usuario->vacaciones4)
                                and !isset($usuario->vacaciones3)
                                and !isset($usuario->vacaciones2)
                                and isset($usuario->vacaciones1)
                                and (!fechadentrodeotra((
                                Carbon::parse(date('Y') . '-07-01')->addDays($i)),
                                    Carbon::parse(substr($usuario->vacaciones1, 0, 9)),
                                    Carbon::parse(substr($usuario->vacaciones1, 13, 22))))
                            ) {

                                array_push($candidatos, $usuario);
                            }

                            if (!isset($usuario->vacaciones10)
                                and !isset($usuario->vacaciones9)
                                and !isset($usuario->vacaciones8)
                                and !isset($usuario->vacaciones7)
                                and !isset($usuario->vacaciones6)
                                and !isset($usuario->vacaciones5)
                                and !isset($usuario->vacaciones4)
                                and !isset($usuario->vacaciones3)
                                and !isset($usuario->vacaciones2)
                                and !isset($usuario->vacaciones1)) {

                                array_push($candidatos, $usuario);
                            }
                        }
                    }

                    $candidatosEnFuncionJornadaEfectiva = array();
                    foreach($candidatosEnFuncionDias as $actual){
                        if(in_array( $actual, $candidatos)){
                            array_push($candidatosEnFuncionJornadaEfectiva,$actual);
                        }
                    }

                    if(count($candidatosEnFuncionDias)>3){;
                        $posMaterno = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                        $candidatoMaterno = $candidatosEnFuncionJornadaEfectiva[$posMaterno];



                        $posInsular = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                        $candidatoInsular = $candidatosEnFuncionJornadaEfectiva[$posInsular];



                        $posRefuerzo = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                        $candidatoRefuerzo = $candidatosEnFuncionJornadaEfectiva[$posRefuerzo];


                    }
                    if ((Carbon::parse(date('Y') . '-07-01')->addDays($i))->dayOfWeek == Carbon::MONDAY) {
                        if (isset($candidatoInsularAntes) and isset($candidatoMaternoAntes)) {
                            while (
                                //EL MISMO CANDIDATO NO PUEDE ESTAR REPETIDO
                                ($candidatoMaterno == $candidatoInsular)
                                or ($candidatoMaterno == $candidatoRefuerzo)
                                or ($candidatoInsular == $candidatoRefuerzo)
                                or ($candidatoInsular == $candidatoMaterno)
                                or ($candidatoRefuerzo == $candidatoInsular)
                                or ($candidatoRefuerzo == $candidatoMaterno)

                                //NO PUEDEN HABER DE LA MISMA SECCION UN DIA
                                or ($candidatoMaterno->seccion == $candidatoInsular->seccion)
                                or ($candidatoMaterno->seccion == $candidatoRefuerzo->seccion)
                                or ($candidatoMaterno->seccion == $candidatoRefuerzo->seccion)
                                or ($candidatoInsular->seccion == $candidatoRefuerzo->seccion)
                                or ($candidatoInsular->seccion == $candidatoMaterno->seccion)
                                or ($candidatoInsular->seccion == $candidatoMaterno->seccion)
                                or ($candidatoRefuerzo->seccion == $candidatoInsular->seccion)
                                or ($candidatoRefuerzo->seccion == $candidatoMaterno->seccion)
                                or ($candidatoRefuerzo->seccion == $candidatoMaterno->seccion)

                                //NO PUEDE HACER GUARDIAS DE 24H SEGUIDAS
                                or ($candidatoMaterno == $candidatoMaternoAntes)
                                or ($candidatoInsular == $candidatoInsularAntes)
                                or ($candidatoInsular == $candidatoMaternoAntes)
                                or ($candidatoMaterno == $candidatoInsularAntes)

                                //SABADOS
                                or ($candidatoMaterno == $candidatoMaternoAntesSabados)
                                or ($candidatoInsular == $candidatoMaternoAntesSabados)
                                or ($candidatoRefuerzo == $candidatoMaternoAntesSabados)

                                //DOMINGOS
                                or ($candidatoMaterno == $candidatoMaternoAntesDomingos)
                                or ($candidatoInsular == $candidatoMaternoAntesDomingos)
                                or ($candidatoRefuerzo == $candidatoMaternoAntesDomingos)

                                //SABADOS
                                or ($candidatoMaterno == $candidatoInsularAntesSabados)
                                or ($candidatoInsular == $candidatoInsularAntesSabados)
                                or ($candidatoRefuerzo == $candidatoInsularAntesSabados)

                                //DOMINGOS
                                or ($candidatoMaterno == $candidatoInsularAntesDomingos)
                                or ($candidatoInsular == $candidatoInsularAntesDomingos)
                                or ($candidatoRefuerzo == $candidatoInsularAntesDomingos)

                                //SABADOS
                                or ($candidatoMaterno == $candidatoRefuerzoAntesSabados)
                                or ($candidatoInsular == $candidatoRefuerzoAntesSabados)
                                or ($candidatoRefuerzo == $candidatoRefuerzoAntesSabados)

                                //DOMINGOS
                                or ($candidatoMaterno == $candidatoRefuerzoAntesDomingos)
                                or ($candidatoInsular == $candidatoRefuerzoAntesDomingos)
                                or ($candidatoRefuerzo == $candidatoRefuerzoAntesDomingos)

                                //SE COMPRUEBA SI ESE DÍA TIENE 55 AÑOS
                                or (!calculaedad(($candidatoMaterno->fechadenacimiento), Carbon::parse(date('Y') . '-07-01')->addDays($i)) >= 55)
                                or (!calculaedad(($candidatoInsular->fechadenacimiento), Carbon::parse(date('Y') . '-07-01')->addDays($i)) >= 55)
                                or (!calculaedad(($candidatoRefuerzo->fechadenacimiento), Carbon::parse(date('Y') . '-07-01')->addDays($i)) >= 55)
                            ) {
                                if(count($candidatosEnFuncionDias)>3){;
                                    $posMaterno = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                                    $candidatoMaterno = $candidatosEnFuncionJornadaEfectiva[$posMaterno];



                                    $posInsular = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                                    $candidatoInsular = $candidatosEnFuncionJornadaEfectiva[$posInsular];



                                    $posRefuerzo = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                                    $candidatoRefuerzo = $candidatosEnFuncionJornadaEfectiva[$posRefuerzo];

                                    if ((Carbon::parse(date('Y') . '-07-01')->addDays($i))->dayOfWeek == Carbon::SATURDAY) {
                                        $candidatoMaternoAntesSabados = $candidatoMaterno;
                                        $candidatoInsularAntesSabados = $candidatoInsular;
                                        $candidatoRefuerzoAntesSabados = $candidatoRefuerzo;

                                    }


                                }
                            }
                        } else {
                            while (
                                //EL MISMO CANDIDATO NO PUEDE ESTAR REPETIDO
                                ($candidatoMaterno == $candidatoInsular)
                                or ($candidatoMaterno == $candidatoRefuerzo)
                                or ($candidatoInsular == $candidatoRefuerzo)
                                or ($candidatoInsular == $candidatoMaterno)
                                or ($candidatoRefuerzo == $candidatoInsular)
                                or ($candidatoRefuerzo == $candidatoMaterno)

                                //NO PUEDEN HABER DE LA MISMA SECCION UN DIA
                                or ($candidatoMaterno->seccion == $candidatoInsular->seccion)
                                or ($candidatoMaterno->seccion == $candidatoRefuerzo->seccion)
                                or ($candidatoMaterno->seccion == $candidatoRefuerzo->seccion)
                                or ($candidatoInsular->seccion == $candidatoRefuerzo->seccion)
                                or ($candidatoInsular->seccion == $candidatoMaterno->seccion)
                                or ($candidatoInsular->seccion == $candidatoMaterno->seccion)
                                or ($candidatoRefuerzo->seccion == $candidatoInsular->seccion)
                                or ($candidatoRefuerzo->seccion == $candidatoMaterno->seccion)
                                or ($candidatoRefuerzo->seccion == $candidatoMaterno->seccion)

                                //SABADOS
                                or ($candidatoMaterno == $candidatoMaternoAntesSabados)
                                or ($candidatoInsular == $candidatoMaternoAntesSabados)
                                or ($candidatoRefuerzo == $candidatoMaternoAntesSabados)

                                //DOMINGOS
                                or ($candidatoMaterno == $candidatoMaternoAntesDomingos)
                                or ($candidatoInsular == $candidatoMaternoAntesDomingos)
                                or ($candidatoRefuerzo == $candidatoMaternoAntesDomingos)

                                //SABADOS
                                or ($candidatoMaterno == $candidatoInsularAntesSabados)
                                or ($candidatoInsular == $candidatoInsularAntesSabados)
                                or ($candidatoRefuerzo == $candidatoInsularAntesSabados)

                                //DOMINGOS
                                or ($candidatoMaterno == $candidatoInsularAntesDomingos)
                                or ($candidatoInsular == $candidatoInsularAntesDomingos)
                                or ($candidatoRefuerzo == $candidatoInsularAntesDomingos)

                                //SABADOS
                                or ($candidatoMaterno == $candidatoRefuerzoAntesSabados)
                                or ($candidatoInsular == $candidatoRefuerzoAntesSabados)
                                or ($candidatoRefuerzo == $candidatoRefuerzoAntesSabados)

                                //DOMINGOS
                                or ($candidatoMaterno == $candidatoRefuerzoAntesDomingos)
                                or ($candidatoInsular == $candidatoRefuerzoAntesDomingos)
                                or ($candidatoRefuerzo == $candidatoRefuerzoAntesDomingos)

                                //SE COMPRUEBA SI ESE DÍA TIENE 55 AÑOS
                                or (!calculaedad(($candidatoMaterno->fechadenacimiento), Carbon::parse(date('Y') . '-07-01')->addDays($i)) >= 55)
                                or (!calculaedad(($candidatoInsular->fechadenacimiento), Carbon::parse(date('Y') . '-07-01')->addDays($i)) >= 55)
                                or (!calculaedad(($candidatoRefuerzo->fechadenacimiento), Carbon::parse(date('Y') . '-07-01')->addDays($i)) >= 55)

                            ) {
                                if(count($candidatosEnFuncionDias)>3){;
                                    $posMaterno = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                                    $candidatoMaterno = $candidatosEnFuncionJornadaEfectiva[$posMaterno];



                                    $posInsular = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                                    $candidatoInsular = $candidatosEnFuncionJornadaEfectiva[$posInsular];



                                    $posRefuerzo = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                                    $candidatoRefuerzo = $candidatosEnFuncionJornadaEfectiva[$posRefuerzo];

                                    if ((Carbon::parse(date('Y') . '-07-01')->addDays($i))->dayOfWeek == Carbon::SATURDAY) {
                                        $candidatoMaternoAntesSabados = $candidatoMaterno;
                                        $candidatoInsularAntesSabados = $candidatoInsular;
                                        $candidatoRefuerzoAntesSabados = $candidatoRefuerzo;

                                    }


                                }
                            }
                        }
                    } else if (isset($candidatoInsularAntes) and isset($candidatoMaternoAntes)) {
                        while (
                            //EL MISMO CANDIDATO NO PUEDE ESTAR REPETIDO
                            ($candidatoMaterno == $candidatoInsular)
                            or ($candidatoMaterno == $candidatoRefuerzo)
                            or ($candidatoInsular == $candidatoRefuerzo)
                            or ($candidatoInsular == $candidatoMaterno)
                            or ($candidatoRefuerzo == $candidatoInsular)
                            or ($candidatoRefuerzo == $candidatoMaterno)

                            //NO PUEDEN HABER DE LA MISMA SECCION UN DIA
                            or ($candidatoMaterno->seccion == $candidatoInsular->seccion)
                            or ($candidatoMaterno->seccion == $candidatoRefuerzo->seccion)
                            or ($candidatoMaterno->seccion == $candidatoRefuerzo->seccion)
                            or ($candidatoInsular->seccion == $candidatoRefuerzo->seccion)
                            or ($candidatoInsular->seccion == $candidatoMaterno->seccion)
                            or ($candidatoInsular->seccion == $candidatoMaterno->seccion)
                            or ($candidatoRefuerzo->seccion == $candidatoInsular->seccion)
                            or ($candidatoRefuerzo->seccion == $candidatoMaterno->seccion)
                            or ($candidatoRefuerzo->seccion == $candidatoMaterno->seccion)

                            //NO PUEDE HACER GUARDIAS DE 24H SEGUIDAS
                            or ($candidatoMaterno == $candidatoMaternoAntes)
                            or ($candidatoInsular == $candidatoInsularAntes)
                            or ($candidatoInsular == $candidatoMaternoAntes)
                            or ($candidatoMaterno == $candidatoInsularAntes)

                            //SE COMPRUEBA SI ESE DÍA TIENE 55 AÑOS
                            or (!calculaedad(($candidatoMaterno->fechadenacimiento), Carbon::parse(date('Y') . '-07-01')->addDays($i)) >= 55)
                            or (!calculaedad(($candidatoInsular->fechadenacimiento), Carbon::parse(date('Y') . '-07-01')->addDays($i)) >= 55)
                            or (!calculaedad(($candidatoRefuerzo->fechadenacimiento), Carbon::parse(date('Y') . '-07-01')->addDays($i)) >= 55)
                        ) {
                            if(count($candidatosEnFuncionDias)>3){;
                                $posMaterno = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                                $candidatoMaterno = $candidatosEnFuncionJornadaEfectiva[$posMaterno];



                                $posInsular = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                                $candidatoInsular = $candidatosEnFuncionJornadaEfectiva[$posInsular];



                                $posRefuerzo = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                                $candidatoRefuerzo = $candidatosEnFuncionJornadaEfectiva[$posRefuerzo];

                                if ((Carbon::parse(date('Y') . '-07-01')->addDays($i))->dayOfWeek == Carbon::SATURDAY) {
                                    $candidatoMaternoAntesSabados = $candidatoMaterno;
                                    $candidatoInsularAntesSabados = $candidatoInsular;
                                    $candidatoRefuerzoAntesSabados = $candidatoRefuerzo;

                                }

                            }
                        }
                    } else {

                        while (
                            //EL MISMO CANDIDATO NO PUEDE ESTAR REPETIDO
                            ($candidatoMaterno == $candidatoInsular)
                            or ($candidatoMaterno == $candidatoRefuerzo)
                            or ($candidatoInsular == $candidatoRefuerzo)
                            or ($candidatoInsular == $candidatoMaterno)
                            or ($candidatoRefuerzo == $candidatoInsular)
                            or ($candidatoRefuerzo == $candidatoMaterno)

                            //SE COMPRUEBA SI ESE DÍA TIENE 55 AÑOS
                            or (!calculaedad(($candidatoMaterno->fechadenacimiento), Carbon::parse(date('Y') . '-07-01')->addDays($i)) >= 55)
                            or (!calculaedad(($candidatoInsular->fechadenacimiento), Carbon::parse(date('Y') . '-07-01')->addDays($i)) >= 55)
                            or (!calculaedad(($candidatoRefuerzo->fechadenacimiento), Carbon::parse(date('Y') . '-07-01')->addDays($i)) >= 55)
                        ) {
                            if(count($candidatosEnFuncionDias)>3){;
                                $posMaterno = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                                $candidatoMaterno = $candidatosEnFuncionJornadaEfectiva[$posMaterno];



                                $posInsular = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                                $candidatoInsular = $candidatosEnFuncionJornadaEfectiva[$posInsular];



                                $posRefuerzo = array_rand($candidatosEnFuncionJornadaEfectiva, 1);
                                $candidatoRefuerzo = $candidatosEnFuncionJornadaEfectiva[$posRefuerzo];
                                if ((Carbon::parse(date('Y') . '-07-01')->addDays($i))->dayOfWeek == Carbon::SATURDAY) {
                                    $candidatoMaternoAntesSabados = $candidatoMaterno;
                                    $candidatoInsularAntesSabados = $candidatoInsular;
                                    $candidatoRefuerzoAntesSabados = $candidatoRefuerzo;

                                }

                            }

                        }
                    }


                    $posiciones = array_keys($candidatosEnFuncionDias, $candidatoMaterno);
                    unset($candidatosEnFuncionDias[$posiciones[0]]);


                    $posiciones = array_keys($candidatosEnFuncionDias, $candidatoInsular);
                    unset($candidatosEnFuncionDias[$posiciones[0]]);


                    $posiciones = array_keys($candidatosEnFuncionDias, $candidatoRefuerzo);
                    unset($candidatosEnFuncionDias[$posiciones[0]]);


                    DB::table('guardias')->insert([
                        'fecha' => Carbon::parse(date('Y') . '-07-01')->addDays($i)->toDateString(),
                        'dni' => $candidatoMaterno->dni,
                        'donde' => 'MATERNO',
                        'semestre' => 2
                    ]);
                    DB::table('guardias')->insert([
                        'fecha' => Carbon::parse(date('Y') . '-07-01')->addDays($i)->toDateString(),
                        'dni' => $candidatoInsular->dni,
                        'donde' => 'INSULAR',
                        'semestre' => 2
                    ]);
                    DB::table('guardias')->insert([
                        'fecha' => Carbon::parse(date('Y') . '-07-01')->addDays($i)->toDateString(),
                        'dni' => $candidatoRefuerzo->dni,
                        'donde' => 'REFUERZO',
                        'semestre' => 2
                    ]);


                    $candidatoMaternoAntes = $candidatoMaterno;
                    $candidatoInsularAntes = $candidatoInsular;


                    //SABADOS
                    if ((Carbon::parse(date('Y') . '-07-01')->addDays($i))->dayOfWeek == Carbon::SATURDAY) {
                        $candidatoMaternoAntesSabados = $candidatoMaterno;
                        $candidatoInsularAntesSabados = $candidatoInsular;
                        $candidatoRefuerzoAntesSabados = $candidatoRefuerzo;

                    }
                    //DOMINGOS
                    if ((Carbon::parse(date('Y') . '-07-01')->addDays($i))->dayOfWeek == Carbon::SUNDAY) {
                        $candidatoMaternoAntesDomingos = $candidatoMaterno;
                        $candidatoInsularAntesDomingos = $candidatoInsular;
                        $candidatoRefuerzoAntesDomingos = $candidatoRefuerzo;

                    }
                }
            }
        }


        return redirect(route('guardias.index'));
    }



    public function index()
    {
        $guardias = Guardia::paginate();


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

    public function truncate()
    {
        Guardia::truncate();

        return redirect()->route('guardias.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
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
     * @param  int $id
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
     * @param  int $id
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
     * @param  \Illuminate\Http\Request $request
     * @param  Guardia $guardia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Guardia $guardia)
    {
        request()->validate(Guardia::$rules);

        $guardia->update($request->all());
        ;
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
}
