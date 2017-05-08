@extends('home')
@section('contenido')
<script>
    function seleccionarPais(select){
    var paisId=select.value;
    var provinciasItems = $('.provinciasItems').remove();
    var ciudadesItems = $('.ciudadesItems').remove();
       $.ajax({
              url:"/provincias/"+paisId,
              type: "GET",
              dataType: "json",
              success: function (data) {
                $('select#provincia').append('<option class="provinciasItems">Seleccion Provincia</option>');
               for(var i =0;i < data.length;i++){
               var provincia = data[i];
               $('select#provincia').append('<option value="'+provincia.id+'" class="provinciasItems">'+provincia.descripcion+'</option>')
               }   
              }
           });  
}
function seleccionarProvincia(select){
    var paisId=select.value;
    var ciudadesItems = $('.ciudadesItems').remove();
       $.ajax({
              url:"/ciudades/"+paisId,
              type: "GET",
              dataType: "json",
              success: function (data) {

               for(var i =0;i < data.length;i++){
               var ciudad = data[i];
               $('select#ciudad').append('<option value="'+ciudad.id+'" class="ciudadesItems">'+ciudad.descripcion+'</option>')
               }   
              }
           });  
}
</script>
<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h2 class="panel-title">
                Datos de Dirección
            </h2>
        </div>
        <div class="panel-body">
            @if(Session::has('flash_message'))
            <div class="alert alert-success">
                <span class="glyphicon glyphicon-ok">
                </span>
                <em>
                    {!! session('flash_message') !!}
                </em>
            </div>
            @endif
            <form action="{{ route('guardar-direccion-postulante') }}" class="form-horizontal" method="POST" role="form">
                {{ csrf_field() }}
                <input id="id" name="id" type="hidden" value="{{ $direccion->id }}"/>
                <input id="postulante_id" name="postulante_id" type="hidden" value="{{ $postulante_id }}"/>
                <div class="form-group{{ $errors->has('pais') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label" for="pais">
                        Pais
                    </label>
                    <div class="col-md-6">
                        <select class="form-control" id="pais" name="pais" onchange="seleccionarPais(this)">
                            @foreach($paises as $item)
                                       @if($item->id==$direccion->direccion->pais)
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
                <div class="form-group{{ $errors->has('provincia') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label" for="provincia">
                        Provincia
                    </label>
                    <div class="col-md-6">
                        <select class="form-control" id="provincia" name="provincia" onchange="seleccionarProvincia(this)">
                            <option class="provinciasItems">
                                Seleccione Provincia
                            </option>
                            @foreach($provincias as $item)
                                       @if($item->id==$direccion->direccion->provincia)
                            <option class="provinciasItems" selected="selected" value="{{$item->id}}">
                                {{$item->descripcion}}
                            </option>
                            @else
                            <option class="provinciasItems" value="{{$item->id}}">
                                {{$item->descripcion}}
                            </option>
                            @endif
                                    @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('ciudad') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label" for="ciudad">
                        Ciudad
                    </label>
                    <div class="col-md-6">
                        <select class="form-control" id="ciudad" name="ciudad">
                            @foreach($ciudades as $item)
                                       @if($item->id==$direccion->direccion->ciudad)
                            <option class="ciudadesItems" selected="selected" value="{{$item->id}}">
                                {{$item->descripcion}}
                            </option>
                            @else
                            <option class="ciudadesItems" value="{{$item->id}}">
                                {{$item->descripcion}}
                            </option>
                            @endif
                                    @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('razon_social') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label" for="razon_social">
                        Dirección
                    </label>
                    <div class="col-md-6">
                        <input class="form-control" id="calles" name="calles" required="" value="{{ $direccion->direccion->calles }}">
                            @if ($errors->has('direccion->direccion->calles'))
                            <span class="help-block">
                                <strong>
                                    {{ $errors->first('calles') }}
                                </strong>
                            </span>
                            @endif
                        </input>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('referencia') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label" for="referencia">
                        Referencia
                    </label>
                    <div class="col-md-6">
                        <input autofocus="" class="form-control" id="referencia" name="referencia" required="" type="text" value="{{$direccion->direccion->referencia }}">
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
                <div class="form-group{{ $errors->has('telefono') ? ' has-error' : '' }}">
                    <label class="col-md-4 control-label" for="telefono">
                        Teléfono
                    </label>
                    <div class="col-md-6">
                        <input autofocus="" class="form-control" id="telefono" name="telefono" type="text" value="{{$direccion->direccion->telefono }}">
                            @if ($errors->has('telefono'))
                            <span class="help-block">
                                <strong>
                                    {{ $errors->first('telefono') }}
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
                        <a class="btn btn-primary" href="{{ route('show-postulante',$postulante_id) }}">
                            Regresar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
