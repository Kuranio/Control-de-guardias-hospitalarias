<?php
use Carbon\Carbon;
?>
@extends('layouts.app')

@section('template_title')
    FESTIVOS - DÍAS NO LABORABLES
@endsection
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
    }form{
         margin-block-end: 0 !important;
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
                                {{ __('FESTIVOS - DÍAS NO LABORABLES') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('festivos.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('CREAR NUEVO FESTIVO') }}
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


										<th>FECHA</th>

                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($festivos as $festivo)
                                        <tr>

                                            @if (str_contains( $festivo->fecha , '|'))
                                            <td> DESDE EL
                                            @foreach(explode("|",$festivo->fecha) as $count => $ids)
                                            @if($count == 1) AL @endif

                                                {{ Carbon::parse($ids)->isoFormat('D \d\e MMMM \d\e YYYY') }}
                                            @endforeach
                                            </td>
                                            @else
                                            <td>{{ Carbon::parse($festivo->fecha)->isoFormat('D \d\e MMMM \d\e YYYY') }}</td>
                                            @endif
                                            <td>
                                                <form action="{{ route('festivos.destroy',$festivo->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> BORRAR</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $festivos->links() !!}
            </div>
        </div>
    </div>
@endsection
