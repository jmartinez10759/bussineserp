<div  id="modal_add_register" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Registro Servicios Comerciales </h3>
            </div>
            <div class="modal-body">
             <form class="form-horizontal">
                        

                        <div class="form-group">
                            <label for="product_code" class="col-sm-3 control-label">Nombre:</label>
                                        <div class="col-sm-7">
                                            {{-- Recibe la informacion que se ingresa dentro del cuadro de entrada y la asigna a la variable a la que se hace referencia--}}
                                            <input type="text" class="form-control" placeholder="Ingrese Nombre del servicio" ng-model="insert.nombre" >
                                        </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Descripción:  </font> </label>
                            <div class="col-sm-7">
                               <textarea id="descripcion" class="form-control" placeholder="" ng-model="insert.descripcion"></textarea>
                            </div> 
                        </div>
              </form>             
                
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    {{-- Sirve para cerrar el formulario --}}
                    <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                    {{-- Mediante el boton llama a la funcion insert_register() para insertar un nuevo registro en la base de datos --}}
                    <button type="button" class="btn btn-primary" ng-click="insert_register()"><i class="fa fa-save"></i> Registrar </button> 
                </div>
            </div>

        </div>
    </div>
    
</div>

<div id="modal_edit_register" style="display:none;">
    
            <div class="modal-header">
                <h3> Detalles Servicios Comerciales </h3>
            </div>
                <div class="modal-body">
                   <form class="form-horizontal">
                        <div class="form-group">
                            <label for="product_code" class="col-sm-3 control-label">Nombre:</label>
                            <div class="col-sm-7">
                                {{-- Recibe la informacion que tiene almacenado el cuadro de entrada y permite modificarla, se le asigna a la variable a la que se hace referencia--}}
                                <input type="text" class="form-control" placeholder="Ingrese Nombre del servicio" ng-model="edit.nombre" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Descripción:  </font> </label>
                            <div class="col-sm-7">
                                {{-- Se utilizo un textarea para que al momento de su insercion o edicion no haya dificultad de visualizacion con la informacion --}}
                               <textarea id="descripcion" class="form-control" placeholder="" ng-model="edit.descripcion"></textarea>
                            </div> 
                        </div>
                    </form>                
                    
                </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                    {{-- Mediante el boton llama a la funcion update_register() para actualizar los cambios que se le hayan echo al registro --}}
                    <button type="button" class="btn btn-primary" ng-click="update_register()"><i class="fa fa-save"></i> Actualizar </button> 
                </div>
            </div>
        
    
</div>