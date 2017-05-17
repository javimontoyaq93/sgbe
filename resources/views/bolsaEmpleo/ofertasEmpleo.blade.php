@extends('home')
@section('contenido')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel panel-heading">
                    <h3 class="panel-title">
                        Listado de Ofertas de Empleo
                    </h3>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover" id="table-ofertaEmpleo">
                        <thead>
                            <tr>
                                <th>
                                    Descripcion
                                </th>
                                <th>
                                    Fecha de Inicio
                                </th>
                                <th>
                                    Fecha de Finalización
                                </th>
                                <th>
                                    Empleador
                                </th>
                                <th>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ofertasEmpleo as $ofertaEmpleo )
                            <tr>
                                <td>
                                    {{ $ofertaEmpleo->descripcion }}
                                </td>
                                <td>
                                    {{ $ofertaEmpleo->fecha_inicio }}
                                </td>
                                <td>
                                    {{ $ofertaEmpleo->fecha_fin }}
                                </td>
                                <td>
                                    {{ $ofertaEmpleo->empleador->razon_social }}
                                </td>
                                <td>
                                    <div class="form-group">
                                        <div class="col-sm-6 ">
                                            <a class="btn btn-primary" href="{{ route('show-ofertaEmpleo',$ofertaEmpleo->id) }}" type="button">
                                                Editar
                                            </a>
                                        </div>
                                        <div class="col-sm-6 ">
                                            <form action="{{ route('borrar-ofertaEmpleo') }}" method="POST" onsubmit="return confirm('Realmente desea eliminar la Oferta de Empleo seleccionado?');">
                                                {{ csrf_field() }}
                                                <input name="id" type="hidden" value="{{ $ofertaEmpleo->id }}">
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
                    {{ $ofertasEmpleo->links() }}
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <a class="btn btn-primary btn-lg" href="{{ route('crear-ofertaEmpleo') }}" type="button">
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
