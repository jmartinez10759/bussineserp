<!-- Content Header (Page header) -->
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
                <div class="pull-right">
                    <form class="form-inline">
                        {!! $upload_files !!}
                        
                        <input id="search_general" class="form-control" type="text" placeholder="Buscar" aria-label="Search" onkeyup="buscador_general(this,'{{ $buscador }}')" />

                        {!! $modal !!}
                    </form>
                </div>
            </div>
            <h4><i class='fa fa-tags'></i> {{ $title }} </h4>
        </div>

        <div class="panel-body">

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
                            <!-- <button type="button" class="btn btn-primary"><i class="fa fa-save"></i> Aceptar </button> -->
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>

</section>
<!-- /.content -->