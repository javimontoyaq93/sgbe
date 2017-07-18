<ul class="nav nav-pills nav-stacked well">
    <li class="active">
        <a href="#">
            Home
        </a>
    </li>
    <li>
        @if (Session::get(Auth::user()->name)->super_user)
        <a href="{{ route('empleadores') }}">
            Administrarar Empleadores
        </a>
        @endif
    </li>
    <li>
        @if (Session::get(Auth::user()->name)->super_user || Session::get(Auth::user()->name)->usuarioEmpleador)
        <a href="{{ route('puestos') }}">
            Administrar Puestos
        </a>
        @endif
    </li>
    <li>
        @if (Session::get(Auth::user()->name)->super_user || Session::get(Auth::user()->name)->usuarioEmpleador)
        <a href="{{ route('ofertasEmpleo') }}">
            Administrar Ofertas de Empleo
        </a>
        @endif
    </li>
    <li>
        @if (Session::get(Auth::user()->name)->super_user)
        <a href="{{ route('postulantes') }}">
            Administrar Postulantes
        </a>
        @endif
    </li>
    <li>
        @if (Session::get(Auth::user()->name)->super_user || Session::get(Auth::user()->name)->usuarioPostulante)
        <a href="{{ route('vacantes-disponibles') }}">
            Vacantes Disponibles
        </a>
        @endif
    </li>
    <li>
        @if (Session::get(Auth::user()->name)->usuarioPostulante)
        <a href="{{ route('show-postulante',Session::get(Auth::user()->name)->usuarioPostulante->postulante_id),Session::get(Auth::user()->name)->id }}">
            Actualizar Datos
        </a>
        @endif
         @if (Session::get(Auth::user()->name)->usuarioEmpleador)
        <a href="{{ route('show-empleador',Session::get(Auth::user()->name)->usuarioEmpleador->empleador_id) ,Session::get(Auth::user()->name)->id}}">
            Actualizar Datos
        </a>
        @endif
    </li>
</ul>