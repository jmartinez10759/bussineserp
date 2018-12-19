<div class="col-sm-12" id="modal_add_register" style="display:none;">
    <div class="modal-header">
        <h3> Registro de Prospectos </h3>
    </div>
    <div class="modal-body" style="overflow-y:scroll; height:500px;">
        <section class="content">
            <div class="row">
                <div class="col-sm-12">
                    <form class="form-horizontal">

                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">

                                <li class="active">
                                    <a href="#contactos" data-toggle="tab" aria-expanded="false">
                                        Detalles del Contacto
                                    </a>
                                </li>

                                <li class="">
                                    <a href="#detalles" data-toggle="tab" aria-expanded="false">
                                        Detalles de Facturación
                                    </a>
                                </li>

                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="contactos">

                                    <div class="row">
                                        
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="product_code" class="col-sm-4 control-label">Nombre: <font size="3" color="red">* </font></label>
                                                <div class="col-sm-8">
                                                    <div class="col-sm-3">
                                                        <select class="form-control"
                                                        chosen
                                                        width="'100%'"
                                                        ng-model="insert.id_study" 
                                                        ng-options="value.id as value.nombre for (key, value) in estudios">
                                                            <option value="">--Seleccione Opcion--</option>  
                                                        </select> 
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" placeholder="Ingrese Nombre de contacto" ng-model="insert.contacto" capitalize>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <label for="" class="col-sm-4 control-label">Cargo:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" placeholder="Ingrese Cargo en la empresa" ng-model="insert.cargo" capitalize >
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="col-sm-4 control-label">Correo:
                                                    <font size="3" color="red">* </font>
                                                </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" placeholder="Ingrese un correo valido" ng-model="insert.correo" >
                                                </div>   
                                            </div>

                                        </div>

                                        <div class="col-sm-6">
                                            
                                            <div class="form-group">
                                                <label for="" class="col-sm-4 control-label">Departamento:</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" placeholder="Ingrese departamento en la empresa" ng-model="insert.departamento" capitalize>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="col-sm-4 control-label">Teléfono: 
                                                    <font size="3" color="red">* </font>
                                                </label>
                                                <div class="col-sm-8">
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" placeholder="Lada + número" ng-model="insert.telefono" maxlength="15" onkeyup="numerico(this)">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control" placeholder="Ext." ng-model="insert.extension" maxlength="6" capitalize onkeyup="numerico(this)">
                                                        
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                        
                                        <div class="col-sm-12">
                                            <div class="btn-toolbar pull-right">
                                                <button type="button" class="btn btn-danger" data-fancybox-close> 
                                                    <i class="fa fa-times-circle"></i> Cancelar
                                                </button>
                                                <button type="button" class="btn btn-success" ng-click="insert_register_contacto()" {{ $insertar }}>
                                                    <i class="fa fa-save"></i> Registrar 
                                                </button>
                                            </div>
                                            
                                        </div>

                                    </div>

                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="detalles">

                                    <div class="row">

                                        <div class="col-sm-6">

                                            <div class="form-group">

                                                <label for="" class="col-sm-4 control-label">Razón Social: <font size="3" color="red">* </font></label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" placeholder="" ng-model="insert.razon_social" capitalize>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                
                                                <label for="" class="col-sm-4 control-label">Nombre Comercial: </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" placeholder="" ng-model="insert.nombre_comercial" capitalize>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                
                                                <label for="" class="col-sm-4 control-label">RFC: 
                                                    <font size="3" color="red">* </font> 
                                                </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" placeholder="" ng-model="insert.rfc_receptor" capitalize>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="col-sm-4 control-label">Calle y Número: </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" ng-model="insert.calle" capitalize>
                                                </div>
                                            </div>

                                            <div class="form-group">

                                                <label for="unidad_medida" class="col-sm-4 control-label">Colonia: </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control .uppercase" placeholder="" ng-model="insert.colonia" capitalize>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-sm-6">
                                            
                                            <div class="form-group">
                                                <label for="" class="col-sm-4 control-label">Alcaldía/ Municipio: </label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control .uppercase" placeholder="" ng-model="insert.municipio" capitalize>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="iva" class="col-sm-4 control-label">Pais: </label>
                                                <div class="col-sm-8">
                                                    <select class="form-control"
                                                    chosen
                                                    width="'100%'"
                                                    ng-change="select_estado()" 
                                                    ng-model="insert.id_country" 
                                                    ng-options="value.id as value.descripcion for (key, value) in datos.paises">
                                                    <option value="">--Seleccione Opcion--</option>  
                                                    </select>  
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="iva" class="col-sm-4 control-label">Estado: </label>
                                                <div class="col-sm-8">
                                                    <select class="form-control"
                                                    chosen
                                                    width="'100%'"
                                                    ng-change="select_codigos()" 
                                                    ng-model="insert.id_estado" 
                                                    ng-options="value.id as value.nombre for (key, value) in cmb_estados">
                                                        <option value="">--Seleccione Opcion--</option>  
                                                    </select>  
                                                </div>    
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="col-sm-4 control-label">Código Postal: </label>
                                                <div class="col-sm-8">
                                                    <select class="form-control"
                                                    chosen
                                                    width="'100%'"
                                                    ng-model="insert.id_codigo" 
                                                    ng-options="value.id as value.codigo_postal for (key, value) in cmb_codigos"> 
                                                        <option value="">--Seleccione Opcion--</option> 
                                                    </select>    
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="col-sm-4 control-label">Servicio Comercial: </label>
                                                <div class="col-sm-8">
                                                    <select class="form-control"
                                                    chosen
                                                    width="'100%'" 
                                                    ng-model="insert.id_servicio_comercial" 
                                                    ng-options="value.id as value.nombre for (key, value) in datos.servicio_comercial">
                                                        <option value="">--Seleccione Opcion--</option> 
                                                    </select>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                        <div class="col-sm-12">
                                            <div class="btn-toolbar pull-right">
                                                <button type="button" class="btn btn-danger" data-fancybox-close> 
                                                    <i class="fa fa-times-circle"></i> Cancelar
                                                </button>
                                                <button type="button" class="btn btn-success" ng-click="insert_register()" {{ $insertar }}>
                                                    <i class="fa fa-save"></i> Registrar 
                                                </button>
                                            </div>
                                            
                                        </div>

                                    </div>


                                   <!--  
                                    
                                    <div class="form-group">

                                        <label for="subtotal" class="col-sm-2 control-label">Uso CFDI: </label>
                                        <div class="col-sm-4">
                                            <select class="form-control select_chosen"
                                            chosen
                                            width="'100%'" 
                                            ng-model="insert.id_uso_cfdi" 
                                            ng-options="value.id as value.descripcion for (key, value) in datos.uso_cfdi">
                                                <option value="">--Seleccione Opcion--</option> 
                                            </select>
                                        </div>

                                        <label for="estatus" class="col-sm-2 control-label">Estatus</label>
                                        <div class="col-sm-4">
                                             <select class="form-control"
                                             chosen
                                             width="'100%'" 
                                             ng-model="insert.estatus" 
                                             ng-options="value.id as value.nombre for (key, value) in cmb_estatus"> 
                                            </select>
                                        </div>

                                    </div> -->

                                </div>
                                <!-- /.tab-pane -->



                            </div>
                            <!-- /.tab-content -->
                        </div>
                        <!-- /.nav-tabs-custom -->
                    </form>

                </div>
                <!-- /.col -->
            </div>

        </section>
    </div>

    <!-- <div class="modal-footer">
        <div class="btn-toolbar pull-right">
            <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
            <button type="button" class="btn btn-primary" ng-click="insert_register()" {{ $insertar }}><i class="fa fa-save"></i> Registrar </button>
        </div>
    </div> -->

