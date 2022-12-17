<?php
use Carbon\Carbon;
use App\Models\User;
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
        tfoot tr p{
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
            <h3>GENERADO EL {{mb_strtoupper(Carbon::now()->isoFormat('dddd D \d\e MMMM \d\e\l YYYY')),'utf-8'}}</h3>
        </td>
    </tr>

</table>


<table width="100%">
    <thead style="background-color: lightgray;">
    <tr>
        <th>GUARDIA Nº</th>
        <th>FECHA</th>

        <th>DONDE</th>

    </tr>
    </thead>
    <tbody>
    @foreach ($guardias as $guardia)
        @if((Session::get('dataUser')->dni == $guardia['dni']))
            <?php

            $diaActual = Carbon::parse($guardia->fecha)->isoFormat('dddd D \d\e MMMM YYYY');
            $mes = Carbon::parse($guardia->fecha)->isoFormat('MMMM');
            ?>
                <tr>
                    <td>{{ $guardia->id }}</td>
                    @if($guardia->dni != "FESTIVO")
                        <td >{{ ucfirst($diaActual) }}</td>
                        <td style="text-align: right">{{ $guardia->donde }}</td>
                        <tr>
                            <td style="border-top: 1px dotted black" colspan="3"></td>
                        </tr>
                    @endif
                </tr>
        @endif


    @endforeach
</table>


</body>
</html>
