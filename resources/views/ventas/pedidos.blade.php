@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div id="vue-pedidos">
    {!! $data_table !!}
    @include('ventas.pedidos_edit')
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/ventas/build_pedidos.js')}}"></script>
@endpush