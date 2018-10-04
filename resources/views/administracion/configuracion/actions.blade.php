@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div id="vue_actions">
  <!-- <div class="row collapse in">
  		<div class="col-sm-1 col-sm-offset-10">
  			<div class="btn-toolbar">
  				<button class="btn btn-success" data-toggle="modal" data-target="#modal_add_register"><i class="fa fa-plus-circle"> </i> Agregar</button>
  			</div>
  			<br>
  		</div>
  </div> -->
    {!! $data_table !!}
  <br>

@include('administracion.configuracion.actions_edit')
</div>

@stop
@push('scripts')
  <script type="text/javascript" src="{{asset('js/administracion/configuracion/build_actions.js')}}" ></script>
@endpush
