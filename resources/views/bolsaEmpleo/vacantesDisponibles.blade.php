@extends('home')
@section('contenido')
<div class="container">
    <div class="row">
        @foreach ($vacantes_disponibles  as $vd)
        <div class="col-md-4">
            <div class="panel panel-success">
                <div class="panel panel-heading">
                    {{$vd->puesto->denominacion}}
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th>
                                    Fechas de Postulación
                                </th>
                                <td>
                                    Desde: {{ $vd->ofertaEmpleo->fecha_inicio }} a {{ $vd->ofertaEmpleo->fecha_fin }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Empleador
                                </th>
                                <td>
                                    {{ $vd->ofertaEmpleo->empleador->razon_social }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Email de Contacto
                                </th>
                                <td>
                                    {{ $vd->ofertaEmpleo->empleador->email }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Celular de Contacto
                                </th>
                                <td>
                                    {{ $vd->ofertaEmpleo->empleador->celular }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Número de Vacante
                                </th>
                                <td>
                                    {{ $vd->numero_vacante }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Título Requerido
                                </th>
                                <td>
                                    {{ $vd->puesto->nivelInstruccion->descripcion}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Área de Conocimiento
                                </th>
                                <td>
                                    {{ $vd->puesto->area_conocimiento}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Años de Experiencia
                                </th>
                                <td>
                                    {{ $vd->puesto->tiempo_experiencia}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Descipción
                                </th>
                                <td>
                                    {{ $vd->descripcion}}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    {{ $vacantes_disponibles->links() }}
</div>
@endsection
