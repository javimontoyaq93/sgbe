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
        <a class="btn btn-primary btn-lg active" href="{{ route('crear-empleador') }}" type="button">
            Crear
        </a>
    </div>
</div>
@endsection
