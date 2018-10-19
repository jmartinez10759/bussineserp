@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div id="vue-facturaciones">
    {!! $data_table !!}
    @include('ventas.facturaciones_edit')
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/ventas/build_facturaciones.js')}}"></script>
@endpush