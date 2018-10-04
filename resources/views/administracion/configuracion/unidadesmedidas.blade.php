@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div id="vue-unidadesmedidas">
    {!! $data_table !!}
    @include('administracion.configuracion.unidadesmedidas_edit')
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/administracion/configuracion/build_unidadesmedidas.js')}}"></script>
@endpush