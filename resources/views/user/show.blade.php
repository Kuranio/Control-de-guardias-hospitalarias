@extends('layouts.app')
<?php
use Carbon\Carbon;

?>
<style>
    .form-group{
        margin: 1rem;
        text-align: left;
    }
    </style>
@section('template_title')
    {{ $user->name ?? 'Show User' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">INFORMACIÓN DE {{$user->nombre}}</span>
                        </div>
                        
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>NOMBRE:</strong>
                            {{ $user->nombre }}
                        </div>
                        <div class="form-group">
                            <strong>APELLIDOS:</strong>
                            {{ $user->apellidos }}
                        </div>
                        
                       
                        <div class="form-group">
                            <strong>DNI:</strong>
                            {{ $user->dni }}
                        </div>
                        
                        
                        @if($user->is_admin == 1)
                        <div class="form-group">
                            <strong>ADMINISTRADOR</strong>
                        
                        @else
                        <div class="form-group">
                            <strong>USUARIO ESTÁNDAR</strong>
                        </div>
                        <div class="form-group">
                            <strong>FECHA DE NACIMIENTO:</strong>
                            {{ Carbon::parse($user->fechadenacimiento)->isoFormat('DD/MM/YYYY') }}
                        </div>
                        <div class="form-group">
                            <strong>JORNADA:</strong>
                            {{ $user->jornada }}
                        </div>
                        <div class="form-group">
                            <strong>SECCIÓN:</strong>
                            {{ $user->seccion }}
                        </div>
                        <div class="form-group">
                            <strong>VACACIONES:</strong>
                            {{ $user->vacaciones1 }}
                            {{ $user->vacaciones2 }}
                            {{ $user->vacaciones3 }}
                            {{ $user->vacaciones4 }}
                            {{ $user->vacaciones5 }}
                            {{ $user->vacaciones6 }}
                            {{ $user->vacaciones7 }}
                            {{ $user->vacaciones8 }}
                            {{ $user->vacaciones9 }}
                            {{ $user->vacaciones10 }}
                        </div>
                        @endif
                    </div>
                </div>
                
            </div>
            <div class="float-right mt-3">
                <a class="btn btn-primary" href="{{ route('users.index') }}"> VOLVER</a>
            </div>
        </div>
    </section>
@endsection
