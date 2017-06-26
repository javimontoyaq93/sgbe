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
         @if(Session::has('error_message'))
        <div class="alert alert-warning">
            <span class="glyphicon glyphicon-remove">
            </span>
            <em>
                {!! session('error_message') !!}
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
                            <form action="{{ route('guardar-postulante') }}" class="form-horizontal" method="POST" role="form">
                                {{ csrf_field() }}
                                <input id="id" name="id" type="hidden" value="{{ $postulante->id }}"/>
                                <div class="form-group{{ $errors->has('nombres') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label" for="nombres">
                                        Nombres
                                    </label>
                                    <div class="col-md-6">
                                        <input autofocus="" class="form-control" id="nombres" name="nombres" required="" type="text" value="{{ $postulante->nombres }}">
                                            @if ($errors->has('nombres'))
                                            <span class="help-block">
                                                <strong>
                                                    {{ $errors->first('nombres') }}
                                                </strong>
                                            </span>
                                            @endif
                                        </input>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('apellidos') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label" for="apellidos">
                                        Apellidos
                                    </label>
                                    <div class="col-md-6">
                                        <input autofocus="" class="form-control" id="apellidos" name="apellidos" required="" type="text" value="{{ $postulante->apellidos }}">
                                            @if ($errors->has('apellidos'))
                                            <span class="help-block">
                                                <strong>
                                                    {{ $errors->first('apellidos') }}
                                                </strong>
                                            </span>
                                            @endif
                                        </input>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('tipo_identificacion') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label" for="tipo_identificacion">
                                        Tipo de Documento
                                    </label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="tipo_identificacion">
                                            @foreach($tipos_documentos as $item)
                                       @if($item->id==$postulante->tipo_identificacion)
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
                                        <input autofocus="" class="form-control" id="numero_identificacion" name="numero_identificacion" required="" type="text" value="{{$postulante->numero_identificacion }}">
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
                                <div class="form-group{{ $errors->has('fecha_nacimiento') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label" for="fecha_nacimiento">
                                        Fecha de Nacimiento
                                    </label>
                                    <div class="input-append date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                        <input id="fecha_nacimiento" name="fecha_nacimiento" readonly="" size="16" type="text" value="{{ $postulante->fecha_nacimiento }}">
                                            <span class="add-on">
                                                <i class="icon-remove">
                                                </i>
                                            </span>
                                            <span class="add-on">
                                                <i class="icon-th">
                                                </i>
                                            </span>
                                        </input>
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('estado_civil') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label" for="estado_civil">
                                        Estado  Civil
                                    </label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="estado_civil">
                                            @foreach($estados_civiles as $item)
                                       @if($item->id==$postulante->estado_civil)
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
                                <div class="form-group{{ $errors->has('genero') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label" for="genero">
                                        Genero
                                    </label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="genero">
                                            @foreach($tipos_sexo as $item)
                                       @if($item->id==$postulante->genero)
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
                                        <input class="form-control" id="celular" name="email" type="email" value="{{$postulante->email}}">
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
                                        <input class="form-control" id="celular" name="celular" type="number" value="{{ $postulante->celular}}">
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
                                <div class="form-group{{ $errors->has('especialidad') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label" for="especialidad">
                                        Especialidad
                                    </label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="especialidad">
                                            @foreach($especialidades as $item)
                                       @if($item->id==$postulante->especialidad)
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
                                <div class="form-group{{ $errors->has('observacion') ? ' has-error' : '' }}">
                                    <label class="col-md-4 control-label" for="observacion">
                                        Certificados
                                    </label>
                                    <div class="col-md-6">
                                        <textarea cols="50" id="observacion" name="observacion" rows="5">
                                            {{ $postulante->observacion }}
                                        </textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-6 col-md-offset-4">
                                        <button class="btn btn-primary" type="submit">
                                            Guardar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="direcciones">
                @if ($postulante->id!==null)
                @include('bolsaEmpleo.direccionesPostulante',['postulante' => $postulante])
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
