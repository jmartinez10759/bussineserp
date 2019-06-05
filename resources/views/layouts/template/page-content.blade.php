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
                    
                        <input id="search_general" class="form-control" type="text" placeholder="Buscar" onkeyup="buscador_general(this,'{{ $buscador }}')" />
                    
                        {!! $modal !!}
                    </div>
                    

                </form>
            </div>

            <h4><i class='fa fa-tags'></i> {{ $title }} </h4>
        </div>

        <div class="panel-body">
            <!-- section of load -->
            <img class="loader"/>
            
            @yield('content')

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
                                <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div id="modal_notificaciones" class="modal fade">
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
            
            </div>

            
        </div>

    </div>

</section>
<!-- /.content