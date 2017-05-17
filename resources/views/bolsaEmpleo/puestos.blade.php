@extends('home')
@section('contenido')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel panel-heading">
                    <h3 class="panel-title">
                        Listado de Puestos
                    </h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover" id="table-puestos">
                        <thead>
                            <tr>
                                <th>
                                    Denominacion
                                </th>
                                <th>
                                    Area de Conocimiento
                                </th>
                                <th>
                                    Nivel de Instrucción
                                </th>
                                <th>
                                    Remuneración
                                </th>
                                <th>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($puestos as $puesto)
                            <tr>
                                <td>
                                    {{ $puesto->denominacion }}
                                </td>
                                <td>
                                    {{ $puesto->area_conocimiento }}
                                </td>
                                <td>
                                    {{ $puesto->nivelInstruccion->descripcion }}
                                </td>
                                <td>
                                    {{ $puesto->remuneracion }}
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div class="col-sm-6 ">
                                            <a class="btn btn-primary" href="{{ route('show-puesto',$puesto->id) }}" type="button">
                                                Editar
                                            </a>
                                        </div>
                                        <div class="col-sm-6 ">
                                            <form action="{{ route('borrar-puesto') }}" method="POST" onsubmit="return confirm('Realmente desea eliminar el puesto seleccionado?');">
                                                {{ csrf_field() }}
                                                <input name="id" type="hidden" value="{{ $puesto->id }}">
                                                    <input class="btn btn-primary" name="completeYes" type="submit" value="Eliminar"/>
                                                </input>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $puestos->links() }}
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <a class="btn btn-primary btn-lg" href="{{ route('crear-puesto') }}" type="button">
                                Crear
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
