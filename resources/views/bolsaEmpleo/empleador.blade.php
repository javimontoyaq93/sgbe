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
        <ul class="nav nav-tabs">
            <li class="active">
                <a data-toggle="tab" href="#datos_basicos">
                    Datos Básicos
                </a>
            </li>
            <li>
                <a data-toggle="tab" href="#direcciones">
                    Direcciones
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade in active" id="datos_basicos">
                <br/>
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form action="{{ route('guardar-empleador') }}" class="form-horizontal" method="POST" role="form">
                                {{ csrf_field() }}
                                <input id="id" name="id" type="hidden" value="{{ $empleador->id }}">
                                    <div class="form-group{{ $errors->has('razon_social') ? ' has-error' : '' }}">
                                        <label class="col-md-4 control-label" for="razon_social">
                                            Nombre
                                        </label>
                                        <div class="col-md-6">
                                            <input autofocus="" class="form-control" id="razon-social" name="razon_social" required="" type="text" value="{{ $empleador->razon_social }}">
                                                @if ($errors->has('razon_social'))
                                                <span class="help-block">
                                                    <strong>
                                                        {{ $errors->first('razon_social') }}
                                                    </strong>
                                                </span>
                                                @endif
                                            </input>
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('actividad_economica') ? ' has-error' : '' }}">
                                        <label class="col-md-4 control-label" for="actividad_economica">
                                            Actividad Económica
                                        </label>
                                        <div class="col-md-6">
                                            <select class="form-control" name="actividad_economica">
                                                @foreach($actividades_economicas as $item)
                                   @if($item->id==$empleador->actividad_economica)
                                                <option selected="selected" value="{{$item->id}}">
                                                    {{$item->descripcion}}
                                                </option>
                                                @else
                                                <option value="{{$item->id}}">
                                                    {{$item->descripcion}}
                                                </option>
                                                @endif
                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('tipo_identificacion') ? ' has-error' : '' }}">
                                        <label class="col-md-4 control-label" for="tipo_identificacion">
                                            Tipo de Documento
                                        </label>
                                        <div class="col-md-6">
                                            <select class="form-control" name="tipo_identificacion">
                                                @foreach($tipos_documentos as $item)
                                       @if($item->id==$empleador->tipos_identificacion)
                                                <option selected="selected" value="{{$item->id}}">
                                                    {{$item->descripcion}}
                                                </option>
                                                @else
                                                <option value="{{$item->id}}">
                                                    {{$item->descripcion}}
                                                </option>
                                                @endif
                                        @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('numero_identificacion') ? ' has-error' : '' }}">
                                        <label class="col-md-4 control-label" for="numero_identificacion">
                                            Número de Identificación
                                        </label>
                                        <div class="col-md-6">
                                            <input autofocus="" class="form-control" id="numero_identificacion" name="numero_identificacion" required="" type="text" value="{{$empleador->numero_identificacion }}">
                                                @if ($errors->has('numero_identificacion'))
                                                <span class="help-block">
                                                    <strong>
                                                        {{ $errors->first('numero_identificacion') }}
                                                    </strong>
                                                </span>
                                                @endif
                                            </input>
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('tipo_personeria') ? ' has-error' : '' }}">
                                        <label class="col-md-4 control-label" for="tipo_personeria">
                                            Tipo de Personeria
                                        </label>
                                        <div class="col-md-6">
                                            <select class="form-control" name="tipo_personeria">
                                                @foreach($tipos_personeria as $item)
                                       @if($item->id==$empleador->tipo_personeria)
                                                <option selected="selected" value="{{$item->id}}">
                                                    {{$item->descripcion}}
                                                </option>
                                                @else
                                                <option value="{{$item->id}}">
                                                    {{$item->descripcion}}
                                                </option>
                                                @endif
                                        @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                        <label class="col-md-4 control-label" for="email">
                                            Email
                                        </label>
                                        <div class="col-md-6">
                                            <input class="form-control" id="celular" name="email" type="email" value="{{$empleador->email}}">
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
                                    <div class="form-group{{ $errors->has('celular') ? ' has-error' : '' }}">
                                        <label class="col-md-4 control-label" for="celular">
                                            Celular
                                        </label>
                                        <div class="col-md-6">
                                            <input class="form-control" id="celular" name="celular" value="{{ $empleador->celular}}">
                                                @if ($errors->has('celular'))
                                                <span class="help-block">
                                                    <strong>
                                                        {{ $errors->first('celular') }}
                                                    </strong>
                                                </span>
                                                @endif
                                            </input>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-6 col-md-offset-4">
                                            <button class="btn btn-primary" type="submit">
                                                Guardar
                                            </button>
                                        </div>
                                    </div>
                                </input>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="direcciones">
                @if ($empleador->id!==null)
                @include('bolsaEmpleo.direccionesEmpleador',['empleador' => $empleador])
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
