@extends('home')
@section('contenido')
<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
        <div class="panel-body">
            <form action="{{ route('guardar-direccion-empleador') }}" class="form-horizontal" method="POST" role="form">
                {{ csrf_field() }}
                <input id="id" name="id" type="hidden" value="{{ $direccion->id }}">
                    <input id="empleador_id" name="empleador_id" type="hidden" value="{{ $empleador_id }}">
                        <div class="form-group{{ $errors->has('razon_social') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="razon_social">
                                Dirección
                            </label>
                            <div class="col-md-6">
                                <textarea autofocus="" class="form-control" id="calles" name="calles" required="" value="{{ $direccion->calles }}">
                                    @if ($errors->has('direccion->calles'))
                                    <span class="help-block">
                                        <strong>
                                            {{ $errors->first('direccion->calles') }}
                                        </strong>
                                    </span>
                                    @endif
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('referencia') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="referencia">
                                Referencia
                            </label>
                            <div class="col-md-6">
                                <input autofocus="" class="form-control" id="referencia" name="referencia" required="" type="text" value="{{$direccion->referencia }}">
                                    @if ($errors->has('referencia'))
                                    <span class="help-block">
                                        <strong>
                                            {{ $errors->first('referencia') }}
                                        </strong>
                                    </span>
                                    @endif
                                </input>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('tipo_direccion') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="tipo_direccion">
                                Tipo de Dirección
                            </label>
                            <div class="col-md-6">
                                <select class="form-control" name="tipo_direccion">
                                    @foreach($tipos_direcciones as $item)
                                       @if($item->id==$direccion->tipo_direccion)
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
@endsection
