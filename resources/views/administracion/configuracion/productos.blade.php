@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div id="vue-productos">
    {!! $data_table !!}
    @include('administracion.configuracion.productos_edit')
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/administracion/configuracion/build_productos.js')}}"></script>
@endpush