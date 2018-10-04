@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div id="vue-monedas" v-cloak>
    {!! $data_table !!}
    @include('administracion.configuracion.monedas_edit')
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/administracion/configuracion/build_monedas.js')}}"></script>
@endpush