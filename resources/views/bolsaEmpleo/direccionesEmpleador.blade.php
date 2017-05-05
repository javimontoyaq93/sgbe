<div class="container">
    <div class="row">
        <br/>
        <div class="panel panel-primary">
            <div class="panel-body">
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
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
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $direcciones->links() }}
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <a class="btn btn-primary btn-lg active" href="{{ route('crear-direccion-empleador',$empleador->id) }}" type="button">
                            Crear
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>