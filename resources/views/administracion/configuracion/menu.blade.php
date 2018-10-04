
@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div id="vue_menus">
    {!! $data_table !!}
  <br>

@include('administracion.configuracion.menu_edit')

</div>

@stop
@push('scripts')
  <script type="text/javascript" src="{{asset('js/administracion/configuracion/build_menus.js')}}" ></script>
@endpush
