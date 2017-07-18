@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
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
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Login
                </div>
                <div class="panel-body">
                    <form action="{{ route('autenticar') }}" class="form-horizontal" method="POST" role="form">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-lg-4 control-label" for="email">
                                E-Mail Address
                            </label>
                            <div class="col-lg-6">
                                <input autofocus="" class="form-control" id="email" name="email" required="" type="email" value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>
                                            {{ $errors->first('email') }}
                                        </strong>
                                    </span>
                                    @endif
                                </input>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-lg-4 control-label" for="password">
                                Password
                            </label>
                            <div class="col-lg-6">
                                <input class="form-control" id="password" name="password" required="" type="password">
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
                        <!-- <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox">
                                            Remember Me
                                        </input>
                                    </label>
                                </div>
                            </div>
                        </div>-->
                        <div class="form-group">
                            <div class="col-lg-8 col-md-offset-4">
                                <button class="btn btn-primary" type="submit">
                                    Login
                                </button>
                                <a class="btn btn-link" href="{{ route('recuperar-clave') }}">
                                    Olvidate tu contraseña?
                                </a>
                            </div>
                        </div>
                        <textarea class="textarea" placeholder="Enter text ..." style="width: 810px; height: 200px">
                        </textarea>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
