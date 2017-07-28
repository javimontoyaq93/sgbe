@extends('home')
@section('contenido')
<div class="container">
    <div class="row">
        @foreach ($vacantes_disponibles  as $vd)
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel panel-heading">
                    {{$vd->puesto->denominacion}}
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-responsive table-hover">
                            <tr>
                                <th>
                                    Desde
                                </th>
                                <td>
                                    {{ $vd->ofertaEmpleo->fecha_inicio }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Hasta
                                </th>
                                <td>
                                    {{ $vd->ofertaEmpleo->fecha_fin }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Tiempo de Vigencia
                                </th>
                                <td>
                                    <?php
$fecha_inicio=date_create($vd->
                                    ofertaEmpleo->fecha_inicio);
$fecha_fin=date_create($vd->ofertaEmpleo->fecha_fin);
$diff=date_diff($fecha_inicio,$fecha_fin);
echo $diff->
                                        format("%R%a días");
?>
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
                                    {{ $vd->puesto->areaConocimiento->descripcion}}
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
                                    <?php
                                  $descripcion = strip_tags($vd->
                                    descripcion, "
                                    <br/>
                                    ");
echo $descripcion;                                        
                                        ?>
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
