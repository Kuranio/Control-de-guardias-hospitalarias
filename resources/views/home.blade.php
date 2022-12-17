<?php
use App\Models\Guardia;
?>
@extends('layouts.app')
<link href="{{ asset('css/evo-calendar.css') }}" rel="stylesheet">
<link href="{{ asset('css/evo-calendar.royal-navy.css') }}" rel="stylesheet">
<link href="{{ asset('css/home-blade.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

@section('content')
    <button class="btn btn-danger"  style="margin-bottom: 1rem">
        <a href="{{route('UserPDF.pdf')}}"><i class="fa" style="font-family: 'Nunito', sans-serif">GENERAR PDF</i></a>
    </button>
    <div id="calendar"></div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="{{ asset('js/evo-calendar.js') }}" defer></script>

    <?php
        echo"<script>
            $(document).ready(function() {
                $('#calendar').evoCalendar({
                    language:'es',
                    theme: 'Royal Navy'
                })";
        echo"\n";
        foreach (Guardia::all() as $guardia){
            if( auth()->user()->dni == $guardia->dni){
                    echo"$('#calendar').evoCalendar('addCalendarEvent', {
                        name: '".$guardia->donde."',
                        date: '".$guardia->fecha."',
                        type: '".strtolower($guardia->donde)."',
                    })";
            echo"\n";
            }

        }
        echo"$('#calendar').evoCalendar({
                    'todayHighlight': true
                });
            })
        </script>";
    ?>

    @if((Session::get('dataUser')->haceGuardias == 0))
        <script>
            document.location.href = '/users'
        </script>


    @endif




@endsection
