<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" ng-app="application" ng-controller="ApplicationController" ng-init="constructor()" ng-cloak>
<head>
    @include('layouts.template.includes-header')
</head>
<!-- <body class="hold-transition skin-blue sidebar-mini fixed"> -->
<body class="hold-transition skin-blue sidebar-mini fixed">

    <div class="wrapper">

         @include('layouts.template.page-header')
        <!-- Left side column. contains the logo and sidebar -->
         @include('layouts.template.page-left')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
           @include('layouts.template.page-content')
        </div>
        <!-- /.content-wrapper -->
         @include('layouts.template.page-footer')

        <!-- Control Sidebar -->
         @include('layouts.template.page-right')
        <!-- /.control-sidebar -->
        <!-- Add the sidebar's background. This div must be placed
             immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>

    </div>
    <!-- ./wrapper -->
    @include('layouts.template.includes-footer')

</body>
</html>
