@extends('layouts.app')
@section('content')
<div class="container" style="width: 100%">
    <div class="row">
        <div class="col-lg-2">
            @if (Auth::user())
            @include('seguridad.menu')
            @endif
        </div>
        <div class="col-lg-8">
            @yield('contenido')
        </div>
        <div class="col-lg-2">
        </div>
    </div>
</div>
@endsection
