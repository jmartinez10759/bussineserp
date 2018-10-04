@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div id="vue-almacenes">
    {!! $data_table !!}
    @include('almacenes.almacenes_edit')
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/almacenes/build_almacenes.js')}}"></script>
@endpush