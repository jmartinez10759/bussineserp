<!DOCTYPE html>
<html lang="es" class="no-js" ng-app="application" ng-controller="LoginController" ng-init="constructor()" ng-cloak>
<head>
    <title>Inicio de Sesión | Sistema </title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- get path of the project -->
        <meta name="ruta-general" content="{{ $_SERVER['PHP_SELF'] }}">
        <link rel="icon" href="{{asset('img/company.png')}}" type="image/x-icon" />
        <link rel="shortcut icon" href="{{asset('img/company.png')}}" type="image/x-icon" />
        <!--css -->
        <link type="text/css" rel="stylesheet" href="{{asset("bower_components/bootstrap/dist/css/bootstrap.min.css")}}" />
        <link type="text/css" rel="stylesheet" href="{{asset('css/app.master.css')}}" />
        <link type="text/css" rel="stylesheet" href="{{asset('css/login/login.css')}}" />
        <link type="text/css" rel="stylesheet" href="{{asset('css/login/animate-custom.css')}}" />
</head>
<body>

<div class="container" id="login-block" background-random>
    <div class="row">
        <div class="col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">
            <div class="login-box clearfix animated flipInY">
                <div class="page-icon animated bounceInDown imagen">
                    {{--<img src="{{asset('img/company.png')}}" class="img-responsive" alt="icon">--}}
                    <img src="{{asset('img/company.png')}}" class="img-responsive" alt="icon">
                </div>
                <div class="login-logo animated bounceInDown">
                    {{--<a href="#"><img width="36%" src="{{asset('img/companies/tepanyaky_company.jpeg')}}" alt="Company Logo"/></a>--}}
                </div>
                <hr/>

                <div class="login-form">

                    <form class="login-form right" ng-submit="startSession()" id="form-login" method="POST" autocomplete="true">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="username / correo" ng-model="datos.email"  required>
                        </div>
                        <div class="form-group">
                            <div class="inner-addon right-addon">
                                <input type="password" class="form-control" ng-model="datos.password" placeholder="Contraseña" required watch-password >
                                {{--<span id="eyeIcon" class="glyphicon glyphicon-eye-open"></span>--}}
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-blue" ng-disabled="enabled">
                                <span ng-show="serching"><i class="glyphicon glyphicon-refresh spinning"></i></span>
                                Entrar
                            </button>
                        </div>
                    </form>
                    <div class="login-links" ng-hide="false">
                        <a href="forgot-password.html">¿Olvido su Contraseña?</a>
                        <a href="sign-up.html"></a>
                    </div>

                </div>

            </div>

            <div class="social-login row">
                     <div class="fb-login col-lg-6 col-md-12 animated flipInY">
                        <a href="#" class="btn btn-facebook btn-block">Ir a nuestro <strong>Facebook</strong></a>
                    </div>
                    <div class="twit-login col-lg-6 col-md-12 animated flipInY">
                        <a href="#" class="btn btn-twitter btn-block">Visita nuestro <strong>Twitter</strong></a>
                    </div>
            </div>

        </div>

    </div>

 </div>

 <!-- End Login box -->

 <footer class="container animated bounceInDown">
    <p id="footer-text">
        <small>{{$desarrollo}}<a href="#">{{$empresa}}</a></small>
    </p>
 </footer>
<!-- scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- scripts -->
<!-- pusher notifications -->
<script src="//js.pusher.com/4.4/pusher.min.js"></script>
<!-- / pusher notifications -->

<!-- angular components -->
<script type="text/javascript" src="{{asset('bower_components/angular/angular.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components/angular-animate/angular-animate.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components/angular-chosen-localytics/dist/angular-chosen.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components/sweetalert2/dist/sweetalert2.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components/ngSweetAlert2/SweetAlert.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components/swangular/swangular.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components/angular-toastr/dist/angular-toastr.tpls.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components/dropzone/downloads/dropzone.min.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components/angular-dropzone/lib/angular-dropzone.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components/angucomplete-alt/angucomplete-alt.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components/pusher-angular/lib/pusher-angular.min.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components/angular-smart-table/dist/smart-table.min.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components/angular-ui-utils/index.js')}}"></script>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.5/angular-route.js"></script>
<script type="text/javascript" src="{{asset('js/angular-chosen.js')}}"></script>
<!-- angular components -->
<script type="text/javascript" src="{{asset('js/global.system.js')}}"></script>
<script type="text/javascript" src="{{asset('js/tools-manager.js')}}"></script>

<script type="text/javascript" src="{{asset('js/ModuleController.js')}}"></script>
<script type="text/javascript" src="{{asset('js/FactoryController.js')}}"></script>
<script type="text/javascript" src="{{asset('js/NotificationsFactory.js')}}"></script>
<script type="text/javascript" src="{{asset('js/ServiceController.js')}}"></script>
<script type="text/javascript" src="{{asset('js/ApplicationController.js')}}"></script>
<!-- script developer-->
<script type="text/javascript" src="{{asset('js/login/buildLoginController.js')}}"></script>
<!--load directives-->
<script type="text/javascript" src="{{asset('js/login/directives/background-random.js')}}"></script>


</body>
</html>
