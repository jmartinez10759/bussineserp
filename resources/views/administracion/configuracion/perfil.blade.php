@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<!-- Main content -->
<section class="content vue-perfil">

  <div class="row">
    <div class="col-md-3">

      <!-- Profile Image -->
      <div class="box box-primary">
        <div class="box-body box-profile">
          <img class="profile-user-img img-responsive img-circle" :src="datos.foto" alt="Foto de Perfil">
          <h3 class="profile-username text-center">@{{datos.name}}</h3>

          <p class="text-muted text-center">@{{datos.puesto}}</p>

          <ul class="list-group list-group-unbordered">
            <li class="list-group-item">
              <b>Telefono</b> <a class="pull-right">@{{datos.telefono}}</a>
            </li>
            <li class="list-group-item">
              <b>Genero</b> <a class="pull-right">@{{datos.genero}}</a>
            </li>
            <li class="list-group-item">
              <b>Estado Civil</b> <a class="pull-right">@{{datos.estado_civil}}</a>
            </li>
          </ul>

          <!-- <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a> -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

      <!-- About Me Box -->
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Acerca de Mi</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <strong><i class="fa fa-book margin-r-5"></i> Experiencia</strong>

          <p class="text-muted">
            @{{datos.experiencia}}
          </p>

          <hr>

          <strong><i class="fa fa-map-marker margin-r-5"></i> Direccion</strong>

          <p class="text-muted">@{{datos.direccion}}</p>

          <hr>

          <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

          <p>
            <span v-for="habilidates in datos.skills" class="label label-info">@{{habilidates.skills}} @{{habilidates.porcentaje}}%</span>
            <!-- <span class="label label-success">Coding</span>
            <span class="label label-danger">Javascript</span>
            <span class="label label-warning">PHP</span>
            <span class="label label-primary">Node.js</span> -->
          </p>

          <hr>

          <strong><i class="fa fa-file-text-o margin-r-5"></i> Notas </strong>

          <p>@{{datos.notas}}</p>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li><a href="#activity" data-toggle="tab">Actividad</a></li>
          <li><a href="#timeline" data-toggle="tab">Linea de Tiempo</a></li>
          <li class="active"><a href="#settings" data-toggle="tab">Edicion</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane" id="activity">

          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="timeline">
            <!-- The timeline -->
            <ul class="timeline timeline-inverse">
              <!-- timeline time label -->
              <li class="time-label">
                    <span class="bg-red">
                      10 Feb. 2014
                    </span>
              </li>
              <!-- /.timeline-label -->
              <!-- timeline item -->
              <li>
                <i class="fa fa-envelope bg-blue"></i>

                <div class="timeline-item">
                  <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                  <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                  <div class="timeline-body">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                    weebly ning heekya handango imeem plugg dopplr jibjab, movity
                    jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                    quora plaxo ideeli hulu weebly balihoo...
                  </div>
                  <div class="timeline-footer">
                    <a class="btn btn-primary btn-xs">Read more</a>
                    <a class="btn btn-danger btn-xs">Delete</a>
                  </div>
                </div>
              </li>
              <!-- END timeline item -->
              <!-- timeline item -->
              <li>
                <i class="fa fa-user bg-aqua"></i>

                <div class="timeline-item">
                  <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>

                  <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request
                  </h3>
                </div>
              </li>
              <!-- END timeline item -->
              <!-- timeline item -->
              <li>
                <i class="fa fa-comments bg-yellow"></i>

                <div class="timeline-item">
                  <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>

                  <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                  <div class="timeline-body">
                    Take me to your leader!
                    Switzerland is small and neutral!
                    We are more like Germany, ambitious and misunderstood!
                  </div>
                  <div class="timeline-footer">
                    <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                  </div>
                </div>
              </li>
              <!-- END timeline item -->
              <!-- timeline time label -->
              <li class="time-label">
                    <span class="bg-green">
                      3 Jan. 2014
                    </span>
              </li>
              <!-- /.timeline-label -->
              <!-- timeline item -->
              <li>
                <i class="fa fa-camera bg-purple"></i>

                <div class="timeline-item">
                  <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>

                  <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                  <div class="timeline-body">
                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                    <img src="http://placehold.it/150x100" alt="..." class="margin">
                  </div>
                </div>
              </li>
              <!-- END timeline item -->
              <li>
                <i class="fa fa-clock-o bg-gray"></i>
              </li>
            </ul>
          </div>
          <!-- /.tab-pane -->

          <div class="active tab-pane" id="settings">

              <form class="form-horizontal">
                  <div class="row">

                      <div class="col-sm-4">
                        <label>Nombre Completo</label>
                        <input type="text" class="form-control" id="name" v-model="datos.name" style="text-transform: uppercase;" placeholder="Nombre Completo">
                      </div>

                      <div class="col-sm-4">
                        <label>Correo Electronico</label>
                        <input type="email" class="form-control" id="correo" v-model="datos.email" placeholder="Correo Electronico" disabled>
                      </div>

                      <div class="col-sm-4">
                        <label>Contraseña</label>
                        <input type="password" class="form-control" id="contraseña" v-model="newKeep.contraseña" >
                      </div>

                      <div class="col-sm-3">
                        <label>Telefono</label>
                        <input type="text" class="form-control" id="telefono" v-model="datos.telefono" placeholder="Lada + 10 digitos">
                      </div>

                      <div class="col-sm-6">
                        <label>Direccion</label>
                        <input type="text" class="form-control" id="direccion" v-model="datos.direccion" placeholder="Ingrese Direccion">
                      </div>

                      <div class="col-sm-3">
                        <label>Genero</label>
                        <select class="form-control" id="genero" v-model="datos.genero">
                          <option value="Masculino">Masculino</option>
                          <option value="Femenino">Femenino</option>
                        </select>
                      </div>

                      <div class="col-sm-4">
                        <label>Estado Civil</label>
                        <select class="form-control" id="estado_civil" v-model="datos.estado_civil">
                            <option value="soltero">Soltero</option>
                            <option value="casado">Casado</option>
                            <option value="separado">Separado</option>
                            <option value="divorciado">Divorciado</option>
                        </select>
                      </div>

                      <div class="col-sm-4">
                        <label>Puesto</label>
                        <input type="text" class="form-control" id="puesto" v-model="datos.puesto" placeholder="Ingrese Puesto">
                      </div>

                      <div class="col-sm-4">
                        <label>Experiencia</label>
                        <textarea class="form-control" id="experiencia" v-model="datos.experiencia"></textarea>
                      </div>

                      <div class="col-sm-4">
                        <label>Notas</label>
                        <textarea class="form-control" id="notas" v-model="datos.notas"></textarea>
                      </div>

                        <div class="col-sm-4">
                          <label>Subir Foto Perfil</label>
                          <div id="div_dropzone_file"></div>
                        </div>
                        <br><br><br><br>
                      <!-- <div class="form-group"> -->
                        <div class="col-sm-offset-10 col-sm-2">
                          <button type="button" class="btn btn-success" v-on:click.prevent="save_perfil()" {{$insertar}}><i class="fa fa-save"></i> Guardar</button>
                        </div>
                      <!-- </div> -->
                  </div>
            </form>


          </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div>
      <!-- /.nav-tabs-custom -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

</section>
<!-- /.content -->

@stop
@push('scripts')
  <script type="text/javascript" src="{{asset('js/administracion/configuracion/build_perfil.js')}}" ></script>
  <script type="text/javascript">
      var upload_url = domain('perfiles/upload');
      var ids = {
        div_content  : 'div_dropzone_file'
        ,div_dropzone : 'dropzone_xlsx_file'
        ,file_name    : 'file'
      };
      var message = "Dar Clic aquí o arrastrar archivo";
      upload_file('',upload_url,message,1,ids,'.jpg,.png,.jpeg',function( request ){
          console.log(request);
      });
  </script>
@endpush
