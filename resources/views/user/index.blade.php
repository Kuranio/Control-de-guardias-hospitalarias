@extends('layouts.app')

@section('template_title')
    User
@endsection
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<?php
    use Carbon\Carbon;
?>
<style>

    td {
        border: 1px solid #000;
    }

    table, th, td
    {
        border-collapse: collapse;
    }
    .table > thead {
        vertical-align: middle !important;
    }

    .table > :not(caption) > * > * {
        text-align: center !important;
        vertical-align: middle !important;
    }
    tbody > tr:hover{
        background-color: #446b6b !important;
        color: white !important;
    }
    .btn-sm, .btn-group-sm > .btn {
        margin: .2rem;
    }
    form{
        margin-block-end: 0 !important;
    }


    .table > :not(caption) > * > * {
        text-align: center !important;
        vertical-align: middle !important;
    }





    .fa{
        font-size: .8rem !important;
        line-height: .3rem;
    }


    input[type="date"]{
        height: 28px !important;
    }


</style>
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">




                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('USUARIOS') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('register') }}" class="btn btn-success btn-sm float-right"  data-placement="left">
                                  {{ __('CREAR') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
										<th>NOMBRE</th>
										<th>APELLIDOS</th>
                                        <th>DNI</th>
                                        <th>TIPO DE USUARIO</th>
										<th>FECHA DE NACIMIENTO</th>
										<th>VACACIONES</th>
                                        <th>SECCIÓN</th>
										<th title="PORCENTAJE DE TRABAJO EFECTIVO">JORNADA</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <!--<td>{{ ++$i }}</td>-->
                                        @if($user->dni != '78817208A' and $user->dni !='45348381V')
                                        <tr>

											<td>{{ $user->nombre }}</td>
											<td>{{ $user->apellidos }}</td>
                                            <td>{{ $user->dni }}</td>
                                            @if($user->is_admin == 1)
                                                @if($user->haceGuardias == 1)
                                                    <td>ADMINISTRADOR <br> SI HACE GUARDIAS</td>
                                                @else
                                                    <td>ADMINISTRADOR <br> NO HACE GUARDIAS</td>
                                                @endif

                                            @else
                                                <td>ESTÁNDAR</td>
                                            @endif

                                            @if($user->haceGuardias == 1)
                                                <td>{{ substr(Carbon::parse($user->fechadenacimiento)->isoFormat('lll'), 0, -5)}}</td>
                                                @if(isset($user->vacaciones10))
                                                <td>{{substr(Carbon::create(substr($user->vacaciones1,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                    {{substr(Carbon::create(substr($user->vacaciones2,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                    {{substr(Carbon::create(substr($user->vacaciones3,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                    {{substr(Carbon::create(substr($user->vacaciones4,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                    {{substr(Carbon::create(substr($user->vacaciones5,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                    {{substr(Carbon::create(substr($user->vacaciones6,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                    {{substr(Carbon::create(substr($user->vacaciones7,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                    {{substr(Carbon::create(substr($user->vacaciones8,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                    {{substr(Carbon::create(substr($user->vacaciones9,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                    {{substr(Carbon::create(substr($user->vacaciones10,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}}
                                                </td>
                                                @elseif(isset($user->vacaciones9))
                                                    <td>{{substr(Carbon::create(substr($user->vacaciones1,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones2,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones3,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones4,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones5,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones6,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones7,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones8,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones9,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}}
                                                    </td>
                                                @elseif(isset($user->vacaciones5))
                                                    <td>{{substr(Carbon::create(substr($user->vacaciones1,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones2,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones3,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones4,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones5,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones6,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones7,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones8,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}}
                                                    </td>
                                                @elseif(isset($user->vacaciones7))
                                                    <td>{{substr(Carbon::create(substr($user->vacaciones1,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones2,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones3,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones4,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones5,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones6,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones7,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}}
                                                    </td>
                                                @elseif(isset($user->vacaciones6))
                                                    <td>{{substr(Carbon::create(substr($user->vacaciones1,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones2,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones3,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones4,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones5,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones6,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}}
                                                    </td>
                                                @elseif(isset($user->vacaciones5))
                                                    <td>{{substr(Carbon::create(substr($user->vacaciones1,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones2,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones3,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones4,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones5,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}}
                                                    </td>
                                                @elseif(isset($user->vacaciones4))
                                                    <td>{{substr(Carbon::create(substr($user->vacaciones1,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones2,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones3,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones4,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}}
                                                    </td>
                                                @elseif(isset($user->vacaciones3))
                                                    <td>{{substr(Carbon::create(substr($user->vacaciones1,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones2,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones3,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}}
                                                    </td>
                                                @elseif(isset($user->vacaciones2))
                                                    <td>{{substr(Carbon::create(substr($user->vacaciones1,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}} <br>
                                                        {{substr(Carbon::create(substr($user->vacaciones2,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}}
                                                    </td>
                                                @elseif(isset($user->vacaciones1))
                                                    <td>{{substr(Carbon::create(substr($user->vacaciones1,0,9))->isoFormat('lll'), 0, -14)}} | {{substr(Carbon::create(substr($user->vacaciones1,13,22))->isoFormat('lll'), 0, -14)}}
                                                    </td>
                                                @else
                                                    <td></td>
                                                @endif

                                            @else
                                                <td></td>
                                                <td></td>

                                            @endif

											<td>{{ $user->seccion }}</td>
                                            @if($user->jornada != 1)
                                                <td>{{ $user->jornada }}</td>
                                            @else
                                                    <td></td>
                                            @endif
                                            

                                            <td>
                                                <form action="{{ route('users.destroy',$user->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('users.show',$user->id) }}"><i class="fa fa-fw fa-edit"></i> VER</a>
                                                    @if($user->haceGuardias == 1)
                                                    <a class="btn btn-sm btn-success" href="{{ route('users.edit',$user->id) }}"><i class="fa fa-fw fa-edit"></i> EDITAR</a>
                                                    @else
                                                    @endif

                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> BORRAR</button>
                                                </form>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $users->links() !!}
            </div>
        </div>
    </div>
@endsection
