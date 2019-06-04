
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Expires" content="0">
  <meta http-equiv="Last-Modified" content="0">
  <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="ruta-general" content="{{ $_SERVER['PHP_SELF'] }}">
  <link rel="icon" href="{{asset( $icon )}}" type="image/x-icon" />
  <link rel="shortcut icon" href="{{asset( $icon )}}" type="image/x-icon" />
   <title>{!! $APPTITLE !!} </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{$base_url}}admintle/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Styles -->
  <link type="text/css" rel="stylesheet" href="{{ asset('css/app.master.css')}}" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{$base_url}}admintle/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{$base_url}}admintle/bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{$base_url}}admintle/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{$base_url}}admintle/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{$base_url}}admintle/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{$base_url}}admintle/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{$base_url}}admintle/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{$base_url}}admintle/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{$base_url}}admintle/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- datetimepicker -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.4/css/bootstrap-datetimepicker.min.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{$base_url}}admintle/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <base href="{{ $_SERVER['PHP_SELF'] }}" />
  <!-- Google Font -->
  {{--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">--}}
 <style type="text/css">
    .scroll {width: 100%;display:block;}
    .scroll thead { display: inline-block; width: 100%;}
    .scroll tbody { height: 350px; display: inline-block; width: 100%;overflow: auto; }
  </style>
  <style type="text/css">

    .fixed_header{width: 100%;table-layout: auto;border-collapse: collapse;}
    .fixed_header tbody{display:block;width: 100%;overflow: auto;height: 350px;}
    /*.fixed_header thead tr {display: block; width: 100% }*/
    .fixed_header thead tr {display: inline-block; width: 100% }
    .fixed_header thead {background: black;color:#fff;}
    .fixed_header th, .fixed_header td {padding: 5px;text-align: left; width: 200px;}
  
    .drop-shadow {
        position:relative;
        float:left;
        width:100%;
        padding:1em;
        margin: 1em 2px 0em;
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

    .drop-shadows {
        position:relative;
        float:left;
        width:100%;
        padding:1em;
        margin: 1em 2px 0em;
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
    .notify {
        animation: 1s ease-out 0s normal none infinite running heartbit;
        border: 5px solid #4680ff;
        border-radius: 100px;
        height: 25px;heartbit
        position: absolute;
        right: -4px;
        top: -20px;
        width: 25px;
        z-index: 10;
      }
      @-moz-keyframes heartbit {
          0% {-moz-transform: scale(0);opacity: 0.0;}
          25% {-moz-transform: scale(1.1);opacity: 0.1;}
          50% {-moz-transform: scale(1.5);opacity: 0.3;}
          75% {-moz-transform: scale(1.8);opacity: 0.5;}
          to {-moz-transform: scale(8);opacity: 0.0;}
        }
      @-webkit-keyframes heartbit {
        0% {-webkit-transform: scale(0);opacity: 0.0;}
        25% {-webkit-transform: scale(1.1);opacity: 0.1;}
        50% {-webkit-transform: scale(1.5);opacity: 0.3;}
        75% {-webkit-transform: scale(1.8);opacity: 0.5;}
        to {-webkit-transform: scale(8);opacity: 0.0;}
      }
      .fixed_header tbody::-webkit-scrollbar {width: 5px;background-color: #F5F5F5;}
      .fixed_header tbody::-webkit-scrollbar-track {border-radius: 10px;background: rgba(0,0,0,0.1);border: 1px solid #ccc;}
      .fixed_header tbody::-webkit-scrollbar-thumb {border-radius: 10px;background: linear-gradient(left, #fff, #e4e4e4);border: 1px solid #aaa;}
      .fixed_header tbody::-webkit-scrollbar-thumb:hover { background: #fff; }
      .fixed_header tbody::-webkit-scrollbar-thumb:active { background: linear-gradient(left, #22ADD4, #1E98BA);}

      .scroll tbody::-webkit-scrollbar {width: 5px;background-color: #F5F5F5;}
      .scroll tbody::-webkit-scrollbar-track {border-radius: 10px;background: rgba(0,0,0,0.1);border: 1px solid #ccc;}
      .scroll tbody::-webkit-scrollbar-thumb {border-radius: 10px;background: linear-gradient(left, #fff, #e4e4e4);border: 1px solid #aaa;}
      .scroll tbody::-webkit-scrollbar-thumb:hover { background: #fff; }
      .scroll tbody::-webkit-scrollbar-thumb:active { background: linear-gradient(left, #22ADD4, #1E98BA);}

      .slimScrollDiv section{display:block;width: 100%;overflow: auto;height: 350px;}
      .slimScrollDiv section::-webkit-scrollbar {width: 4px;background-color: #F5F5F5;}
       body{display:block;width: 100%;overflow: auto;height: 350px;}
       body::-webkit-scrollbar {width: 4px;background-color: #F5F5F5;}
       [v-cloak]{display: none}
       [ng-cloak]{display: none}
       .loader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('img/loading04.gif') 50% 50% no-repeat rgb(249,249,249);
            opacity: .8;
        }
  </style>
  <style type="text/css">
    .fixed_headers{
      width: 400px;
      table-layout: fixed;
      border-collapse: collapse;
    }

    .fixed_headers tbody{
      overflow: auto;
      height: 100px;
    }

    .fixed_headers thead {
      background: black;
      color:#fff;
    }

    .fixed_headers th, .fixed_headers td {
      padding: 5px;
      text-align: left;
      width: 200px;
    }
  </style>
   @stack('styles')
