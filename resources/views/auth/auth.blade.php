<!DOCTYPE html>
<html lang="es" class="no-js">
<head>
    <title>{{$title_page}} </title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- obtengo la ruta de mi proyecto -->
        <meta name="ruta-general" content="{{ $_SERVER['PHP_SELF'] }}">
        <link rel="icon" href="{{asset('img/login/buro_laboral.ico')}}" type="image/x-icon" />
        <link rel="shortcut icon" href="{{asset('img/login/buro_laboral.ico')}}" type="image/x-icon" />
        <!--css -->
        <link type="text/css" rel="stylesheet" href="{{asset('css/bootstrap.css')}}" />
        <link type="text/css" rel="stylesheet" href="{{asset('css/sweetalert.css')}}" />
        <link type="text/css" rel="stylesheet" href="{{asset('css/toastr.css')}}" />

        <link href="{{asset('css/login/login.css')}}" rel="stylesheet">
        <link href="{{asset('css/login/animate-custom.css')}}" rel="stylesheet">

</head>
<body>


<div class="container" id="login-block">

    <div class="row">

        <div class="col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">

            <div class="login-box clearfix animated flipInY">

                <div class="page-icon animated bounceInDown imagen">
                    <img src="{{asset('img/header_buro_laboral.jpeg')}}" class="img-responsive" alt="icon">
                </div>
                <div class="login-logo animated bounceInDown">
                    <a href="#"><img width="65%" src="{{asset('img/login/buro_laboral_title.png')}}" alt="Company Logo" /></a>
                </div>
                <hr/>
                <div class="login-form">

                <form class="login-form right" v-on:submit.prevent="inicio_sesion()" id="form-login" method="post" autocomplete="true">
                    <input type="text" id="correo" name="correo" placeholder="correo" v-model="newKeep.email"  required>
                    <input type="password" id="password" name="password" v-model="newKeep.password" placeholder="Contraseña"  required>
                            {{$error}}
                        <button type="submit" class="btn btn-blue">Entrar</button>
                    </form>
                        <div class="login-links">
                            <a href="forgot-password.html"></a>
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
<script type="text/javascript" src="{{asset('js/axios.js')}}"></script>
<script type="text/javascript" src="{{asset('js/toastr.js')}}"></script>
<script type="text/javascript" src="{{asset('js/vue.js')}}"></script>
<script type="text/javascript" src="{{asset('js/sweetalert.js')}}"></script>
<script type="text/javascript" src="{{asset('js/global.system.js')}}"></script>
<script type="text/javascript" src="{{asset('js/tools-manager.js')}}"></script>
  <!-- script master vue -->
<script type="text/javascript" src="{{asset('js/master_vue.js')}}"></script>
<script type="text/javascript" src="{{asset('js/master_script.js')}}"></script>
<script type="text/javascript" src="{{asset('js/login/build_login.js')}}"></script>
</body>
</html>
