@extends('layouts.template.app')
@section('content')
<!-- iCheck -->
<link rel="stylesheet" href="{{asset('admintle/plugins/iCheck/flat/blue.css')}}">
<style type="text/css">

</style>

@push('styles')

<!-- Content Wrapper. Contains page content -->
<div ng-app="application" ng-controller="CorreosController" ng-init="constructor()" ng-cloak >
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-md-3">
        <a href="{{ route('correos.redactar') }}" class="btn btn-primary btn-block margin-bottom" {{$email}} ng-click="remove_fiels()">Redactar</a>

        <div class="box box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">Folders</h3>

            <div class="box-tools">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="box-body no-padding">
            <ul class="nav nav-pills nav-stacked listado_correos">
              <li class="active">
                <a href="{{route('correos.recibidos')}}">
                  <i class="fa fa-inbox"></i> Recibidos
                  <span class="label label-success pull-right">@{{ datos.correo }}</span>
                </a>
              </li>

              <li>
                <a href="{{route('correos.envios')}}">
                  <i class="fa fa-envelope-o"></i> Enviados
                  <span class="label label-primary pull-right">@{{ datos.enviados }}</span>
                </a>
              </li>
              
              <li>
                <a href="{{route('destacados')}}">
                  <i class="fa fa-file-text-o"></i> Destacados
                  <span class="label label-info pull-right">@{{ datos.destacados }}</span>
                </a>
              </li>
              
              <li>
                <a href="">
                  <i class="fa fa-align-justify"></i> Borradores
                  <span class="label label-warning pull-right">@{{ datos.borradores }}</span>
                </a>
              </li>

              <li>
                <a href="{{route('papelera')}}">
                  <i class="fa fa-trash-o"></i> Papelera
                  <span class="label label-danger pull-right">@{{ datos.papelera }}</span>
                </a>
              </li>
            
            </ul>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /. box -->
        <div class="box box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">Categorias</h3>

            <div class="box-tools">
              <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_categorias" title="Agregar categoria"><i class="fa fa-plus-circle"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>

            </div>
          </div>
          <div class="box-body no-padding">
            <ul class="nav nav-pills nav-stacked">
              <!-- <li><a href="#"><i class="fa fa-circle-o text-red"></i> Important</a></li>
              <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> Promotions</a></li> -->
              <!-- seccion de categorias por usuarios -->
                <li>
                  <a style="cursor: pointer;">
                    <i class="fa fa-circle-o text-light-blue"></i>
                  </a>
                  </li>
              
            </ul>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
      <div class="col-md-9">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">{{ $titulo }}</h3>

            <div class="box-tools pull-right">
              <div class="has-feedback">
                <input type="text" class="form-control input-sm" placeholder="Search Mail">
                <span class="glyphicon glyphicon-search form-control-feedback"></span>
              </div>
            </div>
            <!-- /.box-tools -->
          </div>
          <!-- /.box-header -->
          <div class="box-body no-padding">
            <div class="mailbox-controls">
              <!-- Check all button -->
              <button type="button" class="btn btn-default btn-sm checkbox-toggle" ng-click="checkbox()">
                <i class="fa fa-square-o" ng-if="selections == 0"></i>
                <i class="fa fa-square" ng-if="selections == 1"></i>
              </button>
              <!-- <input type="checkbox" ng-model="checkbox" class="btn btn-default btn-sm"> -->
              <div class="btn-group">
                <button type="button" class="btn btn-default btn-sm btn-papelera" {{$eliminar}} ng-click="activity_register()" ><i class="fa fa-trash-o"></i>
                </button>
                <!-- <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button> -->
                <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_categorias" title="Agregar categoria">
                    <i class="fa fa-bars"></i>
                </button>
                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
              </div>
              <!-- /.btn-group -->
              <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
              <div class="pull-right">
                1-50/200
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                </div>
                <!-- /.btn-group -->
              </div>
              <!-- /.pull-right -->
            </div>
            <div class="table-responsive mailbox-messages">
              <table class="table table-hover table-striped" id="bandeja_correos">
                <tbody>
                  <tr ng-repeat="correo in datos.correos" ng-style="vistos_style(correo.estatus_vistos)" style="cursor: pointer;">
                      <td>
                        <input type="checkbox" ng-model="checkboxes[correo.id]" >
                      </td>
                      
                      <td class="mailbox-star" >
                        
                        <a style="cursor: pointer;" ng-if="correo.estatus_destacados == 1" ng-click="update_register(correo.id, {estatus_destacados : correo.estatus_destacados} )">
                          <i class="fa fa-star text-yellow"></i>
                        </a>
                        <a style="cursor: pointer;" ng-if="correo.estatus_destacados == 0" ng-click="update_register(correo.id, {estatus_destacados : correo.estatus_destacados})">
                            <i class="fa fa-star-o text-yellow"></i>
                        </a>

                      </td>

                      <td class="mailbox-name" ng-click="details_mails(correo)">
                        <small>@{{ correo.correo }}</small>
                      </td>
                  
                      <td class="mailbox-subject" ng-click="details_mails( correo )">
                        <small>@{{correo.asunto}}</small>
                      </td>
                  
                      <!-- <td class="mailbox-attachment" ng-click="details_mails(correo.id )">
                        <div ng-bind-html-unsafe="correo.descripcion.substring(0, 35)"></div>
                      </td> -->

                      <td class="mailbox-date" ng-click="details_mails( correo )">
                        <small>@{{ time_fechas( correo.created_at ) }}</small>
                      </td>
                  
                  <td class="">
                    <button type="button" class="btn btn-primary btn-sm" title="Responder Correo" ng-click="redactar(correo)">
                      <i class="fa fa-share"></i>
                    </button>
                  </td>

                  <td class="">
                    <button type="button" class="btn btn-warning btn-sm" title="Notas" ng-click="modal_show(correo.id)">
                      <i class="fa fa-edit"></i>
                    </button>
                  </td>

                  <td class="">
                    <button type="button" class="btn btn-danger btn-sm" title="Eliminar" ng-click="activity_register(correo.id,{estatus_papelera: correo.estatus_papelera }, true )" {{$eliminar}} >
                      <i class="fa fa-trash"></i>
                    </button>
                  </td>
                </tr>

                </tbody>
              </table>
              <!-- /.table -->
            </div>
            <!-- /.mail-box-messages -->
          </div>
          <!-- /.box-body -->
          <div class="box-footer no-padding">
            <div class="mailbox-controls">
              <!-- Check all button -->
              <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
              </button>
              <div class="btn-group">
                <button type="button" class="btn btn-default btn-sm btn-papelera" {{$eliminar}} ng-click="update_register()">
                  <i class="fa fa-trash-o"></i>
                </button>
                <button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_categorias" title="Agregar categoria"><i class="fa fa-bars"></i></button>
                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
              </div>
              <!-- /.btn-group -->
              <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
              <div class="pull-right">
                1-50/200
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                </div>
                <!-- /.btn-group -->
              </div>
              <!-- /.pull-right -->
            </div>
          </div>
        </div>
        <!-- /. box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->

  <!-- Modal -->
  <div id="modal_categorias" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Agregar Categoria</h4>
        </div>
        <div class="modal-body panel-body">

          <form action="" class="form-horizontal row-border panel panel-body">

						<div class="form-group">
							<div class="control-label">
								<label class="col-sm-3 control-label">{!! $campo_1 !!} <font color="red" size="3">*</font></label>
							</div>
							<div class="col-sm-7">
								<input type="text" class="form-control" v-model="newKeep.categoria">
							</div>
						</div>

						<div class="form-group">
							<div class="control-label">
								<label class="col-sm-3 control-label">{!!$campo_2!!} <font color="red" size="3">*</font></label>
							</div>
							<div class="col-sm-7">
								<!-- <input type="text" class="form-control" v-model="newKeep.description" style="text-transform: capitalize;"> -->
								<textarea class="form-control" v-model="newKeep.descripcion"></textarea>
							</div>
						</div>

					</form>

        </div>
        <div class="modal-footer">
          <button type= "button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i> Cancelar</button>
					<button type= "button" class="btn btn-primary" v-on:click.prevent="insert_categorias()" {{$insertar}} ><i class="fa fa-save"></i> Registrar </button>
        </div>
      </div>

    </div>
  </div>

  @include('administracion.correos.recibidos_modal')

