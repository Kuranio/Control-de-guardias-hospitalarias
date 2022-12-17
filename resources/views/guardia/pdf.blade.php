<?php
use Carbon\Carbon;
use App\Models\User;
use App\Models\Guardia;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }
        table{
            font-size: x-small;
        }
        tfoot tr td{
            font-weight: bold;
            font-size: x-small;
        }
    </style>

</head>
<body>

<table width="100%">
    <tr>
        <td valign="top"><img src="https://www3.gobiernodecanarias.org/sanidad/scs/images/SCS_logo_texBajo.jpg" alt="" width="150"/></td>
    </tr>
    <tr>
        <td align="center">
            <h3>CONTROL DE GUARDIAS DEL SERVICIO DE RADIOLOGÍA</h3>

           
            <h3>GENERADO EL {{mb_strtoupper(Carbon::now()->isoFormat('dddd D \d\e MMMM \d\e\l YYYY')),'utf-8'}}</h3>
        </td>
    </tr>

</table>

<br/>

<table width="100%">
    <thead style="background-color: lightgray;">
    <tr>
        <th>#</th>
        <th>FECHA</th>
        <th>NOMBRE Y APELLIDOS</th>
        <th>DNI</th>

        <th>DONDE</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($guardias as $guardia)
        <?php

        $diaActual = Carbon::parse($guardia->fecha)->isoFormat('dddd D \d\e MMMM YYYY');
        $mes = Carbon::parse($guardia->fecha)->isoFormat('MMMM');
        $año = Carbon::parse($guardia->fecha)->isoFormat('YYYY');

        ?>
        @if(((strpos($diaActual, " 1 de") != false)or(strpos($diaActual, " 15 de enero") != false)) and ($guardia->donde == "MATERNO"))
            <tr style="font-weight: bold; text-align: center">
                <td colspan="5" style="border-top: 5px solid black; border-bottom: 5px solid black; background-color:black; color: white">{{ strtoupper($mes)}} | {{$año}}</td>
            </tr>
        @endif
        @if($guardia->donde == "REFUERZO")
            <tr>
                <td  style="border-bottom: 2px dotted black">{{ $guardia->id }}</td>
                @if($guardia->dni == "FESTIVO")
                    <td style="background-color: white; color: red; font-weight: bold; border-bottom: 2px dotted black;" >{{ ucfirst($diaActual) }}</td>
                    <td style="background-color: white; color: red; font-weight: bold;text-align:right; border-bottom: 2px dotted black;">FESTIVO PENDIENTE DE ASIGNAR</td>
                    <td style="border-bottom: 2px dotted black;"></td>
                    <td style="text-align: right;  border-bottom: 2px dotted black;">{{ $guardia->donde }}</td>


                @else

                    <td style="border-bottom: 2px dotted black">{{ ucfirst($diaActual) }}</td>
                    <?php
                    foreach (User::all() as $cadaUsuario) {
                    ?>
                    @if($cadaUsuario->dni == $guardia->dni)
                        <td style="border-bottom: 2px dotted black">{{$cadaUsuario->apellidos}}, {{ $cadaUsuario->nombre }}</td>
                    @endif
                    <?php
                    }
                    ?>
                    <td style="border-bottom: 2px dotted black">{{ $guardia->dni }}</td>
                    <td style="border-bottom: 2px dotted black; text-align: right">{{ $guardia->donde }}</td>



                @endif
            </tr>
        @else
            <tr>
                <td>{{ $guardia->id }}</td>
                @if($guardia->dni == "FESTIVO")
                    <td style="background-color: white; color: red; font-weight: bold;">{{ ucfirst($diaActual) }}</td>
                    <td style="background-color: white; color: red; font-weight: bold;text-align:right;">FESTIVO PENDIENTE DE ASIGNAR</td>
                    <td></td>
                    <td style="text-align: right">{{ $guardia->donde }}</td>


                @else

                    <td>{{ ucfirst($diaActual) }}</td>
                    <?php
                    foreach (User::all() as $cadaUsuario) {
                    ?>
                    @if($cadaUsuario->dni == $guardia->dni)
                        <td>{{$cadaUsuario->apellidos}}, {{ $cadaUsuario->nombre }}</td>
                    @endif
                    <?php
                    }
                    ?>
                    <td>{{ $guardia->dni }}</td>


                    <td style="text-align: right">{{ $guardia->donde }}</td>



                @endif
            </tr>
    @endif
    @endforeach
</table>
</body>
</html>
