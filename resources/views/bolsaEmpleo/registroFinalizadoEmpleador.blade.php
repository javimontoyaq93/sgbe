@extends('home')
@section('contenido')
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
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <a class="btn btn-primary" href="{{ route('login') }}" type="button">
                    Regresar
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
\
