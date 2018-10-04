@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div id="vue-tiposcomprobantes">
    {!! $data_table !!}
    @include('administracion.configuracion.tiposcomprobantes_edit')
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/administracion/configuracion/build_tiposcomprobantes.js')}}"></script>
@endpush