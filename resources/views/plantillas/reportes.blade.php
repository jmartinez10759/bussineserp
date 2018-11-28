<!DOCTYPE html>
<html>
<head>
    <title>REPORTES</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
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
            margin-bottom: 0px;
        }
        .tabla2 {
            margin-bottom: 0px;
        }
        .tabla3{
            margin-top: 0px;
        }
        .tabla3 td{
            border: .1px solid #000;
            font-size: 12;
        }
        .tabla4 .cancelado{
            border-left: 0;
            border-right: 0;
            border-bottom: 0;
            border-top: .5px dotted #000;
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
            background-color:#eee
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

</style>
</head>
<body>
    <div class="">
        <table class="table table-hover">
            <tr>
                <th width="10%" align="left">
                    <img src="{{ (isset($empresas[0]))? $empresas[0]['logo'] : asset('img/login/company.png') }}" alt="" width="100" height="80">
                </th>
                
                <th width="75%" align="center">
                    {{ (isset($empresas[0]))? $empresas[0]['razon_social']: "" }}  
                    <br>{{ (isset($empresas[0]))? $empresas[0]['calle']." ".$empresas[0]['colonia'] : " " }}
                    <br>{{ (isset($empresas[0]))? $empresas[0]['telefono']:"" }}
                </th>
                <th width="15%" align="center" class="border">
                    <br> Nº {{ $id }} <span class="text"></span>
                </th>
            </tr>
        </table>
        <br>
        <table class="table table-hover">
            <tr>
                <td width="20%" align="right">
                    <strong>FECHA: </strong>
                    {{ date('Y-m-d',strtotime($created_at) ) }}
                </td>
            </tr>
        </table>
        <table width="100%" class="tabla2 table table-hover">
            <tr>
                <td width="10%">CLIENTE:</td>
                <td width="50%" class="linea">
                    <span class="text">{{ ($clientes != null )? $clientes['nombre_comercial']: "" }}</span>
                </td>
                <td width="5%">&nbsp;</td>
                <td width="13%">&nbsp;</td>
                <td width="4%">&nbsp;</td>
            </tr>
            <tr>
                <td width="10%">CONTACTO:</td>
                <td width="30%" class="linea">
                    <span class="text">{{ ($contactos != null)? $contactos['nombre_completo'] : "" }}</span>
                </td>
                <td width="15%">TELEFONO:</td>
                <td width="18%" class="linea">
                    <span class="text">{{ ($contactos != null)? $contactos['telefono'] : "" }}</span>
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>CORREO:</td>
                <td class="linea"><span class="text">{{ ($contactos != null)? $contactos['correo'] : "" }}</span></td>
                <td>&nbsp;</td>
            </tr>
        </table>

        <table width="100%" class="tabla3">
            <tr>
                <td align="center" class="fondo"><strong>CANT</strong></td>
                <td align="center" class="fondo"><strong>DESCRIPCIÓN</strong></td>
                <td align="center" class="fondo"><strong>PRECIO UNITARIO</strong></td>
                <td align="center" class="fondo"><strong>PRECIO TOTAL</strong></td>
            </tr>
            @foreach($conceptos as $concepto)
            <tr>
                <td width="7%" align="right">
                    &nbsp;{{ $concepto['cantidad'] }}
                </td>
                <td width="59%" align="justify">
                    {{ ($concepto['id_producto'] != null)? $concepto['productos']['descripcion'] : ""}}
                    {{ ($concepto['id_plan'] != null)? $concepto['planes']['descripcion'] : ""}}
                </td>
                <td width="16%" align="right">
                    &nbsp;{{ ($concepto['id_producto'] != null)? "$ ".number_format($concepto['productos']['subtotal'],2) : ""}}
                    &nbsp;{{ ($concepto['id_plan'] != null)? "$ ".number_format($concepto['planes']['subtotal'],2) : ""}}
                </td>
                <td width="18%" align="right">
                    &nbsp;{{ ($concepto['id_producto'] != null)? "$ ".number_format($concepto['total'],2) : ""}}
                    &nbsp;{{ ($concepto['id_plan'] != null)? "$ ".number_format($concepto['total'],2) : ""}}
                </td>
            </tr>
            @endforeach
            <tr>
                <td style="border:0;">&nbsp;</td>
                <td style="border:0;">&nbsp;</td>
                <td align="right"><strong>SUBTOTAL</strong></td>
                <td align="right"><span class="text">{{ "$ ".number_format($subtotal,2) }}</span></td>
            </tr>
            <tr>
                <td style="border:0;">&nbsp;</td>
                <td style="border:0;">&nbsp;</td>
                <td align="right"><strong>IVA</strong></td>
                <td align="right"><span class="text">{{ "$ ".number_format($iva,2) }}</span></td>
            </tr>
            <tr>
                <td style="border:0;">&nbsp;</td>
                <td style="border:0;">&nbsp;</td>
                <td align="right"><strong>TOTAL</strong></td>
                <td align="right"><span class="text">{{ "$ ".number_format($total,2) }}</span></td>
            </tr>

        </table>

        <table width="100%" class="tabla4">
            <tr>
                <td align="center" style="border:0;"><strong>FORMA DE PAGO:</strong> 
                    {{ ($formaspagos != null)? $formaspagos['descripcion'] : ""}}
                </td>
            </tr>
            <tr>
                <td align="center" style="border:0;"><strong>METODO DE PAGO:</strong> 
                    {{ ($metodospagos != null)? $metodospagos['descripcion'] : ""}}
                </td>
            </tr>
        </table>
        <table width="100%" class="tabla4">
            <tr>
                <td align="center" style="border:0;">
                    {{ (isset($usuarios[0])) ? $usuarios[0]['name']." ".$usuarios[0]['first_surname']." ".$usuarios[0]['second_surname'] : " " }}
                </td>
                <td style="border:0;">&nbsp;</td>
                <td align="center" style="border:0;">
                    {{ ($contactos != null)? $contactos['nombre_completo'] : "" }}
                </td>
            </tr>
            <tr>
                <td align="center" class="cancelado">VENDEDOR</td>
                <td style="border:0;">&nbsp;</td>
                <td align="center" class="cancelado">CLIENTE</td>
            </tr>
        </table> 
    </div>
</body>
</html>