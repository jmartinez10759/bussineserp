@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div id="vue-pais">
    {!! $data_table !!}
    @include('administracion.configuracion.pais_edit')
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/administracion/configuracion/build_pais.js')}}"></script>
@endpush