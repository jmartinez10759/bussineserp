@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div id="vue-impuesto">
    {!! $data_table !!}
    @include('administracion.configuracion.impuesto_edit')
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/administracion/configuracion/build_impuesto.js')}}"></script>
@endpush