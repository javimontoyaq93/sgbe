<div class="container">
    <div class="row">
        <br/>
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>
                                Pais
                            </th>
                            <th>
                                Provincia
                            </th>
                            <th>
                                Ciudad
                            </th>
                            <th>
                                Dirección
                            </th>
                            <th>
                                Referencia
                            </th>
                            <th>
                                Teléfono
                            </th>
                            <th>
                                Tipo de Dirección
                            </th>
                            <th>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($direcciones as $direccion)
                        <tr>
                            <td>
                                @if($direccion->direccion->pais)
                                {{ $direccion->direccion->getPais->descripcion }}
                                @endif
                            </td>
                            <td>
                                @if($direccion->direccion->provincia)
                                {{ $direccion->direccion->getProvincia->descripcion }}
                                @endif
                            </td>
                            <td>
                                @if($direccion->direccion->ciudad)
                                {{ $direccion->direccion->getCiudad->descripcion }}
                                @endif
                            </td>
                            <td>
                                {{ $direccion->direccion->calles }}
                            </td>
                            <td>
                                {{ $direccion->direccion->referencia }}
                            </td>
                            <td>
                                {{ $direccion->direccion->telefono }}
                            </td>
                            <td>
                                {{ $direccion->direccion->tipoDireccion->descripcion }}
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="col-sm-6 ">
                                        <a class="btn btn-primary" href="{{ route('show-direccion-postulante',$direccion->id) }}" type="button">
                                            Editar
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $direcciones->links() }}
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <a class="btn btn-primary btn-lg" href="{{ route('crear-direccion-postulante',$postulante->id) }}" type="button">
                            Crear
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>