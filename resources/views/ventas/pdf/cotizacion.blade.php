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
        width: 200px;
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
            <th width="10%" align="left"><img src="{{ asset('img/header_buro_laboral.jpeg') }}" alt="" width="80" height="60"></th>
            <th width="60%" align="center">Buro Laboral México <br> a.clientes@burolaboralmexico.com <br>5535355435</th>
            <th width="15%" align="center" class="border">Cotización <br> Nº 234567<span class="text"></span></th>
        </tr>
    </table><br>
    <table ><tr><td width="14%" align="right"><strong>Fecha: 2018-10-12</strong></td></tr></table>
        <table width="100%" class="tabla2">
            <tr>
                <td width="10%">Contacto:</td>
                <td width="50%" class="linea"><span class="text">{{$data['foo']}}</span></td>
                <td width="5%">&nbsp;</td>
                <td width="13%">&nbsp;</td>
                <td width="4%">&nbsp;</td>
                <!-- <td width="1%" align="center" class=""><strong>Fecha: 2018-10-12</strong></td> -->
            </tr>
            <tr>
                <td>Empresa:</td>
                <td class="linea"><span class="text"></span></td>
                <td>Telefono:</td>
                <td width="4%" class="linea"><span class="text"></span></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>Correo:</td>
                <td class="linea"><span class="text"></span></td>
                <td>&nbsp;</td>
            </tr>
        </table>
        <table width="100%" class="tabla3">
            <tr>
                <td align="center" class="fondo"><strong>CANT.</strong></td>
                <td align="center" class="fondo"><strong>DESCRIPCIÓN</strong></td>
                <td align="center" class="fondo"><strong>P. UNITARIO</strong></td>
                <td align="center" class="fondo"><strong>IMPORTE</strong></td>
            </tr>
            
            <tr>
                <td width="7%">&nbsp;ddd</td>
                <td width="59%">&nbsp;de4de</td>
                <td width="16%">&nbsp;dede</td>
                <td width="18%" align="left">&nbsp;dede</td>
            </tr>

            <tr>
                <td style="border:0;">&nbsp;</td>
                <td style="border:0;">&nbsp;</td>
                <td align="right"><strong>SUBTOTAL</strong></td>
                <td align="right"><span class="text"></span></td>
            </tr>
            <tr>
                <td style="border:0;">&nbsp;</td>
                <td style="border:0;">&nbsp;</td>
                <td align="right"><strong>IVA</strong></td>
                <td align="right"><span class="text"></span></td>
            </tr>
            <tr>
                <td style="border:0;">&nbsp;</td>
                <td style="border:0;">&nbsp;</td>
                <td align="right"><strong>TOTAL</strong></td>
                <td align="right"><span class="text"></span></td>
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
                            <td align="center" style="border:0;">Forma de pago:</td>
                        </tr>
                        <tr>
                            <td align="center" style="border:0;">Metodo de pago:</td>
                        </tr>
                        <!-- <tr>
                            <td align="center" style="border:0;">CANCELADO</td>
                            <td style="border:0;">&nbsp;</td>
                        </tr> -->
                    </table> <br>
        <table width="100%" class="tabla3">
                        <tr>
                            <td align="center" class="cancelado">Vendedor</td>
                            <td style="border:0;">&nbsp;</td>
                            <td align="center" class="cancelado">Cotizado</td>
                            <td style="border:0;">&nbsp;</td>
                            <td align="center" class="cancelado">Aceptado cliente</td>
                        </tr>
                    </table> 
    </div>
</body>
</html>