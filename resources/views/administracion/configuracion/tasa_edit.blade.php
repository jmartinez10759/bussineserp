<div class="" id="modal_add_register" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Registro de Tasas </h3>
            </div>
            <div class="modal-body">
                    <form class="form-horizontal">
                        

                        <div class="form-group">
                            <label class="control-label col-sm-3">Rango:  </label>
                            <div class="col-sm-7">
                                <input type="text" id="rango" class="form-control" placeholder="" ng-model="insert.rango">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Valor Minimo: <font size="3" color="red">* </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="valor_minimo" class="form-control" placeholder="" ng-model="insert.valor_minimo">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Valor Maximo: <font size="3" color="red">* </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="valor_maximo" class="form-control" placeholder="" ng-model="insert.valor_maximo">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Clave:  </label>
                            <div class="col-sm-7">
                                <input type="text" id="clave" class="form-control" placeholder="" ng-model="insert.clave">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Factor:  </label>
                            <div class="col-sm-7">
                                <input type="text" id="factor" class="form-control" placeholder="" ng-model="insert.factor">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Trasladado:  </label>
                            <div class="col-sm-7">
                                <input type="text" id="trasladado" class="form-control" placeholder="" ng-model="insert.trasladado">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Retencion:  </label>
                            <div class="col-sm-7">
                                <input type="text" id="retencion" class="form-control" placeholder="" ng-model="insert.retencion">
                            </div>

                        </div>
                        <div class="form-group">
                        <label  class="col-sm-3 control-label input-sm">Fecha Inicio </label>
                <div class="col-sm-7">
                    <input type="text" class="form-control fecha"  id="fecha_inicial" ng-model="insert.fecha_inicio_vigencia">
                </div>

                                           
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-3 control-label input-sm">Fecha Final </label>
                <div class="col-sm-7">
                    <input type="text" class="form-control fecha"  id="fecha_final" ng-model="insert.fecha_final_vigencia">
                </div> 
                        </div>

                        


                    </form>
                
                
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary" ng-click="insert_register()"><i class="fa fa-save"></i> Registrar </button> 
                </div>
            </div>

        </div>
    </div>
</div>
<div class="" id="modal_edit_register" style="display:none;">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Detalle de Tasas </h3>
            </div>
            <div class="modal-body">
                    <form class="form-horizontal">
                        

                        <div class="form-group">
                            <label class="control-label col-sm-3">Rango:  </label>
                            <div class="col-sm-7">
                                <input type="text" id="rango" class="form-control" placeholder="" ng-model="update.rango">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Valor Minimo: <font size="3" color="red">* </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="valor_minimo" class="form-control" placeholder="" ng-model="update.valor_minimo">
                            </div>
                            

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Valor Maximo: <font size="3" color="red">* </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="valor_maximo" class="form-control" placeholder="" ng-model="update.valor_maximo">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Clave:  </label>
                            <div class="col-sm-7">
                                <input type="text" id="clave" class="form-control" placeholder="" ng-model="update.clave">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Factor:  </label>
                            <div class="col-sm-7">
                                <input type="text" id="factor" class="form-control" placeholder="" ng-model="update.factor">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Trasladado:  </label>
                            <div class="col-sm-7">
                                <input type="text" id="trasladado" class="form-control" placeholder="" ng-model="update.trasladado">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Retencion:  </label>
                            <div class="col-sm-7">
                                <input type="text" id="retencion" class="form-control" placeholder="" ng-model="update.retencion">
                            </div>

                        </div>
                        <div class="form-group">
                        <label  class="col-sm-3 control-label input-sm">Fecha Inicio </label>
                <div class="col-sm-7">
                    <input type="text" class="form-control fecha"  id="fecha_inicial" ng-model="update.fecha_inicio_vigencia">
                </div>

                                           
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-3 control-label input-sm">Fecha Final </label>
                <div class="col-sm-7">
                    <input type="text" class="form-control fecha"  id="fecha_final" ng-model="update.fecha_final_vigencia">
                </div> 
                        </div>

                        



                    </form>

                </div>
                <div class="modal-footer">
                    <div class="btn-toolbar pull-right">
                        <button type= "button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">
                            <i class="fa fa-times-circle"></i> Cancelar
                        </button>
                        <button type="button" class="btn btn-info" ng-click="update_register()" {{$update}}>
                        <i class="fa fa-save"></i> Actualizar 
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- <div class="modal fade" id="modal_tiposComprobantes_register" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                    </button>
                    <h3>Asignacion de Tipos de Comprobantes</h3>
                </div>

                <div class="modal-body panel-body">
                        {!! $data_table!!}
                </div>  
                </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                    
                    {!! $button_insertar !!}
                </div>
            </div>

        </div>
    </div>
</div> --}}