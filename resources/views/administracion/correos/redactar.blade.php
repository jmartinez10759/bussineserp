@extends('layouts.template.app')
@section('content')
<!-- iCheck -->
<link rel="stylesheet" href="{{asset('admintle/plugins/iCheck/flat/blue.css')}}">
@push('styles')
<!-- Main content -->
<section class="content" ng-app="appication" ng-controller="CorreosController" ng-init="constructor()" ng-cloak>
  <div class="row">
    <div class="col-md-3">
      <a href="{{route('correos.recibidos')}}" class="btn btn-primary btn-block margin-bottom " >Regresar a Recibidos</a>

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
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="box-body no-padding">
            <ul class="nav nav-pills nav-stacked">
              <!-- <li><a href="#"><i class="fa fa-circle-o text-red"></i> Important</a></li>
              <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> Promotions</a></li> -->
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
          <h3 class="box-title">Redactar Nuevo Mensaje</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="form-group">
            <input type="text"class="form-control" placeholder="Para:" ng-model="insert.emisor">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Asunto:" ng-model="insert.asunto">
          </div>
          <div class="form-group">
                <textarea class="form-control compose-textarea" style="height: 300px" ng-bind-html-unsafe="insert.descripcion">
                  <!-- <h1><u>Heading Of Message</u></h1>
                  <h4>Subheading</h4>
                  <p>But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain
                    was born and I will give you a complete account of the system, and expound the actual teachings
                    of the great explorer of the truth, the master-builder of human happiness. No one rejects,
                    dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know
                    how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again
                    is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain,
                    but because occasionally circumstances occur in which toil and pain can procure him some great
                    pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise,
                    except to obtain some advantage from it? But who has any right to find fault with a man who
                    chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that
                    produces no resultant pleasure? On the other hand, we denounce with righteous indignation and
                    dislike men who are so beguiled and demoralized by the charms of pleasure of the moment, so
                    blinded by desire, that they cannot foresee</p>
                  <ul>
                    <li>List item one</li>
                    <li>List item two</li>
                    <li>List item three</li>
                    <li>List item four</li>
                  </ul>
                  <p>Thank you,</p>
                  <p>John Doe</p> -->
                </textarea>
          </div>
          <div class="form-group">
            <div class="btn btn-default btn-file">
              <i class="fa fa-paperclip"></i> Attachment
              <input type="file" name="attachment" multiple >
            </div>
            <p class="help-block">Max. 32MB</p>
          </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <div class="pull-right">
            <div class="col-sm-6">
              <button type="button" class="btn btn-default">
                  <i class="fa fa-pencil"></i> Borrador
              </button>
              
            </div>
            <div class="col-sm-6">
              <button type="button" class="btn btn-primary" {{$email}}  ng-click="send_correo()">
                <i class="fa fa-envelope-o"></i> Enviar
              </button>
            </div>
          </div>
          <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Descartar</button>
        </div>
        <!-- /.box-footer -->
      </div>
      <!-- /. box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->
@stop
@push('scripts')
  <!-- iCheck -->
  <script src="{{asset('admintle/plugins/iCheck/icheck.min.js')}}"></script>

  <script type="text/javascript" src="{{asset('js/administracion/correos/build_correos.js')}}" ></script>
  <script type="text/javascript">
    jQuery(".compose-textarea").wysihtml5();
  </script>
  <!-- <script>
    jQuery('.btn-papelera').attr('disabled',false);
    //Add text editor
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
