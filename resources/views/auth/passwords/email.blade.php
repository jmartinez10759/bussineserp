@extends('layouts.app')

@section('content')

<div class="clearfix"></div>
<br><br><br><br><br>
<div class="container" id="vue-password">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Restablecer Contraseña</div>

                <div class="panel-body">

                    <form class="form-horizontal">

                        <div class="form-group">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="emails" type="email" class="form-control" required v-model="newKeep.correo">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="button" class="btn btn-primary" v-on:click.prevent="reset_password()">
                                    Restablecer Contraseña
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/candidatos/password.js')}}" ></script>
@endpush