</div>

<div id="modal_edit_register" class="modal fade">
    <div class="modal-dialog" style="width: 101%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Detalles del Cliente</h4>
            </div>
            <div class="modal-body" style="overflow-y:scroll; height:500px;">

                <section class="content">
                    <div class="row">
                        <div class="col-md-2">
                            <!-- Profile Image -->
                            <div class="box box-primary">
                                <center>
                                <div class="box-body box-profile drop-shadow">
                                    <div id="load_img" class="col-sm-12">
                                        <div id="imagen_edit"></div>
                                    </div>
                                    <input type="hidden" class="form-control" ng-model="update.logo">
                                </div>
                                </center>
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-10">
                            <form class="form-horizontal">

                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">

                                        <li class="active">
                                            <a href="#contactos_edit" data-toggle="tab" aria-expanded="false">
                                                Detalles del Contacto
                                            </a>
                                        </li>

                                        <li class="">
                                            <a href="#detalles_edit" data-toggle="tab" aria-expanded="false">
                                                Detalles de Facturación
                                            </a>
                                        </li>

                                        <li class="">
                                            <a href="#files_edit" data-toggle="tab" aria-expanded="false">
                                                Archivos
                                            </a>
                                        </li>

                                        <li class="">
                                            <a href="#activities_edit" data-toggle="tab" aria-expanded="false">
                                                Actividades
                                            </a>
                                        </li>



                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="contactos_edit" ng-dblclick="update_register_contacto(true)">
                                            <div class="row">
                                                
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="product_code" class="col-sm-3 control-label">Nombre: <font size="3" color="red">* </font></label>
                                                        <div class="col-sm-9">
                                                            <div class="col-sm-3">
                                                                <select class="form-control"
                                                                chosen
                                                                width="'100%'"
                                                                ng-model="update.id_study" 
                                                                ng-options="value.id as value.nombre for (key, value) in estudios">
                                                                    <option value="">--Seleccione Opcion--</option>  
                                                                </select> 
                                                            </div>
                                                            <div class="col-sm-9">
                                                                <input type="text" class="form-control" placeholder="Ingrese Nombre de contacto" ng-model="update.contacto" capitalize>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Cargo:</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" placeholder="Ingrese Cargo en la empresa" ng-model="update.cargo" capitalize >
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Correo:
                                                            <font size="3" color="red">* </font>
                                                        </label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" placeholder="Ingrese un correo valido" ng-model="update.correo" >
                                                        </div>   
                                                    </div>

                                                </div>

                                                <div class="col-sm-6">
                                                    
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Departamento:</label>
                                                        <div class="col-sm-7">
                                                            <input type="text" class="form-control" placeholder="Ingrese departamento en la empresa" ng-model="update.departamento" capitalize>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Teléfono: 
                                                            <font size="3" color="red">* </font>
                                                        </label>
                                                        <div class="col-sm-9">
                                                            <div class="col-sm-8">
                                                                <input type="text" class="form-control" placeholder="Lada + número" ng-model="update.telefono" maxlength="15" onkeyup="numerico(this)">
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <input type="text" class="form-control" placeholder="Ext." ng-model="update.extension" maxlength="6" capitalize onkeyup="numerico(this)">
                                                                
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                                
                                                <div class="col-sm-12">
                                                    <div class="btn-toolbar pull-right">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal"> 
                                                            <i class="fa fa-times-circle"></i> Cancelar
                                                        </button>
                                                        <button type="button" class="btn btn-primary" ng-click="update_register_contacto()" {{ $update }}>
                                                            <i class="fa fa-save"></i> Actualizar 
                                                        </button>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane" id="detalles_edit" ng-dblclick="update_register(1)">

                                            <div class="row">

                                                <div class="col-sm-6">

                                                    <div class="form-group">

                                                        <label for="" class="col-sm-4 control-label">Razón Social: <font size="3" color="red">* </font></label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" placeholder="" ng-model="update.razon_social" capitalize>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        
                                                        <label for="" class="col-sm-4 control-label">Nombre Comercial: </label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" placeholder="" ng-model="update.nombre_comercial" capitalize>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        
                                                        <label for="" class="col-sm-4 control-label">RFC: 
                                                            <font size="3" color="red">* </font> 
                                                        </label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" placeholder="" ng-model="update.rfc_receptor" capitalize>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="" class="col-sm-4 control-label">Calle y Número: </label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" ng-model="update.calle" capitalize>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">

                                                        <label for="unidad_medida" class="col-sm-4 control-label">Colonia: </label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control .uppercase" placeholder="" ng-model="update.colonia" capitalize>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">

                                                        <button type="button" class="btn btn-warning" ng-click="upload_file(1)" {{$upload}}>
                                                            <i class="fa fa-upload"></i> Subir Imagen  
                                                        </button>

                                                    </div>


                                                </div>

                                                <div class="col-sm-6">
                                                    
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-4 control-label">Alcaldía/ Municipio: </label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control .uppercase" placeholder="" ng-model="update.municipio" capitalize>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="iva" class="col-sm-4 control-label">Pais: </label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control"
                                                            chosen
                                                            width="'100%'"
                                                            ng-change="select_estado()" 
                                                            ng-model="update.id_country" 
                                                            ng-options="value.id as value.descripcion for (key, value) in datos.paises">
                                                            <option value="">--Seleccione Opcion--</option>  
                                                            </select>  
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="iva" class="col-sm-4 control-label">Estado: </label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control"
                                                            chosen
                                                            width="'100%'"
                                                            ng-change="select_codigos()" 
                                                            ng-model="update.id_estado" 
                                                            ng-options="value.id as value.nombre for (key, value) in cmb_estados">
                                                                <option value="">--Seleccione Opcion--</option>  
                                                            </select>  
                                                        </div>    
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="" class="col-sm-4 control-label">Código Postal: </label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control"
                                                            chosen
                                                            width="'100%'"
                                                            ng-model="update.id_codigo" 
                                                            ng-options="value.id as value.codigo_postal for (key, value) in cmb_codigos"> 
                                                                <option value="">--Seleccione Opcion--</option> 
                                                            </select>    
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="" class="col-sm-4 control-label">Servicio Comercial: </label>
                                                        <div class="col-sm-8">
                                                            <select class="form-control"
                                                            chosen
                                                            width="'100%'" 
                                                            ng-model="update.id_servicio_comercial" 
                                                            ng-options="value.id as value.nombre for (key, value) in datos.servicio_comercial">
                                                                <option value="">--Seleccione Opcion--</option> 
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                
                                                <div class="col-sm-12">
                                                    <div class="btn-toolbar pull-right">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal"> 
                                                            <i class="fa fa-times-circle"></i> Cancelar
                                                        </button>
                                                        <button type="button" class="btn btn-primary" ng-click="update_register()" {{$update}}>
                                                            <i class="fa fa-save"></i> Actualizar 
                                                        </button>
                                                    </div>
                                                    
                                                </div>

                                            </div>

                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane" id="files_edit">
                                            <h1>Listado de archivos</h1>
                                            <div class="row">
                                                
                                                <ul>
                                                    <li ng-repeat="files in archivos">
                                                        <a href="@{{files.ruta_archivo}}" target="_blank"> @{{files.ruta_archivo}} </a>
                                                    </li>
                                                </ul>


                                                <div class="col-sm-12">
                                                    <div class="btn-toolbar pull-right">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal"> 
                                                            <i class="fa fa-times-circle"></i> Cerrar
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="tab-pane" id="activities_edit">
                                            <div class="row ">
                                                <div class="pull-right">
                                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_see_activities" data-backdrop="static" data-keyboard="false">
                                                        <i class="fa fa-plus-circle"></i> Agregar
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="row" style="overflow-y:scroll; height:300px;"> 
                                                <div class="drop-shadows" ng-repeat="comentarios in list_comments">
                                                    <div class="col-sm-2">
                                                        <span class="label label-success">
                                                            @{{ comentarios.usuarios[0].name +" "+ comentarios.usuarios[0].first_surname }}
                                                        </span><br>
                                                        <span class="label label-info">
                                                            @{{ comentarios.roles[0].perfil }}
                                                        </span>
                                                    </div>

                                                    <div class="col-sm-5"> 
                                                        <strong>@{{ comentarios.titulo }}</strong> 
                                                        <p style="">@{{ comentarios.descripcion }}</p>
                                                    </div>

                                                    <div class="col-sm-2"> 
                                                        <small>
                                                            <i class="fa fa-clock-o"></i> 
                                                            Hace @{{ time_fechas( comentarios.created_at ) }} 
                                                        </small>
                                                    </div>
                                                    <div class="col-sm-1 pull-right"> 
                                                        <button type="button" class="btn btn-danger btn-sm" ng-click="destroy_comment(comentarios.id)" title="Borrar Comentario">
                                                            <i class="glyphicon glyphicon-trash"></i>
                                                        </button>
                                                    </div>
                                                        
                                                </div>
                                            </div>


                                        </div>
                                        


                                    </div>
                                    <!-- /.tab-content -->
                                </div>
                                <!-- /.nav-tabs-custom -->
                            </form>

                        </div>
                        <!-- /.col -->
                    </div>
                </section>

            </div>
            
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button> -->
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>

        </div>
    </div>
