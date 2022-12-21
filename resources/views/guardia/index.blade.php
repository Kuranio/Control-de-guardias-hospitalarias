<?php
use Carbon\Carbon;
use App\Models\User;
?>
@extends('layouts.app')

@section('template_title')
    Guardia

@endsection

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<style>

    td {
        border: 1px solid #000;
    }


    #firstTD{
        border-bottom: 5px solid white;
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

    .form-control{
        margin-top: 1rem;
        margin-bottom: 1rem;
    }


    #btn-back-to-top {
        position: fixed;
        bottom: 20px;
        right: 20px;
        display: none;
    }

    @media only screen and (max-width: 769px){
        #btn-back-to-top{
            right: 88%;
            z-index: 2;
        }

    }

    .cardContainer{
        background-color: #213737;
        padding: 1rem;
    }

    .card1{
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
    }

    form{
        all: unset;
    }

    .card1 > *{
        margin: 1rem;
    }

    .botonDistr{
        margin: 1rem;
    }

</style>
@section('content')
    <button
        type="button"
        class="btn btn-danger btn-floating btn-lg"
        id="btn-back-to-top">
        <i class="fas fa-arrow-up"></i>
    </button>
    <script>
        //Get the button
        let mybutton = document.getElementById("btn-back-to-top");

        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function () {
            scrollFunction();
        };

        function scrollFunction() {
            if (
                document.body.scrollTop > 20 ||
                document.documentElement.scrollTop > 20
            ) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";
            }
        }
        // When the user clicks on the button, scroll to the top of the document
        mybutton.addEventListener("click", backToTop);

        function backToTop() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }

        $(window).on('load', function () {
            $('#loading').hide();
        })
    </script>
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-12">

                <script>

                    function confirmacion1(){
                        $('#basicExampleModal').modal('show')
                    }

                    function confirmacion2(){
                        $('#basicExampleModal2').modal('show')
                    }

                    function confirmacion3(){
                        $('#basicExampleModal3').modal('show')
                    }

                </script>
                <div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <!--
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">MENSAJE PARA EL USUARIO</h5>
                            </div>-->
                            <div class="modal-body">
                                <p style="color: black; font-size: 1.3rem; text-align: center">SI CONTINÚAS, SE CREARÁN NUEVAS GUARDIAS PARA EL PRIMER SEMESTRE <br> 📅 DEL 1 DE FEBRERO AL 30 DE JUNIO 📅 <br> Y SE ELIMINARÁN LAS YA EXISTENTES</p>
                            </div>
                            <div class="modal-footer" style="margin: 0 auto">
                                <input type="button" class="btn btn-success" onclick="location.href='{{url('guardias-generate/1')}}';" data-bs-dismiss="modal" value="CONTINUAR"/>
                                <input type="button" class="btn btn-danger"  data-bs-dismiss="modal" value="CANCELAR"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="basicExampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <!--
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">MENSAJE PARA EL USUARIO</h5>
                            </div>-->
                            <div class="modal-body">
                                <p style="color: black; font-size: 1.3rem; text-align: center">SI CONTINÚAS, SE CREARÁN NUEVAS GUARDIAS PARA EL SEGUNDO SEMESTRE <br> 📅 DEL 1 DE JULIO AL 15 DE DICIEMBRE 📅 <br> Y SE ELIMINARÁN LAS YA EXISTENTES</p>
                            </div>
                            <div class="modal-footer" style="margin: 0 auto">
                                <input type="button" class="btn btn-success" onclick="location.href='{{url('guardias-generate/2')}}';" data-bs-dismiss="modal" value="CONTINUAR"/>
                                <input type="button" class="btn btn-danger"  data-bs-dismiss="modal" value="CANCELAR"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="basicExampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <!--
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">MENSAJE PARA EL USUARIO</h5>
                            </div>-->
                            <div class="modal-body">
                                <p style="color: black; font-size: 1.3rem; text-align: center">🗑️ SI CONTINÚAS, SE ELIMINARÁN TODAS LAS GUARDIAS 🗑️</p>
                            </div>
                            <div class="modal-footer" style="margin: 0 auto">
                                <input type="button" class="btn btn-success" onclick="location.href='{{ route('guardias.truncate') }}';" data-bs-dismiss="modal" value="CONTINUAR"/>
                                <input type="button" class="btn btn-danger"  data-bs-dismiss="modal" value="CANCELAR"/>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="cardContainer">
                    <div class="card3">
                        <form action="{{ route('guardias.index') }}" method="GET" role="search" class="cabeceraGuardias">
                            <button class="btn btn-dark botonDistr"  style="height: 36px !important;" type="button" onclick = "confirmacion1()">
                                <i class="fa" style="font-family: 'Nunito', sans-serif">DISTRIBUIR GUARDIAS DEL PRIMER SEMESTRE</i>

                            </button>
                            <button class="btn btn-dark botonDistr" style="height: 36px !important;" type="button" onclick = "confirmacion2()">
                                <i class="fa" style="font-family: 'Nunito', sans-serif">DISTRIBUIR GUARDIAS DEL SEGUNDO SEMESTRE</i>
                            </button>


                            <button class="btn btn-dark botonDistr" style="height: 36px !important;" type="button"  onclick = "confirmacion3()">
                                <i class="fa" style="font-family: 'Nunito', sans-serif">ELIMINAR TODAS LAS GUARDIAS</i>
                            </button>

                        </form>
                        <button class="btn btn-dark botonDistr" style="height: 36px !important;" type="button" >
                            <a href="{{route('guardias.pdf')}}"><i class="fa" style="font-family: 'Nunito', sans-serif">GENERAR PDF</i></a>
                        </button>

                    <HR>
                    </div>

                        <form class="card1" action="{{ route('guardias.index') }}" method="GET" role="search">
                            <input  type="date" title="BUSCAR POR FECHA DE GUARDIA" class="form-control" style="width: 20rem !important;" name="term" placeholder="BUSCAR" id="term" style="margin-right: 1rem">
                            <input  type="text" class="form-control" style="width: 20rem !important;" name="term1" placeholder="DNI | NOMBRE | FESTIVO" id="term1" style="margin-right: 1rem">
                                <button class="btn btn-warning botonDistr" style="height: 36px !important;" type="submit">
                                    <i class="fa" style="font-family: 'Nunito', sans-serif">&#128270; BUSCAR</i>
                                </button>

                            <a href="{{ route('guardias.index') }}"  style="text-decoration: none">
                                <button class="btn btn-warning botonDistr" style="height: 36px !important;" type="button">
                                    <i class="fa" style="font-family: 'Nunito', sans-serif">&#11013; REGRESAR</i>
                                </button>
                            </a>

                            <a href="{{ route('guardias.create') }}"  style="text-decoration: none" >
                                <button class="btn btn-warning botonDistr" style="height: 36px !important;" type="button">
                                    <i class="fa" style="font-family: 'Nunito', sans-serif">&#9997; CREAR NUEVA GUARDIA</i>
                                </button>
                            </a>
                        </form>

                        <HR>
                        @foreach ($guardias as $guardia)
                                <?php

                                $diaActual = Carbon::parse($guardia->fecha)->isoFormat('dddd D \d\e MMMM');
                                $mes = Carbon::parse($guardia->fecha)->isoFormat('MMMM | YYYY');
                                ?>
                                    @if(((strpos($diaActual, " 1 de") != false) or (strpos($diaActual, " 15 de enero") != false)) and ($guardia->donde == "MATERNO"))
                                    <button class="btn btn-dark" style="height: 28px !important; margin: 1rem" type="button">
                                    <a href="#{{strtoupper($mes)}}" class="fa" style="font-family: 'Nunito', sans-serif; text-decoration: none"> {{ strtoupper($mes)}} </a>
                                </button>
                            @endif
                        @endforeach
                    </div>



                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif





                    <div class="card-body">
                        COUNT: {{ $guardias->count()  }}
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                <tr id="firstTD">
                                    <!--<th>Nº</th>-->

                                    <th>FECHA</th>
                                    <th>DNI</th>
                                    <th>DÓNDE</th>
                                    <th>NOMBRE Y APELLIDOS</th>
                                    <th>ACCIONES</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($guardias as $guardia)
                                    <?php

                                    $diaActual = Carbon::parse($guardia->fecha)->isoFormat('dddd D \d\e MMMM YYYY');
                                    $mes = Carbon::parse($guardia->fecha)->isoFormat('MMMM | YYYY');
                                    ?>
                                    @if(((strpos($diaActual, " 1 de") != false) or (strpos($diaActual, " 15 de enero") != false)) and ($guardia->donde == "MATERNO"))
                                        <tr>
                                            <td id="{{strtoupper($mes)}}" colspan="5" style="background-color: white; color: #0c4128; font-weight: bold">{{ strtoupper($mes)}}</td>
                                        </tr>
                                    @endif
                                    @if($guardia->donde == "REFUERZO")
                                        <tr style="border-bottom: 5px solid white">
                                            <!--<td>{{ ++$i }}</td>-->
                                            @if($guardia->dni == "FESTIVO")
                                                <td style="background-color: white; color: #0c4128; font-weight: bold"> FESTIVO - {{ ucfirst($diaActual) }}</td>

                                            <td colspan="3"></td>
                                                <td>
                                                    <form  action="{{ route('guardias.destroy',$guardia->id) }}" method="POST">
                                                        <a class="btn btn-sm btn-primary" href="{{ route('guardias.edit',$guardia->id) }}"><i class="fa fa-fw fa-edit"></i> ASIGNAR</a>
                                                        <script>

                                                            function confirmacion4(){
                                                                $('#basicExampleModal4').modal('show')
                                                            }

                                                        </script>
                                                        <div class="modal fade" id="basicExampleModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <!--
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">MENSAJE PARA EL USUARIO</h5>
                                                                    </div>-->
                                                                    <div class="modal-body">
                                                                        <p style="color: black; font-size: 1.3rem; text-align: center">🗑️ SI CONTINÚAS, SE ELIMINARÁ LA GUARDIA DE {{$guardia->dni}} DEL DÍA {{ucfirst($diaActual)}} DE LA GUARDIA EN {{$guardia->donde}}🗑️</p>
                                                                    </div>
                                                                    <div class="modal-footer" style="margin: 0 auto">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-success"  data-bs-dismiss="modal">CONTINUAR</button>
                                                                        <input type="button" class="btn btn-danger"  data-bs-dismiss="modal" value="CANCELAR"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </form>
                                                </td>

                                            @else

                                                <td>{{ ucfirst($diaActual) }}</td>
                                                <td>{{ $guardia->dni }}</td>


                                                <td>{{ $guardia->donde }}</td>
                                                <?php
                                                foreach (User::all() as $cadaUsuario) {
                                                ?>
                                                @if($cadaUsuario->dni == $guardia->dni)
                                                    <td>{{$cadaUsuario->apellidos}}, {{ $cadaUsuario->nombre }}</td>
                                                @endif
                                                <?php
                                                }
                                                ?>

                                                <td>
                                                    <form  action="{{ route('guardias.destroy',$guardia->id) }}" method="POST">
                                                        <a class="btn btn-sm btn-success" href="{{ route('guardias.edit',$guardia->id) }}"><i class="fa fa-fw fa-edit"></i> EDITAR</a>
                                                        <a class="btn btn-danger btn-sm" onclick="confirmacion4()"><i class="fa fa-fw fa-trash"></i> BORRAR</a>
                                                        <script>

                                                            function confirmacion4(){
                                                                $('#basicExampleModal4').modal('show')
                                                            }

                                                        </script>
                                                        <div class="modal fade" id="basicExampleModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <!--
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">MENSAJE PARA EL USUARIO</h5>
                                                                    </div>-->
                                                                    <div class="modal-body">
                                                                        <p style="color: black; font-size: 1.3rem; text-align: center">🗑️ SI CONTINÚAS, SE ELIMINARÁ LA GUARDIA DE {{$guardia->dni}} DEL DÍA {{ucfirst($diaActual)}} DE LA GUARDIA EN {{$guardia->donde}}🗑️</p>
                                                                    </div>
                                                                    <div class="modal-footer" style="margin: 0 auto">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-success"  data-bs-dismiss="modal">CONTINUAR</button>
                                                                        <input type="button" class="btn btn-danger"  data-bs-dismiss="modal" value="CANCELAR"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </form>
                                                </td>
                                            @endif
                                        </tr>
                                    @else
                                        <tr>
                                            <!--<td>{{ ++$i }}</td>-->
                                            @if($guardia->dni == "FESTIVO")
                                                <td style="background-color: white; color: #0c4128; font-weight: bold"> FESTIVO - {{ucfirst($diaActual) }}</td>
                                            <td colspan="3"></td>
                                                <td>
                                                    <form  action="{{ route('guardias.destroy',$guardia->id) }}" method="POST">
                                                        <a class="btn btn-sm btn-primary" href="{{ route('guardias.edit',$guardia->id) }}"><i class="fa fa-fw fa-edit"></i> ASIGNAR</a>
                                                        <script>

                                                            function confirmacion4(){
                                                                $('#basicExampleModal4').modal('show')
                                                            }

                                                        </script>
                                                        <div class="modal fade" id="basicExampleModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <!--
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">MENSAJE PARA EL USUARIO</h5>
                                                                    </div>-->
                                                                    <div class="modal-body">
                                                                        <p style="color: black; font-size: 1.3rem; text-align: center">🗑️ SI CONTINÚAS, SE ELIMINARÁ LA GUARDIA DE {{$guardia->dni}} DEL DÍA {{ucfirst($diaActual)}} DE LA GUARDIA EN {{$guardia->donde}}🗑️</p>
                                                                    </div>
                                                                    <div class="modal-footer" style="margin: 0 auto">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-success"  data-bs-dismiss="modal">CONTINUAR</button>
                                                                        <input type="button" class="btn btn-danger"  data-bs-dismiss="modal" value="CANCELAR"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </form>
                                                </td>


                                            @else

                                                <td>{{ ucfirst($diaActual) }}</td>
                                                <td>{{ $guardia->dni }}</td>


                                                <td>{{ $guardia->donde }}</td>
                                                <?php
                                                foreach (User::all() as $cadaUsuario) {
                                                ?>
                                                @if($cadaUsuario->dni == $guardia->dni)
                                                    <td>{{$cadaUsuario->apellidos}}, {{ $cadaUsuario->nombre }}</td>
                                                @endif
                                                <?php
                                                }
                                                ?>

                                                <td>
                                                    <form  action="{{ route('guardias.destroy',$guardia->id) }}" method="POST">
                                                        <a class="btn btn-sm btn-success" href="{{ route('guardias.edit',$guardia->id) }}"><i class="fa fa-fw fa-edit"></i> EDITAR</a>
                                                        <a class="btn btn-danger btn-sm" onclick="confirmacion4()"><i class="fa fa-fw fa-trash"></i> BORRAR</a>
                                                        <script>

                                                            function confirmacion4(){
                                                                $('#basicExampleModal4').modal('show')
                                                            }

                                                        </script>
                                                        <div class="modal fade" id="basicExampleModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <!--
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">MENSAJE PARA EL USUARIO</h5>
                                                                    </div>-->
                                                                    <div class="modal-body">
                                                                        <p style="color: black; font-size: 1.3rem; text-align: center">🗑️ SI CONTINÚAS, SE ELIMINARÁ LA GUARDIA DE {{$guardia->dni}} DEL DÍA {{ucfirst($diaActual)}} DE LA GUARDIA EN {{$guardia->donde}}🗑️</p>
                                                                    </div>
                                                                    <div class="modal-footer" style="margin: 0 auto">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-success"  data-bs-dismiss="modal">CONTINUAR</button>
                                                                        <input type="button" class="btn btn-danger"  data-bs-dismiss="modal" value="CANCELAR"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </form>
                                                </td>
                                            @endif
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--{!! $guardias->links() !!}-->
            </div>
        </div>
    </div>
@endsection

