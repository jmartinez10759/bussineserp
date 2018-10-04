@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div id="vue-cotizacion">
    {!! $data_table !!}
    @include('ventas.cotizacion_edit')
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/ventas/build_cotizacion.js')}}"></script>
@endpush