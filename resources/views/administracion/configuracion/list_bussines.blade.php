<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <!-- obtengo la ruta de mi proyecto -->
      <meta name="ruta-general" content="{{ $_SERVER['PHP_SELF'] }}">
      <link rel="icon" href="{{asset('img/login/buro_laboral.ico')}}" type="image/x-icon" />
      <link rel="shortcut icon" href="{{asset('img/login/buro_laboral.ico')}}" type="image/x-icon" />
        <title>Listado de empresas</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!--css -->
        <link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap.css')}}" />
        <link type="text/css" rel="stylesheet" href="{{asset('css/sweetalert.css')}}" />
        <link type="text/css" rel="stylesheet" href="{{asset('css/toastr.css')}}" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" />
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
          [v-cloak]{display: none}
          [ng-cloak]{display: none}

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .sombra::-webkit-box-shadow: -12px 22px 23px 3px rgba(201,201,201,1);
            .sombra::-moz-box-shadow: -12px 22px 23px 3px rgba(201,201,201,1);
            /*.sombra::box-shadow: -12px 22px 23px 3px rgba(201,201,201,1);*/

        </style>

    </head>
    <body>
        <!-- <div class="flex-center position-ref full-height"> -->
        <div class="top-right links">
            @if (Session::get('id'))
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-warning btn-lg">
              <i class="fa fa-sign-out pull-right"></i>Cerrar Sesion
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> {{ csrf_field() }} </form>
            <!-- <a href="#" class="btn btn-default btn-flat">Sign out</a> -->
            @endif
        </div>

          <div class="container " id="vue-business" v-cloak>
               <div class="row" id="content_empresas">
                     <br>
                     <center><h2> {{ $titulo }} </h2></center>
                     <br>
                  <div class="sombra">
                      hola
                  </div>

                   <div class="col-sm-offset-0 col-sm-12 table-responsive">

                          <table class="table table-hover " id="table_empresas">
                              <thead style="background-color: #337ab7; color: #ffffff;">
                                <tr>
                                    <th>#</th>
                                    <th>EMPRESA</th>
                                    <th>RFC</th>
                                    <th>RAZÓN SOCIAL</th>
                                    <th>GIRO COMERCIAL</th>
                                    <th></th>
                                </tr>
                              </thead>
                              <tbody>
                                  <tr v-for="(empresas,key) in datos" title="Selecciona una Empresa" style="cursor:pointer" >
                                    <td v-on:click.prevent="bussiness_sucursales( empresas.id )">@{{ empresas.id }}</td>
                                    <td v-on:click.prevent="bussiness_sucursales( empresas.id )">@{{ empresas.nombre_comercial }}</td>
                                    <td v-on:click.prevent="bussiness_sucursales( empresas.id )">@{{ empresas.rfc_emisor }}</td>
                                    <td v-on:click.prevent="bussiness_sucursales( empresas.id )">@{{ empresas.razon_social }}</td>
                                    <td v-on:click.prevent="bussiness_sucursales( empresas.id )">@{{ empresas.giro_comercial }}</td>
                                    <td></td>
                                  </tr>
                              </tbody>
                          </table>

                   </div>
               </div>

               <div class="row" id="content_sucusales" style="display:none;">
                   <br>
                   <center><h2>{{$titulo_sucusales}}</h2></center>
                   <br>
                   <div class="col-sm-offset-0 col-sm-12 table-responsive">

                      <table class="table table-hover " id="table_sucursales">
                          <thead style="background-color: #337ab7; color: #ffffff;">
                            <tr>
                                <th>#</th>
                                <th>CODIGO</th>
                                <th>SUCURSAL</th>
                                <th>DIRECCION</th>
                                <th>ESTATUS</th>
                                <th></th>
                            </tr>
                          </thead>
                          <tbody>
                              <tr v-for="(sucursales,key) in sucursal" title="Selecciona una Sucursal" style="cursor:pointer" >
                                <td v-on:click.prevent="portal( sucursales.id )">@{{ sucursales.id }}</td>
                                <td v-on:click.prevent="portal( sucursales.id )">@{{ sucursales.codigo }}</td>
                                <td v-on:click.prevent="portal( sucursales.id )">@{{ sucursales.sucursal }}</td>
                                <td v-on:click.prevent="portal( sucursales.id )">@{{ sucursales.direccion }}</td>
                                <td v-on:click.prevent="portal( sucursales.id )">@{{ (sucursales.estatus == 1)? "Activo" :"Baja" }}</td>
                                <td></td>
                              </tr>
                          </tbody>
                      </table>


                   </div>
               </div>

           </div>

        <!-- </div> -->
        <!-- jQuery -->
        <script type="text/javascript" src="{{asset('templates/vendors/jquery/dist/jquery.min.js')}}"></script>
        <!-- Bootstrap -->
        <script type="text/javascript" src="{{asset('templates/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/axios.js')}}"></script>
      	<script type="text/javascript" src="{{asset('js/toastr.js')}}"></script>
      	<script type="text/javascript" src="{{asset('js/vue.js')}}"></script>
      	<script type="text/javascript" src="{{asset('js/sweetalert.js')}}"></script>
      	<script type="text/javascript" src="{{asset('js/global.system.js')}}"></script>
      	<script type="text/javascript" src="{{asset('js/tools-manager.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
      	<!-- script master vue -->
        <script type="text/javascript" src="{{asset('js/master_vue.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/master_script.js')}}"></script>
        <!-- script desarrollador -->
        <!--Se carga el script necesario de la lista de empresas-->
        <script type="text/javascript" src="{{asset('js/administracion/configuracion/build_business.js')}}"></script>
    </body>
</html>
