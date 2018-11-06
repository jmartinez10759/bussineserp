@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div id="vue-codigopostal">
    {!! $data_table !!}
    @include('administracion.configuracion.codigopostal_edit')
    {!! $seccion_reportes !!}
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/administracion/configuracion/build_codigopostal.js')}}"></script>
@endpush