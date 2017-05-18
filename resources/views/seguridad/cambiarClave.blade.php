@extends('home')
@section('contenido')
<div class="container">
    <div class="row">
        @if(!$user)
        <div class="alert alert-warning">
            <span class="glyphicon glyphicon-remove">
            </span>
            <em>
                Token Incorrecto, por favor vuelva a solicitar cambio de clave olvidada.
            </em>
        </div>
        @endif
        @if($user)
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Cambiar Password
                </div>
                <div class="panel-body">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                     @if(Session::has('flash_message'))
                    <div class="alert alert-success">
                        <span class="glyphicon glyphicon-ok">
                        </span>
                        <em>
                            {!! session('flash_message') !!}
                        </em>
                    </div>
                    @endif
         @if(Session::has('error_message'))
                    <div class="alert alert-warning">
                        <span class="glyphicon glyphicon-remove">
                        </span>
                        <em>
                            {!! session('error_message') !!}
                        </em>
                    </div>
                    @endif
                    <form action="{{ route('actualizar-cambio-clave') }}" class="form-horizontal" method="POST" role="form">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input id="id" name="id" type="hidden" value="{{ $user->id }}"/>
                            <label class="col-md-4 control-label" for="clave">
                                Clave
                            </label>
                            <div class="col-md-6">
                                <input class="form-control" id="clave" name="clave" required="" type="password">
                                    @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>
                                            {{ $errors->first('password') }}
                                        </strong>
                                    </span>
                                    @endif
                                </input>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="confirmar_clave">
                                Confirmar Clave
                            </label>
                            <div class="col-md-6">
                                <input class="form-control" id="confirmar_clave" name="confirmar_clave" required="" type="password">
                                </input>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button class="btn btn-primary" type="submit">
                                    Cambiar Clave
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
