<!DOCTYPE html>
<html>
<head>
    <title>BOLETA DE VENTA</title>
    <style type="text/css">
    body{
        font-size: 16px;
        font-family: "Arial";
    }
    table{
        border-collapse: collapse;
    }
    td{
        padding: 6px 5px;
        font-size: 14px;
    }
    .h1{
        font-size: 21px;
        font-weight: bold;
    }
    .h2{
        font-size: 18px;
        font-weight: bold;
    }
    .tabla1{
        margin-bottom: 20px;
    }
    .tabla2 {
        margin-bottom: 20px;
    }
    .tabla3{
        margin-top: 15px;
    }
    .tabla3 td{
        border: 1px solid #000;
    }
    .tabla3 .cancelado{
        border-left: 0;
        border-right: 0;
        border-bottom: 0;
        border-top: 1px dotted #000;
        width: 280px;
        /*width: 200px;*/
    }
    .emisor{
        color: red;
    }
    .linea{
        border-bottom: 1px dotted #000;
    }
    .border{
        border: 1px solid orange;
    }
    .fondo{
        background-color: #dfdfdf;
    }
    .fisico{
        color: #fff;
    }
    .fisico td{
        color: #fff;
    }
    .fisico .border{
        border: 1px solid #fff;
    }
    .fisico .tabla3 td{
        border: 1px solid #fff;
    }
    .fisico .linea{
        border-bottom: 1px dotted #fff;
    }
    .fisico .emisor{
        color: #fff;
    }
    .fisico .tabla3 .cancelado{
        border-top: 1px dotted #fff;
    }
    .fisico .text{
        color: #000;
    }
    .fisico .fondo{
        background-color: #fff;
    }
 
 
    #logo{
        display: none;
    }


</style>
</head>
<body>
    <div class="">
    <table class="tg">
        <tr>
            <th width="12%" align="left"><img src="{{ $data['logo'] }}" alt="" width="100" height="100"></th>
            <th width="65%" align="center">{{ $data['datos'][0]->razon_em }} <br> {{ $data['datos'][0]->calle_em }} {{ $data['datos'][0]->col_em }}<br>{{ $data['datos'][0]->tel_em }}</th>
            <th width="15%" align="center" class="border">Cotización <br> {{ $data['datos'][0]->id_cotizacion }}<span class="text"></span></th>
        </tr>
    </table><br>
    <table ><tr><td width="20%" align="right"><strong>Fecha: </strong>{{ $data['datos'][0]->fecha_alta }}</td></tr></table>
        <table width="100%" class="tabla2">
            <tr>
                <td width="10%">Empresa:</td>
                <td width="50%" class="linea"><span class="text">{{ $data['datos'][0]->empresa }}</span></td>
                <td width="5%">&nbsp;</td>
                <td width="13%">&nbsp;</td>
                <td width="4%">&nbsp;</td>
                <!-- <td width="1%" align="center" class=""><strong>Fecha: 2018-10-12</strong></td> -->
            </tr>
            <tr>
                <td width="10%">Contacto:</td>
                <td width="30%" class="linea"><span class="text">{{ $data['datos'][0]->contacto }}</span></td>
                <td width="15%">Telefono:</td>
                <td width="18%" class="linea"><span class="text">{{ $data['datos'][0]->telefono }}</span></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Correo:</td>
                <td class="linea"><span class="text">{{ $data['datos'][0]->correo }}</span></td>
                <td>&nbsp;</td>
            </tr>
        </table>
        <table width="100%" class="tabla3">
            <tr>
                <td align="center" class="fondo"><strong>CANT.</strong></td>
                <td align="center" class="fondo"><strong>DESCRIPCIÓN</strong></td>
                <td align="center" class="fondo"><strong>P. UNITARIO</strong></td>
                <td align="center" class="fondo"><strong>P. TOTAL</strong></td>
            </tr>
            @foreach($data['prod'] as $prod)
            <tr>
                <td width="7%" align="right">&nbsp;{{ $prod->cantidad }}</td>
                <td width="59%" align="justify">{{ (isset( $prod->descripcion ) && $prod->descripcion != "")? $prod->descripcion: $prod->prod_desc }}</td>
                <td width="16%" align="right">&nbsp;{{ $prod->precio }}</td>
                <td width="18%" align="right">&nbsp;{{ $prod->total }}</td>
            </tr>
            @endforeach
            <tr>
                <td style="border:0;">&nbsp;</td>
                <td style="border:0;">&nbsp;</td>
                <td align="right"><strong>SUBTOTAL</strong></td>
                <td align="right"><span class="text">{{ $data['totales']['subtotal'] }}</span></td>
            </tr>
            <tr>
                <td style="border:0;">&nbsp;</td>
                <td style="border:0;">&nbsp;</td>
                <td align="right"><strong>IVA</strong></td>
                <td align="right"><span class="text">{{ $data['totales']['iva'] }}</span></td>
            </tr>
            <tr>
                <td style="border:0;">&nbsp;</td>
                <td style="border:0;">&nbsp;</td>
                <td align="right"><strong>TOTAL</strong></td>
                <td align="right"><span class="text">{{ $data['totales']['total'] }}</span></td>
            </tr>
            <tr>
                    <!-- <table width="200" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="center" class="cancelado">CANCELADO</td>
                        </tr>
                    </table> -->
                </td>
                <!-- <td style="border:0;">&nbsp;</td>
                <td align="center" style="border:0;" class="emisor"><strong>EMISOR</strong></td> -->
            </tr>
        </table>
        <table width="100%" class="tabla3">
                        <tr>
                            <td align="center" style="border:0;"><strong>Forma de pago:</strong> {{ $data['datos'][0]->des_forma_p }}</td>
                        </tr>
                        <tr>
                            <td align="center" style="border:0;"><strong>Metodo de pago:</strong> {{ $data['datos'][0]->des_metod_p }}</td>
                        </tr>
                        <!-- <tr>
                            <td align="center" style="border:0;">CANCELADO</td>
                            <td style="border:0;">&nbsp;</td>
                        </tr> -->
                    </table>
        <table width="100%" class="tabla3">
        <tr>
                            <td align="center" style="border:0;">{{ $data['datos'][0]->vendedor }}</td>
                            <td style="border:0;">&nbsp;</td>
                            
                            <td align="center" style="border:0;">{{ $data['datos'][0]->contacto }}</td>
                        </tr>
                        <tr>
                            <td align="center" class="cancelado">Vendedor</td>
                            <td style="border:0;">&nbsp;</td>
                            <!-- <td style="border:0;">&nbsp;</td>
                            <td align="center" class="cancelado">Cotizado</td>
                            <td style="border:0;">&nbsp;</td> -->
                            <td align="center" class="cancelado">Cliente</td>
                        </tr>
                    </table> 
    </div>
</body>
</html>