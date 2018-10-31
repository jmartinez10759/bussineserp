@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div id="vue-claveprodservicio">
    {!! $data_table !!}
    @include('administracion.configuracion.claveprodservicio_edit')
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/administracion/configuracion/build_claveprodservicio.js')}}"></script>
@endpush