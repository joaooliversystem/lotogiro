<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item d-lg-none">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item pl-3">
            Saldo: R${{\App\Helper\Money::toReal(auth()->user()->balance)}}
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
               <i class="fas fa-cog"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                <p class="px-2 pt-1">
                    Olá, {{auth()->user()->name}}
                </p>
                @can('read_user')
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{route('admin.settings.users.edit', ['user' => auth()->user()->id])}}">
                    <i class="fas fa-user mr-2"></i> Conta
                </a>
                @endcan
                @can('edit_all')
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{route('admin.settings.users.edit', ['user' => auth()->user()->id])}}">
                    <i class="fas fa-user mr-2"></i> Conta
                </a> 
                @endcan
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{route('admin.logout')}}">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
