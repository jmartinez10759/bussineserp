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
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!--css -->
        <link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap.css')}}" />
        <link type="text/css" rel="stylesheet" href="{{ asset('css/app-master.css')}}" />

        {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.css" />--}}
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset("admintle/bower_components/font-awesome/css/font-awesome.min.css")}}">
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
            .drop-shadow {
                position:relative;
                float:left;
                width:100%;
                padding:1em;
                margin:1em 2px 1em;
                background:#fff;
                cursor: pointer;
                
                -webkit-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3),0 0 40px rgba(0, 0, 0, 0.1) inset;
                -moz-box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
                box-shadow:0 1px 4px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;

                -webkit-transition:all .8s ease; /* Safari y Chrome */
                -moz-transition:all .8s ease; /* Firefox */
                -o-transition:all .8s ease; /* IE 9 */
                -ms-transition:all .8s ease; /* Opera */

            }
            .drop-shadow:hover{
              -webkit-transform:scale(1.10);
              -moz-transform:scale(1.10);
              -ms-transform:scale(1.10);
              -o-transform:scale(1.10);
              transform:scale(1.10);
            }
        </style>
    </head>
    <body ng-app="application" ng-controller="BussinesListController" ng-init="constructor()" ng-cloak>
        <div class="top-right col-sm-2">
            @if (Session::get('id'))
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-danger btn-lg" title="Cerrar Sesion">
              <i class="fa fa-sign-out pull-right"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> {{ csrf_field() }} </form>
            @endif
        </div>

          <div class="container">
               <div class="row" ng-show="company">
                     <br>
                     <center><h2> {{ $titulo }} </h2></center>
                     <br>

                  <div class="drop-shadow col-md-12" ng-repeat="company in datos" ng-click="BussinesGroup( company.id )" title="Selecciona Una Empresa" >
                      <div class="col-md-3">
                          <img :src="company.logo" width="100%" height="100%" ng-if="company.logo">
                      </div>
                      <div class="col-md-8">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-9">
                          <h3 ng-bind="company.razon_social"></h3>
                          <strong ng-bind="company.rfc_emisor"></strong>
                        </div>
                        <div class="col-sm-1"></div>
                      </div>
                      <div class="col-md-1">

                      </div>
                      
                  </div>
               </div>

              <!-- Modal -->
              <div class="modal fade" id="modal-group" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">

                              <table class="table table-hover">
                                  <thead style="background-color: #337ab7; color: #ffffff;">
                                  <tr>
                                      <th>#</th>
                                      <th>CODIGO</th>
                                      <th>GRUPO</th>
                                      <th>DIRECCION</th>
                                      <th>ESTATUS</th>
                                      <th></th>
                                  </tr>
                                  </thead>
                                  <tbody>
                                  <tr ng-repeat="groups in sucursales" title="Selecciona una Sucursal" style="cursor:pointer" >
                                      <td ng-click="beginPortal(groups.id)" ng-bind="groups.id"></td>
                                      <td ng-click="beginPortal(groups.id)" ng-bind="groups.codigo"></td>
                                      <td ng-click="beginPortal(groups.id)" ng-bind="groups.sucursal"></td>
                                      <td ng-click="beginPortal(groups.id)" ng-bind="groups.direccion"></td>
                                      <td ng-click="beginPortal(groups.id)" ng-bind="(groups.estatus == 1)? 'Activo' :'Baja' "></td>
                                      <td></td>
                                  </tr>
                                  </tbody>
                              </table>

                          </div>
                          <div class="modal-footer">
                          </div>
                      </div>
                  </div>
              </div>

           </div>

        <!-- </div> -->
        <!-- jQuery -->
        <script type="text/javascript" src="{{asset('templates/vendors/jquery/dist/jquery.min.js')}}"></script>
        <!-- Bootstrap -->
        <script type="text/javascript" src="{{asset('templates/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
      	<script type="text/javascript" src="{{asset('js/global.system.js')}}"></script>
      	<script type="text/javascript" src="{{asset('js/tools-manager.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
        <!-- angular -->
        <script type="text/javascript" src="{{asset('bower_components/angular/angular.js')}}"></script>
        <script type="text/javascript" src="{{asset('bower_components/angular-animate/angular-animate.js')}}"></script>
        <script type="text/javascript" src="{{asset('bower_components/angular-chosen-localytics/dist/angular-chosen.js')}}"></script>
        <script type="text/javascript" src="{{asset('bower_components/sweetalert2/dist/sweetalert2.js')}}"></script>
        <script type="text/javascript" src="{{asset('bower_components/ngSweetAlert2/SweetAlert.js')}}"></script>
        <script type="text/javascript" src="{{asset('bower_components/swangular/swangular.js')}}"></script>
        <script type="text/javascript" src="{{asset('bower_components/angular-toastr/dist/angular-toastr.tpls.js')}}"></script>
        <script type="text/javascript" src="{{asset('bower_components/dropzone/downloads/dropzone.min.js')}}"></script>
        <script type="text/javascript" src="{{asset('bower_components/angular-dropzone/lib/angular-dropzone.js')}}"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.5/angular-route.js"></script>

        <!-- script indispensables -->
        <script type="text/javascript" src="{{asset('js/master_vue.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/master_script.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/ModuleController.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/FactoryController.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/NotificationsFactory.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/ServiceController.js')}}"></script>
        <script type="text/javascript" src="{{asset('js/controllermaster.js')}}"></script>
        <!--/ script indispensables /-->
        <script type="text/javascript" src="{{asset('js/angular-chosen.js')}}"></script>
        <!-- script desarrollador -->
        <script type="text/javascript" src="{{asset('js/administracion/configuracion/build_business.js')}}"></script>
    </body>
</html>
