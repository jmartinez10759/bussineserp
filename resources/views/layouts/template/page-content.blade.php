<!-- Content Header (Page header)  -->
<section class="content-header">
    <h1>
        {{ $page_title }}
        <small>{{ $title }}</small>
    </h1>
    <!-- <ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i> {{ $subtitle }}</a></li>
	    <li class="active">{{ $title }}</li>
	  </ol> -->
</section>

<!-- Main content -->
<section class="content">

    <div class="panel panel-primary">

        <div class="panel-heading">

            <div class="btn-group pull-right">
                <form class="form-inline" id="form_general">
                    <div class="row">
                        {!! $upload_files !!}

                        <div class="btn-group">
                            <input class="form-control" type="text" ng-model="searching" placeholder="Buscar">
                        </div>

                        <div class="btn-group" ng-if="permisos.AGR">
                            <button type = "button" class="btn btn-success" ng-click="modalShow()">
                               <i class="fa fa-plus-circle"></i> Agregar
                            </button>
                        </div>

                    </div>
                    

                </form>
            </div>

            <h4><i class='fa fa-tags'></i> {{ $title }} </h4>
        </div>

        <div class="panel-body">
            <!-- section loader -->
                <img class="loading" ng-show="loader"/>
            <!-- end section loader -->
            @yield('content')

            <div class="pull-right">
                <div ng-if="permisos.PER">
                    <button type="button" class="btn btn-default" title="Descargar PDF" ng-click="downloadReportPDF()">
                        <i class="fa fa-file-pdf-o"></i>
                    </button>
                    <button type="button" class="btn btn-default" title="Descargar EXL" ng-click="downloadReportEXL()">
                        <i class="fa fa-file-excel-o"></i>
                    </button>
                </div>
            </div>


            <div class="" id="seccion_upload" style="display:none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3>Cargar Catalogo</h3>
                        </div>
                        <div class="modal-body">
                            <div id="div_upload_catalogo"></div>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-toolbar pull-right">
                                <button type="button" class="btn btn-danger btn" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{--<div id="modal_notificaciones" class="modal fade">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title">Notificaciones</h4>
                      </div>
                      <div class="modal-body">
                          
                          <form class="form-horizontal">
                              
                              <div class="row">
                                  <div class="col-sm-8">
                                      
                                      <div class="form-group">

                                          <label for="" class="col-sm-4 control-label">Portal: </label>
                                          <div class="col-sm-8">
                                              <p ng-bind="update.portal"></p>
                                          </div>
                                      </div>

                                      <div class="form-group">

                                          <label for="" class="col-sm-4 control-label">Titulo: </label>
                                          <div class="col-sm-8">
                                              <p ng-bind="update.titulo"></p>
                                          </div>
                                      </div>

                                      <div class="form-group">

                                          <label for="" class="col-sm-4 control-label">Mensaje: </label>
                                          <p ng-bind="update.mensaje"></p>
                                      </div>
                                  </div>

                              </div>

                          </form>


                      </div>
                      
                      <div class="modal-footer">
                          <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button> -->
                          <button type="button" class="btn btn-success" ng-click="update_notify()">
                              <i class="fa fa-save"></i> Aceptar
                          </button>
                      </div>

                  </div>
              </div>
            
            </div>--}}

            
        </div>

    </div>

</section>
<!-- /.content