@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div id="vue-planes">
    {!! $data_table !!}
    @include('administracion.configuracion.planes_edit')
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/administracion/configuracion/build_planes.js')}}"></script>
@endpush