<div class="box box-info padding-1">
    <div class="box-body">


        <div class="row mb-3">
            <label for="nombre" class="col-md-4 col-form-label text-md-end">{{ __('NOMBRE') }}</label>
            <div class="col-md-6">
                {{ Form::text('nombre', $user->nombre, ['class' => 'form-control' . ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
                @error('nombre')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <label for="apellidos" class="col-md-4 col-form-label text-md-end">{{ __('APELLIDOS') }}</label>
            <div class="col-md-6">
                {{ Form::text('apellidos', $user->apellidos, ['class' => 'form-control' . ($errors->has('apellidos') ? ' is-invalid' : ''), 'placeholder' => 'Apellidos']) }}
                @error('apellidos')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3" id="fechaNacForm">
            <label for="fechadenacimiento" class="col-md-4 col-form-label text-md-end">{{ __('FECHA DE NACIMIENTO') }}</label>
            <div class="col-md-6">
                {{ Form::date('fechadenacimiento', $user->fechadenacimiento, ['class' => 'form-control' . ($errors->has('fechadenacimiento') ? ' is-invalid' : ''), 'placeholder' => 'Fechadenacimiento']) }}
                @error('fechadenacimiento')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3" id="periodoVacacionesID">
            <label for="from" class="col-md-4 col-form-label text-md-end">PERIODOS DE VACACIONES DEL USUARIO</label>
            <div class="col-md-6">
                <select class="form-control" id="exampleFormControlSelect1" onchange="primerPeriodo()">
                    <option label=" " selected></option>
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
            </div> 
        </div>
        
        <script>
            function primerPeriodo(){
                switch (document.getElementById('exampleFormControlSelect1').value) {
                    case "0":
                        document.getElementById('primerPeriodo').style.display = "none";
                        document.getElementById('segundoPeriodo').style.display = "none";
                        document.getElementById('tercerPeriodo').style.display = "none";
                        document.getElementById('cuartoPeriodo').style.display = "none";
                        document.getElementById('sextoPeriodo').style.display = "none";
                        document.getElementById('septimoPeriodo').style.display = "none";
                        document.getElementById('octavoPeriodo').style.display = "none";
                        document.getElementById('novenoPeriodo').style.display = "none";
                        document.getElementById('decimoPeriodo').style.display = "none";
                        break;
                    case "1":
                        document.getElementById('primerPeriodo').style.display = "block";
                        document.getElementById('segundoPeriodo').style.display = "none";
                        document.getElementById('tercerPeriodo').style.display = "none";
                        document.getElementById('cuartoPeriodo').style.display = "none";
                        document.getElementById('sextoPeriodo').style.display = "none";
                        document.getElementById('septimoPeriodo').style.display = "none";
                        document.getElementById('octavoPeriodo').style.display = "none";
                        document.getElementById('novenoPeriodo').style.display = "none";
                        document.getElementById('decimoPeriodo').style.display = "none";
                        break;
                    case "2":
                        document.getElementById('primerPeriodo').style.display = "block";
                        document.getElementById('segundoPeriodo').style.display = "block";
                        document.getElementById('tercerPeriodo').style.display = "none";
                        document.getElementById('cuartoPeriodo').style.display = "none";
                        document.getElementById('sextoPeriodo').style.display = "none";
                        document.getElementById('septimoPeriodo').style.display = "none";
                        document.getElementById('octavoPeriodo').style.display = "none";
                        document.getElementById('novenoPeriodo').style.display = "none";
                        document.getElementById('decimoPeriodo').style.display = "none";
                        break;
                    case "3":
                        document.getElementById('primerPeriodo').style.display = "block";
                        document.getElementById('segundoPeriodo').style.display = "block";
                        document.getElementById('tercerPeriodo').style.display = "block";
                        document.getElementById('cuartoPeriodo').style.display = "none";
                        document.getElementById('sextoPeriodo').style.display = "none";
                        document.getElementById('septimoPeriodo').style.display = "none";
                        document.getElementById('octavoPeriodo').style.display = "none";
                        document.getElementById('novenoPeriodo').style.display = "none";
                        document.getElementById('decimoPeriodo').style.display = "none";
                        break;
                    case "4":
                        document.getElementById('primerPeriodo').style.display = "block";
                        document.getElementById('segundoPeriodo').style.display = "block";
                        document.getElementById('tercerPeriodo').style.display = "block";
                        document.getElementById('cuartoPeriodo').style.display = "block";
                        document.getElementById('sextoPeriodo').style.display = "none";
                        document.getElementById('septimoPeriodo').style.display = "none";
                        document.getElementById('octavoPeriodo').style.display = "none";
                        document.getElementById('novenoPeriodo').style.display = "none";
                        document.getElementById('decimoPeriodo').style.display = "none";
                        break;
                    case "5":
                        document.getElementById('primerPeriodo').style.display = "block";
                        document.getElementById('segundoPeriodo').style.display = "block";
                        document.getElementById('tercerPeriodo').style.display = "block";
                        document.getElementById('cuartoPeriodo').style.display = "block";
                        document.getElementById('quintoPeriodo').style.display = "block";
                        document.getElementById('sextoPeriodo').style.display = "none";
                        document.getElementById('septimoPeriodo').style.display = "none";
                        document.getElementById('octavoPeriodo').style.display = "none";
                        document.getElementById('novenoPeriodo').style.display = "none";
                        document.getElementById('decimoPeriodo').style.display = "none";
                        break;
                    case "6":
                        document.getElementById('primerPeriodo').style.display = "block";
                        document.getElementById('segundoPeriodo').style.display = "block";
                        document.getElementById('tercerPeriodo').style.display = "block";
                        document.getElementById('cuartoPeriodo').style.display = "block";
                        document.getElementById('quintoPeriodo').style.display = "block";
                        document.getElementById('sextoPeriodo').style.display = "block";
                        document.getElementById('septimoPeriodo').style.display = "none";
                        document.getElementById('octavoPeriodo').style.display = "none";
                        document.getElementById('novenoPeriodo').style.display = "none";
                        document.getElementById('decimoPeriodo').style.display = "none";
                        break;
                    case "7":
                        document.getElementById('primerPeriodo').style.display = "block";
                        document.getElementById('segundoPeriodo').style.display = "block";
                        document.getElementById('tercerPeriodo').style.display = "block";
                        document.getElementById('cuartoPeriodo').style.display = "block";
                        document.getElementById('quintoPeriodo').style.display = "block";
                        document.getElementById('sextoPeriodo').style.display = "block";
                        document.getElementById('septimoPeriodo').style.display = "block";
                        document.getElementById('octavoPeriodo').style.display = "none";
                        document.getElementById('novenoPeriodo').style.display = "none";
                        document.getElementById('decimoPeriodo').style.display = "none";
                        break;
                    case "8":
                        document.getElementById('primerPeriodo').style.display = "block";
                        document.getElementById('segundoPeriodo').style.display = "block";
                        document.getElementById('tercerPeriodo').style.display = "block";
                        document.getElementById('cuartoPeriodo').style.display = "block";
                        document.getElementById('quintoPeriodo').style.display = "block";
                        document.getElementById('sextoPeriodo').style.display = "block";
                        document.getElementById('septimoPeriodo').style.display = "block";
                        document.getElementById('octavoPeriodo').style.display = "block";
                        document.getElementById('novenoPeriodo').style.display = "none";
                        document.getElementById('decimoPeriodo').style.display = "none";
                        break;
                    case "9":
                        document.getElementById('primerPeriodo').style.display = "block";
                        document.getElementById('segundoPeriodo').style.display = "block";
                        document.getElementById('tercerPeriodo').style.display = "block";
                        document.getElementById('cuartoPeriodo').style.display = "block";
                        document.getElementById('quintoPeriodo').style.display = "block";
                        document.getElementById('sextoPeriodo').style.display = "block";
                        document.getElementById('septimoPeriodo').style.display = "block";
                        document.getElementById('octavoPeriodo').style.display = "block";
                        document.getElementById('novenoPeriodo').style.display = "block";
                        document.getElementById('decimoPeriodo').style.display = "none";
                        break;
                    case "10":
                        document.getElementById('primerPeriodo').style.display = "block";
                        document.getElementById('segundoPeriodo').style.display = "block";
                        document.getElementById('tercerPeriodo').style.display = "block";
                        document.getElementById('cuartoPeriodo').style.display = "block";
                        document.getElementById('quintoPeriodo').style.display = "block";
                        document.getElementById('sextoPeriodo').style.display = "block";
                        document.getElementById('septimoPeriodo').style.display = "block";
                        document.getElementById('octavoPeriodo').style.display = "block";
                        document.getElementById('novenoPeriodo').style.display = "block";
                        document.getElementById('decimoPeriodo').style.display = "block";
                        break;
                }
            }
        </script>

        <div id="primerPeriodo"  style="display: none">
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end"> PRIMER PERIODO DE VACACIONES DESDE</label>
                <div class="col-md-6">
                    <input type="date" id="primerPeriodo1" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
            <label for="to" class="col-md-4 col-form-label text-md-end"> PRIMER PERIODO DE VACACIONES HASTA</label>
                <div class="col-md-6">
                    <input onchange="primerPeriodoValueF()" type="date" id="primerPeriodo2" class="form-control">
                </div>
            </div>
        </div>

        <input type="hidden" name="vacaciones1" id="primerPeriodoValue">


        <div id="segundoPeriodo" style="display: none">
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end"> SEGUNDO PERIODO DE VACACIONES DESDE</label>
                <div class="col-md-6">
                    <input type="date" id="segundoPeriodo1" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <label for="to" class="col-md-4 col-form-label text-md-end"> SEGUNDO PERIODO DE VACACIONES HASTA</label>
                <div class="col-md-6">
                    <input type="date" onchange="segundoPeriodoValueF()" id="segundoPeriodo2" class="form-control">
                </div>
            </div>
        </div>
        <script>
            function segundoPeriodoValue(){
                return document.getElementById('segundoPeriodo1').value + " | " + document.getElementById('segundoPeriodo2').value;
            }
        </script>
        <input type="hidden" name="vacaciones2" id="segundoPeriodoValue">


        <div id="tercerPeriodo" style="display: none">
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end"> TERCER PERIODO DE VACACIONES DESDE</label>
                <div class="col-md-6">
                    <input type="date" id="tercerPeriodo1" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <label for="to" class="col-md-4 col-form-label text-md-end"> TERCER PERIODO DE VACACIONES HASTA</label>
                <div class="col-md-6">
                    <input type="date" onchange="tercerPeriodoValueF()" id="tercerPeriodo2" class="form-control">
                </div>
            </div>
        </div>
        <script>
            function tercerPeriodoValue(){
                return document.getElementById('tercerPeriodo1').value + " | " + document.getElementById('tercerPeriodo2').value;
            }
        </script>
        <input type="hidden" name="vacaciones3" id="tercerPeriodoValue">




        <div id="cuartoPeriodo" style="display: none">
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end"> CUARTO PERIODO DE VACACIONES DESDE</label>
                <div class="col-md-6">
                    <input type="date" id="cuartoPeriodo1" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <label for="to" class="col-md-4 col-form-label text-md-end"> CUARTO PERIODO DE VACACIONES HASTA</label>
                <div class="col-md-6">
                    <input type="date" onchange="cuartoPeriodoValueF()" id="cuartoPeriodo2" class="form-control">
                </div>
            </div>
        </div>
        <script>
            function cuartoPeriodoValue(){
                return document.getElementById('cuartoPeriodo1').value + " | " + document.getElementById('cuartoPeriodo2').value;
            }
        </script>
        <input type="hidden" name="vacaciones4" id="cuartoPeriodoValue">


        <div id="quintoPeriodo" style="display: none">
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end"> QUINTO PERIODO DE VACACIONES DESDE</label>
                <div class="col-md-6">
                    <input type="date" id="quintoPeriodo1" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <label for="to" class="col-md-4 col-form-label text-md-end"> QUINTO PERIODO DE VACACIONES HASTA</label>
                <div class="col-md-6">
                    <input type="date" onchange="quintoPeriodoValueF()" id="quintoPeriodo2" class="form-control">
                </div>
            </div>
        </div>
        <script>
            function quintoPeriodoValue(){
                return document.getElementById('quintoPeriodo1').value + " | " + document.getElementById('quintoPeriodo2').value;
            }
        </script>
        <input type="hidden" name="vacaciones5" id="quintoPeriodoValue">


        <div id="sextoPeriodo" style="display: none">
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end"> SEXTO PERIODO DE VACACIONES DESDE</label>
                <div class="col-md-6">
                    <input type="date" id="sextoPeriodo1" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <label for="to" class="col-md-4 col-form-label text-md-end"> SEXTO PERIODO DE VACACIONES HASTA</label>
                <div class="col-md-6">
                    <input type="date" onchange="sextoPeriodoValueF()" id="sextoPeriodo2" class="form-control">
                </div>
            </div>
        </div>
        <script>
            function sextoPeriodoValue(){
                return document.getElementById('sextoPeriodo1').value + " | " + document.getElementById('sextoPeriodo2').value;
            }
        </script>
        <input type="hidden" name="vacaciones6" id="sextoPeriodoValue">


        <div id="septimoPeriodo" style="display: none">
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end"> SÉPTIMO PERIODO DE VACACIONES DESDE</label>
                <div class="col-md-6">
                    <input type="date" id="septimoPeriodo1" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <label for="to" class="col-md-4 col-form-label text-md-end"> SÉPTIMO PERIODO DE VACACIONES HASTA</label>
                <div class="col-md-6">
                    <input type="date" onchange="septimoPeriodoValueF()"id="septimoPeriodo2" class="form-control">
                </div>
            </div>
        </div>
        <script>
            function septimoPeriodoValue(){
                return document.getElementById('septimoPeriodo1').value + " | " + document.getElementById('septimoPeriodo2').value;
            }
        </script>
        <input type="hidden" name="vacaciones7" id="septimoPeriodoValue">



        <div id="octavoPeriodo" style="display: none">
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end"> OCTAVO PERIODO DE VACACIONES DESDE</label>
                <div class="col-md-6">
                    <input type="date" id="octavoPeriodo1" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <label for="to" class="col-md-4 col-form-label text-md-end"> OCTAVO PERIODO DE VACACIONES HASTA</label>
                <div class="col-md-6">
                    <input type="date" onchange="octavoPeriodoValueF()" id="octavoPeriodo2" class="form-control">
                </div>
            </div>
        </div>
        <script>
        function octavoPeriodoValue(){
            return document.getElementById('octavoPeriodo1').value + " | " + document.getElementById('octavoPeriodo2').value;
        }
        </script>
        <input type="hidden" name="vacaciones8" id="octavoPeriodoValue">



        <div id="novenoPeriodo" style="display: none">
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end"> NOVENO PERIODO DE VACACIONES DESDE</label>
                <div class="col-md-6">
                    <input type="date" id="novenoPeriodo1" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <label for="to" class="col-md-4 col-form-label text-md-end"> NOVENO PERIODO DE VACACIONES HASTA</label>
                <div class="col-md-6">
                    <input type="date" onchange="novenoPeriodoValueF()" id="novenoPeriodo2" class="form-control">
                </div>
            </div>
        </div>
        <script>
            function novenoPeriodoValue(){
                return document.getElementById('novenoPeriodo1').value + " | " + document.getElementById('novenoPeriodo2').value;
            }
        </script>
        <input type="hidden" name="vacaciones9" id="novenoPeriodoValue">


        <div id="decimoPeriodo" style="display: none">
            <div class="row mb-3">
                <label class="col-md-4 col-form-label text-md-end"> DÉCIMO PERIODO DE VACACIONES DESDE</label>
                <div class="col-md-6">
                    <input type="date"  id="decimoPeriodo1" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <label for="to" class="col-md-4 col-form-label text-md-end"> DÉCIMO PERIODO DE VACACIONES HASTA</label>
                <div class="col-md-6">
                    <input type="date" onchange="decimoPeriodoValueF()"  id="decimoPeriodo2" class="form-control">
                </div>
            </div>
        </div>
        <script>
            function decimoPeriodoValue(){
                return document.getElementById('decimoPeriodo1').value + " | " + document.getElementById('decimoPeriodo2').value;
            }
        </script>
        <input type="hidden" name="vacaciones10" id="decimoPeriodoValue">


        <div class="row mb-3" id="seccionForm">
            <label for="seccion" class="col-md-4 col-form-label text-md-end">{{ __('SECCIÓN') }}</label>
            <div class="col-md-6">
                <select  class="col-md-4 col-form-label form-select" name="seccion"   data-live-search="true">
                    @if($user->seccion == "TORAX")
                    <option value="TORAX" selected>TORAX</option>
                    <option value="ABDOMEN">ABDOMEN</option>
                    <option value="MUSCULOESQUELÉTICO">MUSCULOESQUELÉTICO</option>
                    <option value="URGENCIAS">URGENCIAS</option>
                    <option value="NEURORADIOLOGÍA">NEURORADIOLOGÍA</option>
                    <option value="MAMA">MAMA</option>
                    <option value="PEDIATRÍA">PEDIATRÍA</option>
                    @elseif($user->seccion == "ABDOMEN")
                    <option value="TORAX">TORAX</option>
                    <option value="ABDOMEN" selected>ABDOMEN</option>
                    <option value="MUSCULOESQUELÉTICO">MUSCULOESQUELÉTICO</option>
                    <option value="URGENCIAS">URGENCIAS</option>
                    <option value="NEURORADIOLOGÍA">NEURORADIOLOGÍA</option>
                    <option value="MAMA">MAMA</option>
                    <option value="PEDIATRÍA">PEDIATRÍA</option>
                    @elseif($user->seccion == "MUSCULOESQUELÉTICO")
                        <option value="TORAX">TORAX</option>
                        <option value="ABDOMEN">ABDOMEN</option>
                        <option value="MUSCULOESQUELÉTICO" selected>MUSCULOESQUELÉTICO</option>
                        <option value="URGENCIAS">URGENCIAS</option>
                        <option value="NEURORADIOLOGÍA">NEURORADIOLOGÍA</option>
                        <option value="MAMA">MAMA</option>
                        <option value="PEDIATRÍA">PEDIATRÍA</option>
                    @elseif($user->seccion == "URGENCIAS")
                        <option value="TORAX">TORAX</option>
                        <option value="ABDOMEN">ABDOMEN</option>
                        <option value="MUSCULOESQUELÉTICO">MUSCULOESQUELÉTICO</option>
                        <option value="URGENCIAS" selected>URGENCIAS</option>
                        <option value="NEURORADIOLOGÍA">NEURORADIOLOGÍA</option>
                        <option value="MAMA">MAMA</option>
                        <option value="PEDIATRÍA">PEDIATRÍA</option>
                    @elseif($user->seccion == "NEURORADIOLOGÍA")
                        <option value="TORAX">TORAX</option>
                        <option value="ABDOMEN">ABDOMEN</option>
                        <option value="MUSCULOESQUELÉTICO">MUSCULOESQUELÉTICO</option>
                        <option value="URGENCIAS">URGENCIAS</option>
                        <option value="NEURORADIOLOGÍA" selected>NEURORADIOLOGÍA</option>
                        <option value="MAMA">MAMA</option>
                        <option value="PEDIATRÍA">PEDIATRÍA</option>
                    @elseif($user->seccion == "PEDIATRÍA")
                        <option value="TORAX">TORAX</option>
                        <option value="ABDOMEN">ABDOMEN</option>
                        <option value="MUSCULOESQUELÉTICO">MUSCULOESQUELÉTICO</option>
                        <option value="URGENCIAS">URGENCIAS</option>
                        <option value="NEURORADIOLOGÍA">NEURORADIOLOGÍA</option>
                        <option value="MAMA">MAMA</option>
                        <option value="PEDIATRÍA" selected>PEDIATRÍA</option>
                    @elseif($user->seccion == "MAMA")
                        <option value="TORAX">TORAX</option>
                        <option value="ABDOMEN">ABDOMEN</option>
                        <option value="MUSCULOESQUELÉTICO">MUSCULOESQUELÉTICO</option>
                        <option value="URGENCIAS">URGENCIAS</option>
                        <option value="NEURORADIOLOGÍA">NEURORADIOLOGÍA</option>
                        <option value="MAMA" selected>MAMA</option>
                        <option value="PEDIATRÍA" >PEDIATRÍA</option>
                     @else
                        <option value="TORAX">TORAX</option>
                        <option value="ABDOMEN">ABDOMEN</option>
                        <option value="MUSCULOESQUELÉTICO">MUSCULOESQUELÉTICO</option>
                        <option value="URGENCIAS">URGENCIAS</option>
                        <option value="NEURORADIOLOGÍA">NEURORADIOLOGÍA</option>
                        <option value="MAMA">MAMA</option>
                        <option value="PEDIATRÍA" >PEDIATRÍA</option>
                    @endif
                </select>                @error('seccion')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="row mb-3"  id="jornadaForm">
            <label for="jornada" class="col-md-4 col-form-label text-md-end">{{ __('JORNADA') }}</label>
            <div class="col-md-6">
                {{ Form::text('jornada', $user->jornada, ['class' => 'form-control' . ($errors->has('jornada') ? ' is-invalid' : ''), 'placeholder' => 'Jornada', 'title' => 'PORCENTAJE DE TRABAJO EFECTIVO']) }}
                @error('jornada')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>



    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">ACEPTAR</button>
    </div>
</div>

<script>
    function primerPeriodoValueF(){
        document.getElementById('primerPeriodoValue').value = document.getElementById('primerPeriodo1').value + " | " + document.getElementById('primerPeriodo2').value;
    }

    function segundoPeriodoValueF(){
        document.getElementById('segundoPeriodoValue').value = document.getElementById('segundoPeriodo1').value + " | " + document.getElementById('segundoPeriodo2').value;
    }

    function tercerPeriodoValueF(){
        document.getElementById('tercerPeriodoValue').value = document.getElementById('tercerPeriodo1').value + " | " + document.getElementById('tercerPeriodo2').value;
    }

    function cuartoPeriodoValueF(){
        document.getElementById('cuartoPeriodoValue').value = document.getElementById('cuartoPeriodo1').value + " | " + document.getElementById('cuartoPeriodo2').value;
    }

    function quintoPeriodoValueF(){
        document.getElementById('quintoPeriodoValue').value = document.getElementById('quintoPeriodo1').value + " | " + document.getElementById('quintoPeriodo2').value;
    }

    function sextoPeriodoValueF(){
        document.getElementById('sextoPeriodoValue').value = document.getElementById('sextoPeriodo1').value + " | " + document.getElementById('sextoPeriodo2').value;
    }

    function septimoPeriodoValueF(){
        document.getElementById('septimoPeriodoValue').value = document.getElementById('septimoPeriodo1').value + " | " + document.getElementById('septimoPeriodo2').value;
    }

    function octavoPeriodoValueF(){
        document.getElementById('octavoPeriodoValueF').value = document.getElementById('octavoPeriodo1').value + " | " + document.getElementById('octavoPeriodo2').value;
    }

    function novenoPeriodoValueF(){
        document.getElementById('novenoPeriodoValueF').value = document.getElementById('novenoPeriodo1').value + " | " + document.getElementById('novenoPeriodo2').value;
    }

    function decimoPeriodoValueF(){
        document.getElementById('decimoPeriodoValueF').value = document.getElementById('decimoPeriodo1').value + " | " + document.getElementById('decimoPeriodo2').value;
    }


</script>

