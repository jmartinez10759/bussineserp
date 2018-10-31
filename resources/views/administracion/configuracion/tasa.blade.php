@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div id="vue-tasa">
    {!! $data_table !!}
    @include('administracion.configuracion.tasa_edit')
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/administracion/configuracion/build_tasa.js')}}"></script>
@endpush