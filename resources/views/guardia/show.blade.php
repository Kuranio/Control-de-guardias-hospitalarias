@extends('layouts.app')

@section('template_title')
    {{ $guardia->name ?? 'Show Guardia' }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">Show Guardia</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('guardias.index') }}"> Back</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Fecha:</strong>
                            {{ $guardia->fecha }}
                        </div>
                        <div class="form-group">
                            <strong>Dni:</strong>
                            {{ $guardia->dni }}
                        </div>
                        <div class="form-group">
                            <strong>Donde:</strong>
                            {{ $guardia->donde }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
