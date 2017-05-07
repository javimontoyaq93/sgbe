@extends('home')
@section('contenido')
<script>
    function seleccionarPuesto(select){
    var puestoId=select.value;
       $.ajax({
              url:"/puesto-por-id/"+puestoId,
              type: "GET",
              dataType: "json",
              success: function (data) {
              var denominacion=document.getElementById("denominacion");  
              denominacion.value=data.denominacion;
              }
           });  
}
</script>
<div class="col-md-8 col-md-offset-2">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h2 class="panel-title">
                Datos de Vacante
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
            <form action="{{ route('guardar-vacante') }}" class="form-horizontal" method="POST" role="form">
                {{ csrf_field() }}
                <input id="id" name="id" type="hidden" value="{{ $vacante->id }}">
                    <input id="oferta_empleo_id" name="oferta_empleo_id" type="hidden" value="{{ $oferta_empleo_id }}">
                        <div class="form-group{{ $errors->has('puesto_id') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="puesto_id">
                                Puesto
                            </label>
                            <div class="col-md-6">
                                <select class="form-control" name="puesto_id" onchange="seleccionarPuesto(this)">
                                    @foreach($puestos as $puesto)
                                       @if($puesto->id==$vacante->puesto_id)
                                    <option selected="selected" value="{{$puesto->id}}">
                                        {{$puesto->denominacion}}
                                    </option>
                                    @else
                                    <option value="{{$puesto->id}}">
                                        {{$puesto->denominacion}}
                                    </option>
                                    @endif
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">
                                Denominación
                            </label>
                            <div class="col-md-6">
                                <input id="denominacion" name="denominacion" readonly="" value="">
                                </input>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('numero_vacante') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="numero_vacante">
                                Número de Vacantes
                            </label>
                            <div class="col-md-6">
                                <input class="form-control" id="numero_vacante" name="numero_vacante" required="" type="number" value="{{ $vacante->numero_vacante }}">
                                    @if ($errors->has('numero_vacante'))
                                    <span class="help-block">
                                        <strong>
                                            {{ $errors->first('numero_vacante') }}
                                        </strong>
                                    </span>
                                    @endif
                                </input>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('descripcion') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="descripcion">
                                Descripción
                            </label>
                            <div class="col-md-6">
                                <input autofocus="" class="form-control" id="descripcion" name="descripcion" required="" type="text" value="{{$vacante->descripcion }}">
                                    @if ($errors->has('descripcion'))
                                    <span class="help-block">
                                        <strong>
                                            {{ $errors->first('descripcion') }}
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
                                <a class="btn btn-primary" href="{{ route('show-ofertaEmpleo',$oferta_empleo_id) }}">
                                    Regresar
                                </a>
                            </div>
                        </div>
                    </input>
                </input>
            </form>
        </div>
    </div>
</div>
@endsection
