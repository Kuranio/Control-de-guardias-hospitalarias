<div class="box box-info padding-1">
    <div class="box-body">


        <div class="row mb-3">
            <label for="from" class="col-md-4 col-form-label text-md-end">FECHA ÚNICA O RANGO DE FECHAS</label>
            <div class="col-md-6">
                <select class="form-control" id="queTipoFecha" onchange="fechasScript()">
                    <option value="individual">FECHA ÚNICA</option>
                    <option value="rango">RANGO DE FECHAS</option>
                </select>
            </div>
        </div>

        <div class="row mb-3" id="idIndividual">
            <label for="fecha3" class="col-md-4 col-form-label text-md-end">{{ __('FECHA DEL FESTIVO') }}</label>
            <div class="col-md-6">
                <input id="fecha3" onchange="valorFechaFunción()" type="date" class="form-control @error('fecha3') is-invalid @enderror" name="fecha3" value="{{ old('fecha3') }}" autocomplete="fecha3" autofocus>
                @error('fecha3')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3" id="idRango1" style="display: none">
            <label class="col-md-4 col-form-label text-md-end">{{ __('FECHA INICIO DEL FESTIVO') }}</label>
            <div class="col-md-6">
                <input id="fecha1" type="date" class="form-control @error('fecha') is-invalid @enderror" name="fecha1"  autocomplete="fecha1" autofocus>
                @error('fecha')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3" id="idRango2" style="display: none">
            <label class="col-md-4 col-form-label text-md-end">{{ __('FECHA FINAL DEL FESTIVO') }}</label>
            <div class="col-md-6">
                <input id="fecha2" type="date" class="form-control @error('fecha2') is-invalid @enderror" name="fecha2"  autocomplete="fecha2" autofocus onchange="valorFechaFunción1()">
                @error('fecha2')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <input type="hidden" name="fecha" id="valorFecha">

        <script>
            function valorFechaFunción(){
                document.getElementById('valorFecha').value = document.getElementById('fecha3').value;
            }
            function valorFechaFunción1(){
                document.getElementById('valorFecha').value = document.getElementById('fecha1').value + " | " + document.getElementById('fecha2').value;
            }
        </script>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">ACEPTAR</button>
    </div>
</div>

<script>
    function fechasScript(){
        if(document.getElementById('queTipoFecha').value === 'individual'){
            document.getElementById('idIndividual').style.display = 'flex';
            document.getElementById('idRango1').style.display = 'none';
            document.getElementById('idRango2').style.display = 'none';
        }
        else if(document.getElementById('queTipoFecha').value === 'rango'){
            document.getElementById('idRango1').style.display = 'flex';
            document.getElementById('idRango2').style.display = 'flex';
            document.getElementById('idIndividual').style.display = 'none';

        }
    }
</script>
