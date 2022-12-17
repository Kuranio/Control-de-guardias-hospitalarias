@extends('layouts.app')

@section('template_title')
    {{ $festivo->name ?? 'Show Festivo' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Festivo</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('festivos.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Fecha:</strong>
                            {{ $festivo->fecha }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
