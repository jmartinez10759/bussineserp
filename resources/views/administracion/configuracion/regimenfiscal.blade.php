@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div id="vue-regimenfiscal">
    {!! $data_table !!}
    @include('administracion.configuracion.regimenfiscal_edit')
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/administracion/configuracion/build_regimenfiscal.js')}}"></script>
@endpush