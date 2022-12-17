<?php use Carbon\Carbon; ?>
<?php use App\Models\User;
?>
<link href="{{ asset('css/form-blade-guardia.css') }}" rel="stylesheet">
<div class="box box-info padding-1">
    <div class="box-body">
        <p style="visibility: hidden">{{$fechaCarbon = new Carbon($guardia->fecha)}}</p>

        <div class="row mb-3">
            {{ Form::label('FECHA') }}
            <div class="col-md-6">

                {{ Form::date('fecha', $fechaCarbon, ['class' => 'form-control' . ($errors->has('fecha') ? ' is-invalid' : ''), 'placeholder' => 'Fecha']) }}
                {!! $errors->first('fecha', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row mb-3">
            {{ Form::label('NOMBRE Y APELLIDOS') }}
            <div class="col-md-6">
                <select class="col-md-4 col-form-label form-select" name="dni"  data-live-search="true" required>
                    <?php
                    foreach (User::all() as $cadaUsuario){?>
                    @if($cadaUsuario->haceGuardias == 1)
                        @if($guardia->dni == $cadaUsuario->dni)
                            <option value={{$cadaUsuario->dni}} selected>{{$cadaUsuario->nombre}}</option>
                        @else
                            <option value={{$cadaUsuario->dni}}>{{$cadaUsuario->apellidos}}, {{$cadaUsuario->nombre}}</option>
                        @endif
                    @endif
                    <?php
                    }
                    ?>
                </select>
                {!! $errors->first('dni', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="row mb-3">
            {{ Form::label('LUGAR') }}
            <div class="col-md-6">
                <select class="col-md-4 col-form-label form-select" value="{{$guardia->donde}}" name="donde"  data-live-search="true" required >
                    @if($guardia->donde == "INSULAR")
                        <option value="INSULAR" selected>INSULAR 24H</option>
                        <option value="MATERNO">MATERNO 24H</option>
                        <option value="REFUERZO">REFUERZO 15H A 22H</option>
                    @elseif($guardia->donde == "MATERNO")
                        <option value="INSULAR">INSULAR 24H</option>
                        <option value="MATERNO" selected>MATERNO 24H</option>
                        <option value="REFUERZO">REFUERZO 15H A 22H</option>
                    @elseif($guardia->donde == "REFUERZO")
                        <option value="INSULAR">INSULAR 24H</option>
                        <option value="MATERNO">MATERNO 24H</option>
                        <option value="REFUERZO" selected>REFUERZO 15H A 22H</option>
                    @else
                        <option value="INSULAR">INSULAR 24H</option>
                        <option value="MATERNO">MATERNO 24H</option>
                        <option value="REFUERZO">REFUERZO 15H A 22H</option>
                    @endif

                </select>
                {!! $errors->first('donde', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary"> ACEPTAR </button>
    </div>
</div>
