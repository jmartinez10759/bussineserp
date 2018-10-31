@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div id="vue-tipofactor">
    {!! $data_table !!}
    @include('administracion.configuracion.tipofactor_edit')
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/administracion/configuracion/build_tipofactor.js')}}"></script>
@endpush