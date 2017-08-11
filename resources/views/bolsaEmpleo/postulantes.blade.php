@extends('home')
@section('contenido')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel panel-heading">
                    <h3 class="panel-title">
                        Listado de Postulantes
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <form action="{{ route('buscar-postulante') }}" class="form-horizontal" method="POST" role="form">
                            {{ csrf_field() }}
                            <input id="filtro" name="filtro" type="text">
                            </input>
                            <input class="btn btn-primary" name="btn-buscar" type="submit" value="Buscar">
                            </input>
                        </form>
                    </div>
                    <table class="table table-striped table-bordered table-hover" id="table-postulantes">
                        <thead>
                            <tr>
                                <th>
                                    Nombres
                                </th>
                                <th>
                                    Apellidos
                                </th>
                                <th>
                                    Tipo de Identificación
                                </th>
                                <th>
                                    Número de Identificación
                                </th>
                                <th>
                                    Estado Civil
                                </th>
                                <th>
                                    Genero
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
                            @foreach($postulantes as $postulante)
                            <tr>
                                <td>
                                    {{ $postulante->nombres }}
                                </td>
                                <td>
                                    {{ $postulante->apellidos }}
                                </td>
                                <td>
                                    {{ $postulante->tipoIdentificacion->descripcion }}
                                </td>
                                <td>
                                    {{ $postulante->numero_identificacion }}
                                </td>
                                <td>
                                    {{ $postulante->estadoCivil->descripcion }}
                                </td>
                                <td>
                                    {{ $postulante->getGenero->descripcion }}
                                </td>
                                <td>
                                    {{ $postulante->celular }}
                                </td>
                                <td>
                                    {{ $postulante->email }}
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div class="col-sm-6 ">
                                            <a class="btn btn-primary" href="{{ route('show-postulante',$postulante->id) }}" type="button">
                                                Editar
                                            </a>
                                        </div>
                                        <div class="col-sm-6 ">
                                            <form action="{{ route('borrar-postulante') }}" method="POST" onsubmit="return confirm('Realmente desea eliminar el Postulante seleccionado?');">
                                                {{ csrf_field() }}
                                                <input name="id" type="hidden" value="{{ $postulante->id }}">
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
                    {{ $postulantes->links() }}
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <a class="btn btn-primary btn-lg" href="{{ route('crear-postulante') }}" type="button">
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
