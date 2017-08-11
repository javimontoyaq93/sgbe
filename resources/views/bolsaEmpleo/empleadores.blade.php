@extends('home')
@section('contenido')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel panel-heading">
                    <h3 class="panel-title">
                        Listado de Empleadores
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <form action="{{ route('buscar-empleador') }}" class="form-horizontal" method="POST" role="form">
                            {{ csrf_field() }}
                            <input id="filtro" name="filtro" type="text">
                            </input>
                            <input class="btn btn-primary" name="btn-buscar" type="submit" value="Buscar">
                            </input>
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="table-empleadores">
                            <thead>
                                <tr>
                                    <th>
                                        Nombre
                                    </th>
                                    <th>
                                        Tipo de Identificación
                                    </th>
                                    <th>
                                        Actividad
                                    </th>
                                    <th>
                                        Número de Identificación
                                    </th>
                                    <th>
                                        Celular
                                    </th>
                                    <th>
                                        Email
                                    </th>
                                    <th>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($empleadores as $empleador)
                                <tr>
                                    <td>
                                        {{ $empleador->razon_social }}
                                    </td>
                                    <td>
                                        {{ $empleador->tipoIdentificacion->descripcion }}
                                    </td>
                                    <td>
                                        {{ $empleador->actividadEconomica->descripcion }}
                                    </td>
                                    <td>
                                        {{ $empleador->numero_identificacion }}
                                    </td>
                                    <td>
                                        {{ $empleador->celular }}
                                    </td>
                                    <td>
                                        {{ $empleador->email }}
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <div class="col-sm-6 ">
                                                <a class="btn btn-primary" href="{{ route('show-empleador',$empleador->id) }}" type="button">
                                                    Editar
                                                </a>
                                            </div>
                                            <div class="col-sm-6 ">
                                                <form action="{{ route('borrar-empleador') }}" method="POST" onsubmit="return confirm('Realmente desea eliminar el empleador seleccionado?');">
                                                    {{ csrf_field() }}
                                                    <input name="id" type="hidden" value="{{ $empleador->id }}">
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
                    </div>
                    {{ $empleadores->links() }}
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <a class="btn btn-primary btn-lg " href="{{ route('crear-empleador') }}" type="button">
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
