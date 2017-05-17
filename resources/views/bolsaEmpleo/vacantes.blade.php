<div class="container">
    <div class="row">
        <br/>
        <div class="panel panel-default ">
            <div class="panel-body">
                <table class="table table-hover table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>
                                Denominación
                            </th>
                            <th>
                                Nivel de Instrucción
                            </th>
                            <th>
                                Número de Vacantes
                            </th>
                            <th>
                                Remuneración
                            </th>
                            <th>
                                Años de Experiencia
                            </th>
                            <th>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vacantes as $vacante)
                        <tr>
                            <td>
                                {{ $vacante->puesto->denominacion }}
                            </td>
                            <td>
                                {{ $vacante->puesto->nivelInstruccion->descripcion }}
                            </td>
                            <td>
                                {{ $vacante->numero_vacante}}
                            </td>
                            <td>
                                {{ $vacante->puesto->remuneracion }}
                            </td>
                            <td>
                                {{ $vacante->puesto->tiempo_experiencia }}
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="col-sm-6 ">
                                        <a class="btn btn-primary" href="{{ route('show-vacante',$vacante->id) }}" type="button">
                                            Editar
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $vacantes->links() }}
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <a class="btn btn-primary btn-lg" href="{{ route('crear-vacante',$ofertaEmpleo->id) }}" type="button">
                            Crear
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>