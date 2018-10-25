@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div id="vue-usocfdi">
    {!! $data_table !!}
    @include('administracion.configuracion.usocfdi_edit')
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/administracion/configuracion/build_usocfdi.js')}}"></script>
@endpush