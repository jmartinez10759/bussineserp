
<center>
	<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
    	<tr>
        	<td align="center" valign="top" id="bodyCell">
            	<!-- BEGIN TEMPLATE // -->
            	<table border="0" cellpadding="0" cellspacing="0" id="templateContainer">

                	<tr>
                    	<td align="center" valign="top">
                        	<!-- BEGIN BODY // -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateBody">
                                <tr>
                                    <td valign="top" class="bodyContent" mc:edit="body_content">
                                        <h1>Contacto registrado en Overhaulin.mx</h1>
								<p>Recibido: <strong>{{ long_date(now()) }}?></strong></p>
									<ul>
										<li>Nombre: <strong><?=$data['Lead']['name'];?></strong></li>
										<li>Apellidos: <strong><?=$data['Lead']['surname'];?></strong></li>
										<li>Empresa: <?=($data['Lead']['company_name']!=''?$data['Lead']['company_name']:'No indicado');?></li>
										<li>Cargo: <?=($data['Lead']['position_name']!=''?$data['Lead']['position_name']:'No indicado');?></li>
										<p>Direcci&oacute;n</p>
										<hr />
										<li>Pais: <?=$data['Lead']['country_name'];?></li>
										<li>Calle: <?=$data['Lead']['street'];?></li>
										<li>N&uacute;mero externo: <?=$data['Lead']['external_number'];?></li>
										<li>N&uacute;mero interno: <?=$data['Lead']['internal_number'];?></li>
										<li>Colonia: <?=$data['Lead']['neighborhood'];?></li>
										<li>Estado: <?=$data['Lead']['state_name'];?></li>
										<li>Ciudad: <?=$data['Lead']['city'];?></li>
										<li>C&oacute;digo Postal: <?=$data['Lead']['postal_code'];?></li>
										<li>Tel&eacute;fono fijo: <?=$data['Lead']['phone_number'];?></li>
										<li>Tel&eacute;fono celular: <?=$data['Lead']['mobile'];?></li>
										<li>E-Mail: <a href="mailto:<?=$data['Lead']['email'];?>"><?=$data['Lead']['email'];?></a></li>
										<hr />
										<li>Marca: <?=$data['Lead']['marca'];?></li>
										<li>Modelo: <?=$data['Lead']['modelo'];?></li>
										<li>Año: <?=$data['Lead']['anio'];?></li>

									</ul>
									<h3>Mensaje:</h3>
									<div style="padding:10px;background-color:white;border-radius:4px;">
									<p><?=$data['Lead']['message'];?></p>
									</div>

                                    </td>
                                </tr>
                            </table>
                            <!-- // END BODY -->
                        </td>
                    </tr>
                </table>
                <!-- // END TEMPLATE -->
            </td>
        </tr>
    </table>
</center>
