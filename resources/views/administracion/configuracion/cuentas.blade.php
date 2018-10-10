@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div id="vue-cuentas">
    {!! $data_table !!}
    @include('administracion.configuracion.cuentas_edit')
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/administracion/configuracion/build_cuentas.js')}}"></script>
@endpush