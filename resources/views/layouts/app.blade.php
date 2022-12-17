
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://kit.fontawesome.com/2586d19f1c.js" crossorigin="anonymous"></script>    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Control de guardias hospitalarias</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app-blade.css') }}" rel="stylesheet">

</head>
<style>
    .nav-item a{
        font-weight: bold;
        border-bottom: 2px solid white;
        border-top: 2px solid darkslategray;
        text-align: center;
    }
    .nav-item{
        margin-left: 1.5rem;
        margin-right: 1.5rem;
    }
    .nav-item a:hover{
        border-top: 2px solid white;
    }@media (min-width: 1400px) {
  .container-xxl, .container-xl, .container-lg, .container-md, .container-sm, .container {
    max-width: 1800px;
  }
}


</style>
<body>
@if(!Auth::guest())
    @if(Session::get('dataUser')->is_admin == '1')
        <nav class="navbar navbar-expand-md justify-content-md-center justify-content-start">
            <ul class="navbar-nav mx-auto text-md-center text-left">
                @if(Session::get('dataUser')->haceGuardias == '1')
                <li class="nav-item">
                    <a class="nav-link" href="/home">CALENDARIO</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="/users">USUARIOS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/guardias">GUARDIAS</a>
                </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/festivos">FESTIVOS</a>
                    </li>
                <li class="nav-item">
                    <a class="nav-link" href="/change-password">CAMBIAR CONTRASEÑA</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://drive.google.com/uc?export=download&id=1kysiMlZ5vKExrweSUNfR7tTLgp9HvpPu">DESCARGAR MANUAL</a>
                </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">CERRAR SESIÓN</a>
                    </li>
            </ul>
        </nav>
    @else
        <nav class="navbar navbar-expand-md justify-content-md-center justify-content-start">
            <ul class="navbar-nav mx-auto text-md-center text-left">
                @if(Session::get('dataUser')->haceGuardias == '1')
                    <li class="nav-item">
                        <a class="nav-link" href="/home">CALENDARIO</a>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link" href="/change-password">CAMBIAR CONTRASEÑA</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/logout">CERRAR SESIÓN</a>
                </li>
            </ul>
        </nav>
    @endif
@endif
<div class="container">
    @yield('content')
</div>

<footer>
    <p class="fw-bold">C.G.H |
            <span id="day">day</span>
            <span id="daynum">00</span> de
            <span id="month">month</span> de
            <span id="year">0000</span> |
        <span class="display-time"></span>
    </p>
</footer>


</body>

</html>
<script>
    const displayTime = document.querySelector(".display-time");
    // Time
    function showTime() {
        let time = new Date();
        displayTime.innerText = time.toLocaleTimeString("es-ES", { hour12: false });
        setTimeout(showTime, 1000);
    }

    showTime();

    // Date
    function updateDate() {
        let today = new Date();

        // return number
        let dayName = today.getDay(),
            dayNum = today.getDate(),
            month = today.getMonth(),
            year = today.getFullYear();

        const months = [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre",
        ];
        const dayWeek = [
            "Domingo",
            "Lunes",
            "Martes",
            "Miércoles",
            "Jueves",
            "Viernes",
            "Sábado",
        ];
        // value -> ID of the html element
        const IDCollection = ["day", "daynum", "month", "year"];
        // return value array with number as a index
        const val = [dayWeek[dayName], dayNum, months[month], year];
        for (let i = 0; i < IDCollection.length; i++) {
            document.getElementById(IDCollection[i]).firstChild.nodeValue = val[i];
        }
    }

    updateDate();

</script>
