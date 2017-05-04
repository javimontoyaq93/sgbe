<div class="container">
    <div class="row">
        {{ $empleador->direcciones }}
        <table class="table">
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
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($direcciones as $direccion)
                <tr>
                    <td>
                        {{ $direccion->empleador_id }}
                    </td>
                    <td>
                        {{ $direccion->referencia }}
                    </td>
                    <td>
                        {{ $direccion->telefono }}
                    </td>
                    <td>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <a class="btn btn-primary btn-lg active" href="{{ route('crear-direccion-empleador',$empleador->id) }}" type="button">
            Crear
        </a>
    </div>
</div>