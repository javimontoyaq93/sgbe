<ul class="nav nav-pills nav-stacked">
    <li class="active">
        <a href="#">
            Home
        </a>
    </li>
    <li>
        <a href="{{ route('empleadores') }}">
            Administrarar Empleadores
        </a>
    </li>
    <li>
        @if (Session::get(Auth::user()->name)->super_user)
        <a href="#">
            Administrar Usuarios
        </a>
        @endif
    </li>
    <li>
        @if (Session::get(Auth::user()->name)->super_user)
        <a href="#">
            Administrar Roles
        </a>
        @endif
    </li>
</ul>