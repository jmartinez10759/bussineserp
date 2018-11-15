
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- obtengo la ruta de mi proyecto -->
  <meta name="ruta-general" content="{{ $_SERVER['PHP_SELF'] }}">
  <link rel="icon" href="{{asset( $icon )}}" type="image/x-icon" />
  <link rel="shortcut icon" href="{{asset( $icon )}}" type="image/x-icon" />
   <title>{!! $APPTITLE !!} </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{$base_url}}admintle/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> -->
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
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{$base_url}}admintle/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css"> -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-chosen@1.4.2/bootstrap-chosen.css">
  <!-- Styles -->
  <link type="text/css" rel="stylesheet" href="{{ asset('css/sweetalert.css')}}" />
  <link type="text/css" rel="stylesheet" href="{{ asset('css/toastr.css')}}" />
  <link type="text/css" rel="stylesheet" href="{{ asset('css/dropzone.css')}}" />
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <base href="{{ $_SERVER['PHP_SELF'] }}" />
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
 <style type="text/css">
    .scroll {width: 100%;display:block;}
    .scroll thead { display: inline-block; width: 100%;}
    .scroll tbody { height: 350px; display: inline-block; width: 100%;overflow: auto; }
  </style>
  <style type="text/css">

    .fixed_header{width: 100%;table-layout: auto;border-collapse: collapse;}
    .fixed_header tbody{display:block;width: 100%;overflow: auto;height: 350px;}
    .fixed_header thead tr {display: block;}
    .fixed_header thead {background: black;color:#fff;}
    .fixed_header th, .fixed_header td {padding: 5px;text-align: left;width: 500px;}
    /*.fixed_header{width: 100%;table-layout: auto; border-collapse: collapse; display:block;}
    .fixed_header tbody {display:block; overflow: auto; height: 350px;}
    .fixed_header thead {background-color: rgb(51, 122, 183);color:#fff; display: block;}
    .fixed_header thead tr {display: block;}
    .fixed_header tfoot {display: block;}
    .fixed_header th, .fixed_header td {padding: 5px;text-align: left; width: 500px;}*/
    .notify {
        animation: 1s ease-out 0s normal none infinite running heartbit;
        border: 5px solid #4680ff;
        border-radius: 100px;
        height: 25px;
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
  </style>
  <!-- estilos del desarrollador -->
   @stack('styles')
