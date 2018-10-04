@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div id="vue-estructura">
    {!! $data_table !!}
    @include('development.vista_edit')
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/administrador/configuracion/nombre_js.js')}}"></script>
@endpush