</div>
<!-- /.content-wrapper -->





@stop
@push('scripts')
  <!-- iCheck -->
  <script src="{{asset('admintle/plugins/iCheck/icheck.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/administracion/correos/build_correos.js')}}" ></script>

<!--   <script>
    jQuery('.btn-papelera').attr('disabled',false);
    //Add text editor
    //jQuery("#compose-textarea").wysihtml5();
    jQuery(".compose-textarea").wysihtml5();
      //Date picker
      jQuery('#fecha').datepicker({
        autoclose: true
        ,format: "yyyy-mm-dd"
      })
      //Timepicker
      jQuery('#horario').timepicker({
        showInputs: false
      });
      //Enable iCheck plugin for checkboxes
      //iCheck for checkbox and radio inputs
      jQuery('.mailbox-messages input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue'
      });
      //Enable check and uncheck all functionality
      jQuery(".checkbox-toggle").click(function () {
        var clicks = jQuery(this).data('clicks');
        if (clicks) {
          //Uncheck all checkboxes
          jQuery(".mailbox-messages input[type='checkbox']").iCheck("uncheck");
          jQuery(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
          jQuery('.btn-papelera').attr('disabled',true);
        } else {
          //Check all checkboxes
          jQuery(".mailbox-messages input[type='checkbox']").iCheck("check");
          jQuery('.btn-papelera').attr('disabled',false);
          jQuery(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
        }
        jQuery(this).data("clicks", !clicks);
      });

      //Handle starring for glyphicon and font awesome
      jQuery(".mailbox-star").click(function (e) {
        e.preventDefault();
        //detect type
        var $this = jQuery(this).find("a > i");
        var glyph = $this.hasClass("glyphicon");
        var fa = $this.hasClass("fa");
        var id_correo = $this.attr('id_correo');
        var estatus_destacados;
        //se esta es 0 si no esta es 1
        if( $this.hasClass('fa-star') ){
          estatus_destacados = 0;
        }else{
          estatus_destacados = 1;
        }
        var fields = {'id': id_correo, 'estatus_destacados': estatus_destacados};
        var url = domain('correos/destacados');
        axios.post( url, fields , csrf_token ).then(response => {
            console.log( response.data.result );
            if( response.data.success == true ){
              //redirect(domain('correos/recibidos'));
              location.reload();
            }else{
              //toastr.error( response.data.message, "¡Bandeja de entrada Vacia !" );
            }
        }).catch(error => {
            toastr.error( error, expired );
        });

        //Switch states
        if (glyph) {
          $this.toggleClass("glyphicon-star");
          $this.toggleClass("glyphicon-star-empty");
        }

        if (fa) {
          $this.toggleClass("fa-star");
          $this.toggleClass("fa-star-o");
        }
      });

  </script> -->
@endpush
