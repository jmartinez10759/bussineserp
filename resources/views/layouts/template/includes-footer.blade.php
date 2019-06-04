 <!-- jQuery 3 -->
    <script src="{{$base_url}}admintle/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{$base_url}}admintle/bower_components/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.7 -->
        <script src="{{$base_url}}admintle/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Bootstrap 4.0.1 -->
    <!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script> -->
    <!-- DataTables -->
    <script src="{{$base_url}}admintle/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{$base_url}}admintle/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <!-- <script src="{{$base_url}}admintle/bower_components/raphael/raphael.min.js"></script>
    <script src="{{$base_url}}admintle/bower_components/morris.js/morris.min.js"></script> -->
    <!-- Sparkline -->
    <script src="{{$base_url}}admintle/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="{{$base_url}}admintle/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="{{$base_url}}admintle/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{$base_url}}admintle/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="{{$base_url}}admintle/bower_components/moment/min/moment.min.js"></script>
    <script src="{{$base_url}}admintle/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="{{$base_url}}admintle/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/locales/bootstrap-datepicker.es.min.js"></script>
    <!-- datetimepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.4/js/bootstrap-datetimepicker.min.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{$base_url}}admintle/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="{{$base_url}}admintle/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="{{$base_url}}admintle/bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="{{$base_url}}admintle/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!-- <script src="{{$base_url}}admintle/dist/js/pages/dashboard.js"></script> -->
    <!-- AdminLTE for demo purposes -->
    <script src="{{$base_url}}admintle/dist/js/demo.js"></script>
    {{--<script type="text/javascript" src="{{asset('js/axios.js')}}"></script>--}}
    {{--<script type="text/javascript" src="{{asset('js/vue.js')}}"></script>--}}
    <script type="text/javascript" src="{{asset('js/global.system.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/tools-manager.js')}}"></script>
    <script type="text/javascript" src="{{asset('bower_components/chosen/chosen.jquery.js')}}"></script>
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
     <script type="text/javascript" src="{{asset('bower_components/angular-fixed-table-header/src/fixed-table-header.min.js')}}"></script>

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.5/angular-route.js"></script>

    <script src="{{asset('js/angular-bootstrap-select.min.js')}}"></script>

 <!-- script indispensables -->
    <script type="text/javascript" src="{{asset('js/master_vue.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/master_script.js')}}"></script>

    <script type="text/javascript" src="{{asset('js/ModuleController.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/FactoryController.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/NotificationsFactory.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/ServiceController.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/controllermaster.js')}}"></script>
 <!--/ script indispensables /-->
 <!-- InputMask -->
    <script src="{{asset('admintle/plugins/input-mask/jquery.inputmask.js')}}"></script>
    <script src="{{asset('admintle/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
    <script src="{{asset('admintle/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
    <!-- bootstrap color picker -->
    <script src="{{asset('admintle/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>
    <!-- bootstrap time picker -->
    <script src="{{asset('admintle/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
    <!-- Add fancyBox -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.5/jquery.fancybox.min.js"></script>
 <!-- / Add fancyBox -->
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/2.3.4/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.5/jszip.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-csv/0.8.3/jquery.csv.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jexcel/1.5.0/js/jquery.jexcel.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jexcel/1.5.0/css/jquery.jexcel.min.css" type="text/css" />

    <script type="text/javascript">
        jQuery('.sidebar-toggle').click(function(){
          var toogle = jQuery('body').hasClass('sidebar-collapse');
          $myLocalStorage.set('toogle',toogle);
        });
        var estatus_toogle = $myLocalStorage.get('toogle');
        if( estatus_toogle == false ){
          jQuery('body').removeClass();
          jQuery('body').addClass('skin-blue sidebar-mini sidebar-collapse fixed');
        }
        if( estatus_toogle == true ){
          jQuery('body').removeClass();
          jQuery('body').addClass('skin-blue sidebar-mini fixed');
        }
        jQuery('.sidebar-menu').find('li a').each(function(){
          var enlace = jQuery(this).attr('href');
          if( enlace === location.href){
            if( jQuery(this).parent().parent().hasClass('treeview-menu') ){
              jQuery(this).parent().parent().parent().addClass('active');
            }
            jQuery(this).parent().addClass('active');
          }else{
            jQuery(this).parent().removeClass('active');
          }

        });
        jQuery('.listado_correos').find('li a').each(function(){
          var enlace = jQuery(this).attr('href');
          if( enlace === location.href){
            jQuery(this).parent().addClass('active');
          }else{
            jQuery(this).parent().removeClass('active');
          }

        });

        jQuery('.select_chosen').chosen({width: "100%"});
        jQuery('.fecha').datepicker( {format: 'yyyy-mm-dd' ,autoclose: true ,pickTime: false, pickTime: false, autoclose: true, language: 'es'});
        window.onload = function() { jQuery(".loader").fadeOut("slow"); }

    </script>

    <!-- script desarrollador -->
      @stack('scripts')
      <script type="text/javascript" src="{{asset('js/angular-chosen.js')}}"></script>