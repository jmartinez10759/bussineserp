<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
   @include('layouts.admin.includes-header')
</head>
<body class="nav-md footer_fixed">
    <!-- <div id="wrapper" class="container-fluid"> -->
    <div class="container body">
      <div class="main_container">
        @include('layouts.admin.page-left')
        @include('layouts.admin.page-header')
        @include('layouts.admin.page-content')
        @include('layouts.admin.page-footer')
          <!-- <main class="container-fluid"> --> <!-- </main> -->
      </div>
    </div>
    @include('layouts.admin.includes-footer')
</body>
</html>