</div>




<div class="" id="permisos" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Asigne Sucursales </h3>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_empresa">
                <input type="hidden" id="id_cliente">
                <div id="sucursal_empresa"></div>
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close>
                        <i class="fa fa-times-circle"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-primary" ng-click="insert_permisos()" {{$insertar}}>
                        <i class="fa fa-save"></i> Registrar 
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="" id="upload_file" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Subir Imagen </h3>
            </div>
            <div class="modal-body">
                <div id="div_dropzone_file_clientes"></div> 
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close>
                        <i class="fa fa-times-circle"></i> Cerrar
                    </button>
                    <!-- <button type="button" class="btn btn-primary" ng-click="insert_permisos()" {{$insertar}}>
                        <i class="fa fa-save"></i> Aceptar 
                    </button> -->
                </div>
            </div>

        </div>
    </div>
</div>


<div id="upload_files" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Subir Archivos</h4>
            </div>
            <div class="modal-body">
                <div id="div_dropzone_files_clientes"></div> 
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>

        </div>
    </div>
</div>


<div id="modal_see_activities" class="modal fade">

    <div class="modal-dialog" style="width: 60%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Crear Actividad</h4>
            </div>
            <div class="modal-body">
                
                <form class="form-horizontal">
                    
                    <div class="row">
                        <div class="col-sm-6">
                            
                            <div class="form-group">

                                <label for="" class="col-sm-4 control-label">Asunto: <font size="3" color="red">* </font></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" placeholder="" ng-model="activities.titulo" capitalize>
                                </div>
                            </div>

                            <!-- <div class="form-group">

                                <label for="" class="col-sm-4 control-label">Fecha y/o Hora: <font size="3" color="red">* </font></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" placeholder="" ng-model="activities.fecha_inicio" capitalize>
                                </div>
                            </div> -->

                            <div class="form-group">

                                <label for="" class="col-sm-4 control-label">Asignado a: <font size="3" color="red">* </font></label>
                                <div class="col-sm-8">
                                    <select class="form-control"
                                    chosen
                                    width="'100%'"
                                    ng-model="activities.id_users" 
                                    ng-options="value.id as value.name+' '+value.first_surname+' '+value.second_surname for (key, value) in datos.usuarios">
                                        <option value="">--Seleccione Opcion--</option>  
                                    </select> 
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-6">
                            
                            <div class="form-group">

                                <label for="" class="col-sm-4 control-label">Tipo de Tarea: </label>
                                <div class="col-sm-8">
                                    <select class="form-control"
                                    chosen
                                    width="'100%'"
                                    ng-model="activities.id_type_task" 
                                    ng-options="value.id as value.nombre for (key, value) in tasks">
                                        <option value="">--Seleccione Opcion--</option>  
                                    </select> 
                                </div>
                            </div>

                            <!-- <div class="form-group">

                                <label for="" class="col-sm-4 control-label">Fecha y/o Hora de Vencimiento: <font size="3" color="red">* </font></label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" placeholder="" ng-model="activities.fecha_final" capitalize>
                                </div>
                            </div> -->

                            <div class="form-group">

                                <label for="" class="col-sm-4 control-label">Actividad: <font size="3" color="red">* </font></label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" ng-model="activities.descripcion" capitalize rows="4"></textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                </form>


            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" ng-click="save_activities(true)">
                    <i class="fa fa-save"></i> Registrar
                </button>
            </div>

        </div>
    </div>
</div>