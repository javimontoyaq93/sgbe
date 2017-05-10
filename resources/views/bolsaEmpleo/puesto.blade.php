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
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade in active" id="datos_basicos">
                <br/>
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form action="{{ route('guardar-puesto') }}" class="form-horizontal" method="POST" role="form">
                                {{ csrf_field() }}
                                <input id="id" name="id" type="hidden" value="{{ $puesto->id }}">
                                    <div class="form-group{{ $errors->has('razon_social') ? ' has-error' : '' }}">
                                        <label class="col-md-4 control-label" for="denominacion">
                                            Denominación
                                        </label>
                                        <div class="col-md-6">
                                            <input autofocus="" class="form-control" id="denominacion" name="denominacion" required="" type="text" value="{{ $puesto->denominacion }}">
                                                @if ($errors->has('denominacion'))
                                                <span class="help-block">
                                                    <strong>
                                                        {{ $errors->first('denominacion') }}
                                                    </strong>
                                                </span>
                                                @endif
                                            </input>
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('area_conocimiento') ? ' has-error' : '' }}">
                                        <label class="col-md-4 control-label" for="area_conocimiento">
                                            Area de Conocimiento
                                        </label>
                                        <div class="col-md-6">
                                            <input autofocus="" class="form-control" id="area_conocimiento" name="area_conocimiento" required="" type="text" value="{{$puesto->area_conocimiento }}">
                                                @if ($errors->has('area_conocimiento'))
                                                <span class="help-block">
                                                    <strong>
                                                        {{ $errors->first('area_conocimiento') }}
                                                    </strong>
                                                </span>
                                                @endif
                                            </input>
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('nivel_instruccion') ? ' has-error' : '' }}">
                                        <label class="col-md-4 control-label" for="nivel_instruccion">
                                            Nivel de Instrucción
                                        </label>
                                        <div class="col-md-6">
                                            <select class="form-control" name="nivel_instruccion">
                                                @foreach($niveles_instruccion as $item)
                                       @if($item->id==$puesto->nivel_instruccion)
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
                                    <div class="form-group{{ $errors->has('remuneracion') ? ' has-error' : '' }}">
                                        <label class="col-md-4 control-label" for="remuneracion">
                                            Remuneración
                                        </label>
                                        <div class="col-md-6">
                                            <input autofocus="" class="form-control" id="remuneracion" name="remuneracion" required="" step="0.01" type="number" value="{{$puesto->remuneracion }}">
                                                @if ($errors->has('remuneracion'))
                                                <span class="help-block">
                                                    <strong>
                                                        {{ $errors->first('remuneracion') }}
                                                    </strong>
                                                </span>
                                                @endif
                                            </input>
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('tiempo_experiencia') ? ' has-error' : '' }}">
                                        <label class="col-md-4 control-label" for="tiempo_experiencia">
                                            Tiempo de Experiencia en Años
                                        </label>
                                        <div class="col-md-6">
                                            <input autofocus="" class="form-control" id="tiempo_experiencia" name="tiempo_experiencia" required="" type="number" value="{{$puesto->tiempo_experiencia }}">
                                                @if ($errors->has('tiempo_experiencia'))
                                                <span class="help-block">
                                                    <strong>
                                                        {{ $errors->first('tiempo_experiencia') }}
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
                                            <a class="btn btn-primary" href="{{ route('puestos') }}" type="button">
                                                Regresar
                                            </a>
                                        </div>
                                    </div>
                                </input>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
