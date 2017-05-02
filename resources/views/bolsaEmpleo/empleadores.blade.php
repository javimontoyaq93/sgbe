@extends('home')
@section('contenido')
<div class="container">
    <div class="row">
        <table class="table">
            <thead>
                <tr>
                    <th>
                        Razón Social
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
                        {{ $empleador->celular }}
                    </td>
                    <td>
                        {{ $empleador->email }}
                    </td>
                    <td>
                        <a class="btn btn-primary btn-lg " href="{{ route('show-empleador',$empleador->id) }}" type="button">
                            Editar
                        </a>
                        <button class="btn btn-default btn-lg" type="button">
                            Eliminar
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <a class="btn btn-primary btn-lg active" href="{{ route('crear-empleador') }}" type="button">
            Crear
        </a>
    </div>
</div>
@endsection
