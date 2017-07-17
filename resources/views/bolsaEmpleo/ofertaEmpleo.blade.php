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
                <a data-toggle="tab" href="#vacantes">
                    Vacantes
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade in active" id="datos_basicos">
                <br/>
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form action="{{ route('guardar-ofertaEmpleo') }}" class="form-horizontal" method="POST" role="form">
                                {{ csrf_field() }}
                                <input id="id" name="id" type="hidden" value="{{ $ofertaEmpleo->id }}">
                                    @if ($usuario && !$usuario->usuarioEmpleador)
                                    <div class="form-group{{ $errors->has('empleador_id') ? ' has-error' : '' }}">
                                        <label class="col-md-4 control-label" for="empleador_id">
                                            Empleador*
                                        </label>
                                        <div class="col-md-6">
                                            <select class="form-control" name="empleador_id">
                                                @foreach($empleadores as $empleador)
                                       @if($empleador->id==$ofertaEmpleo->empleador_id)
                                                <option selected="selected" value="{{$empleador->id}}">
                                                    {{$empleador->razon_social}}
                                                </option>
                                                @else
                                                <option value="{{$empleador->id}}">
                                                    {{$empleador->razon_social}}
                                                </option>
                                                @endif
                                        @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @else
                                    <input id="empleador_id" name="empleador_id" type="hidden" value="{{ $usuario->usuarioEmpleador->empleador_id }}">
                                        @endif
                                        <div class="form-group{{ $errors->has('descripcion') ? ' has-error' : '' }}">
                                            <label class="col-md-4 control-label" for="descripcion">
                                                Descripción*
                                            </label>
                                            <div class="col-md-6">
                                                <textarea class="form-control" cols="50" id="descripcion" name="descripcion" required="" rows="3">
                                                    {{ $ofertaEmpleo->descripcion }}
                                                </textarea>
                                            </div>
                                        </div>
                                        <div class="form-group{{ $errors->has('fecha_inicio') ? ' has-error' : '' }}">
                                            <label class="col-md-4 control-label" for="fecha_inicio">
                                                Fecha de Inicio*
                                            </label>
                                            <div class="input-append date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                <input id="fecha_inicio" name="fecha_inicio" readonly="" size="16" type="text" value="{{ $ofertaEmpleo->fecha_inicio }}">
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
                                        <div class="form-group{{ $errors->has('fecha_fin') ? ' has-error' : '' }}">
                                            <label class="col-md-4 control-label" for="fecha_fin">
                                                Fecha de Fin*
                                            </label>
                                            <div class="input-append date form_date" data-date="" data-date-format="yyyy-mm-dd" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                <input id="fecha_fin" name="fecha_fin" readonly="" size="16" type="text" value="{{ $ofertaEmpleo->fecha_fin }}">
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
                                        <div class="form-group">
                                            <div class="col-md-6 col-md-offset-4">
                                                <button class="btn btn-primary" type="submit">
                                                    Guardar
                                                </button>
                                            </div>
                                        </div>
                                    </input>
                                </input>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="vacantes">
                @if ($ofertaEmpleo->id!==null)
                @include('bolsaEmpleo.vacantes',['ofertaEmpleo' => $ofertaEmpleo])
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
