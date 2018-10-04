 	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- obtengo la ruta de mi proyecto -->
    <meta name="ruta-general" content="{{ $_SERVER['PHP_SELF'] }}">
    <link rel="icon" href="{{asset('img/login/favicon.ico')}}" type="image/x-icon" />
    <link rel="shortcut icon" href="{{asset('img/login/favicon.ico')}}" type="image/x-icon" />
    <title>{!! $APPTITLE !!} </title>
    <!-- Styles -->
    <link type="text/css" rel="stylesheet" href="{{asset('css/sweetalert.css')}}" />
    <link type="text/css" rel="stylesheet" href="{{asset('css/toastr.css')}}" />
    <!-- Bootstrap -->
   <link href="{{$base_url}}templates/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
   <!-- Font Awesome -->
   <link href="{{$base_url}}templates/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
   <!-- NProgress -->
   <link href="{{$base_url}}templates/vendors/nprogress/nprogress.css" rel="stylesheet">
   <!-- iCheck -->
   <link href="{{$base_url}}templates/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
 <!-- Datatables -->
   <link href="{{$base_url}}templates/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
   <link href="{{$base_url}}templates/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
   <link href="{{$base_url}}templates/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
   <link href="{{$base_url}}templates/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
   <link href="{{$base_url}}templates/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

   <!-- bootstrap-progressbar -->
   <link href="{{$base_url}}templates/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
   <!-- JQVMap -->
   <link href="{{$base_url}}templates/vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
   <!-- bootstrap-daterangepicker -->
   <link href="{{$base_url}}templates/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
   <!-- Custom Theme Style -->
   <link href="{{$base_url}}templates/build/css/custom.min.css" rel="stylesheet">
   <!-- Add fancyBox -->
   <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.1.25/jquery.fancybox.min.css" /> -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.css" type="text/css" media="screen" />
   <!-- Latest compiled and minified CSS -->
	 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
   <!-- daterange picker -->
   <link rel="stylesheet" href="{{asset('admintle/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
   <!-- bootstrap datepicker -->
   <link rel="stylesheet" href="{{asset('admintle/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
   <!-- Bootstrap time Picker -->
   <link rel="stylesheet" href="{{asset('admintle/plugins/timepicker/bootstrap-timepicker.min.css')}}">
   <!-- Select2 -->
   <link rel="stylesheet" href="{{asset('admintle/bower_components/select2/dist/css/select2.min.css')}}">
   <!-- estilos del desarrollador -->
   @stack('styles')
