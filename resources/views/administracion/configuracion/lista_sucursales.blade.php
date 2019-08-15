<!DOCTYPE html>
<html lang="en">
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <!-- obtengo la ruta de mi proyecto -->
      <meta name="ruta-general" content="{{ $_SERVER['PHP_SELF'] }}">

      <link rel="icon" href="{{asset('img/login/favicon.ico')}}" type="image/x-icon" />
      <link rel="shortcut icon" href="{{asset('img/login/favicon.ico')}}" type="image/x-icon" />

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
            /* html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            } */

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
        </style>

    </head>
    <body>
        <!-- <div class="flex-center position-ref full-height"> -->
        <div class="top-right links">
            @if (Session::get('id'))
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">
              <i class="fa fa-sign-out pull-right"></i>Cerrar Sesion
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> {{ csrf_field() }} </form>
            <!-- <a href="#" class="btn btn-default btn-flat">Sign out</a> -->
            @endif
        </div>

          <div class="container " id="vue-sucursales">
               <div class="row">
                   <div class="col-sm-offset-0 col-sm-12 table-responsive">
                       <br>
                       <center><h2>LISTADO DE SUCURSALES </h2></center>
                       <br>
                      <div id="table_sucursales"></div>
                   </div>
               </div>

               <!-- <div class="row" id="content_sucusales" style="display:none;">
                   <div class="col-sm-offset-0 col-sm-12 table-responsive">
                       <br>
                       <center><h2>Listado de Sucursales </h2></center>
                       <br>
                      <div id="table_sucursales"></div>
                   </div>
               </div> -->

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
        <script type="text/javascript" src="{{asset('js/TitleSystem.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/administrador/configuracion/build_list_sucursales.js')}}"></script>
    </body>
</html>
