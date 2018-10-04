
@extends('layouts.template.app')
@section('content')
@push('styles')
<!-- daterange picker -->
<link rel="stylesheet" href="{{asset('admintle/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="{{asset('admintle/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="{{asset('admintle/plugins/timepicker/bootstrap-timepicker.min.css')}}">
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('admintle/bower_components/select2/dist/css/select2.min.css')}}">
@endpush
<div id="vue-register">
  <div class="row collapse in">
  		<div class="col-sm-1 col-sm-offset-10">
  			<div class="btn-toolbar">
  				<!-- <button class="btn btn-success" data-toggle="modal" data-target="#modal_add_register"><i class="fa fa-plus-circle"> </i> Agregar</button> -->
  			</div>
  			<br>
  		</div>
  </div>
  <div class="container-fluid table-responsive">
    {!! $data_table !!}
  </div>
  <br>

@include('administracion.register_edit')

</div>

@stop
@push('scripts')
  <script type="text/javascript" src="{{asset('js/administrador/build_register.js')}}" ></script>
  <!-- InputMask -->
  <script src="{{asset('admintle/plugins/input-mask/jquery.inputmask.js')}}"></script>
  <script src="{{asset('admintle/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
  <script src="{{asset('admintle/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
  <!-- date-range-picker -->
  <script src="{{asset('admintle/bower_components/moment/min/moment.min.js')}}"></script>
  <script src="{{asset('admintle/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
  <!-- bootstrap datepicker -->
  <script src="{{asset('admintle/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
  <!-- bootstrap color picker -->
  <script src="{{asset('admintle/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>
  <!-- bootstrap time picker -->
  <script src="{{asset('admintle/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>

  <script type="text/javascript">
  	initDataTable('datatable');
  	//Add text editor
    jQuery("#compose-textarea").wysihtml5();
    //jQuery('#fecha').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' });
    //Date picker
    jQuery('#fecha').datepicker({
      autoclose: true
      ,format: "yyyy-mm-dd"
    })
    //Timepicker
    jQuery('#horario').timepicker({
      showInputs: false
    });
  </script>
@endpush
