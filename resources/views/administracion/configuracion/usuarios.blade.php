@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div class="vue_usuarios">

  {!! $data_table !!}
  @include('administracion.configuracion.usuarios_edit')

</div>

@stop
@push('scripts')
  <script type="text/javascript" src="{{asset('js/administracion/configuracion/build_usuarios.js')}}" ></script>
  <script type="text/javascript" src="{{asset('js/administracion/configuracion/build_asigna_permisos.js')}}" ></script>
@endpush
