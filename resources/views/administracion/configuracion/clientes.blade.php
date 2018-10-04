@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div id="vue-clientes">

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#prospectos" id="prospectos_tabs">PROSPECTOS REGISTRADOS</a></li>
        <li><a data-toggle="tab" href="#clientes" id="clientes_tabs">CLIENTES REGISTRADOS</a></li>
    </ul>

    <div class="tab-content">
       
        <div id="prospectos" class="tab-pane fade in active">
        <br>
            {!! $data_table !!}
        </div>
        <div id="clientes" class="tab-pane fade">
           <br>
            {!! $data_table_clientes !!}
        </div>
       
    </div>

    @include('administracion.configuracion.clientes_edit')
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/administracion/configuracion/build_clientes.js')}}"></script>
@endpush