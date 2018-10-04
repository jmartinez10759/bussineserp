@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div id="vue-contactos">
    {!! $data_table !!}
    @include('administracion.configuracion.contactos_edit')
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/administrador/configuracion/build_contactos.js')}}"></script>
@endpush