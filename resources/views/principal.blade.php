<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema TenderPos">
    <meta name="author" content="Mario Muñoz">
    <meta name="keyword" content="Mario Muñoz">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>Home | TenderPos</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.bundle.js"></script>



    <!---initial laravel mix css -->
    <link href="css/plantilla.css" rel="stylesheet">
        <!-- end laravel mix css -->

</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
<div id="app">
    <header class="app-header navbar">
        <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="nav navbar-nav d-md-down-none">
            <li class="nav-item px-3">
                <a class="nav-link" @click="menu=0">Escritorio</a>
            </li>
            <li class="nav-item px-3">
                <a class="nav-link" @click="menu=15">Configuraciones</a>
            </li>
        </ul>
        <ul class="nav navbar-nav ml-auto">
            
            <Notificacion></Notificacion>


            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <img src="/img/tenderpos.png" class="img-avatar" alt="admin@bootstrapmaster.com">
                    <span class="d-md-down-none">{{Auth::user()->usuario}}  </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>Cuenta</strong>
                    </div>
                    @if(Auth::user()->idrol=='1')
                    <a @click="menu=15" class="dropdown-item" href="#"><i class="fa fa-user"></i> Perfil</a>
                    @endif
                    <a class="dropdown-item" href="{{ url('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    ><i class="fa fa-lock"></i> Cerrar sesión</a>


            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
            </form>
            
                </div>
            </li>
        </ul>
    </header>







        <div class="app-body">

        @if(Auth::check())
        
            @if(Auth::user()->idrol==1)
            <!--menu lateral-->
            @include('plantilla.menuLateralAdmin')
            <!--end menu lateral-->
            @elseif(Auth::user()->idrol==2)
            @include('plantilla.menuLateralVendedor')
            @elseif(Auth::user()->idrol==3)
            @include('plantilla.menuLateralAlmacenero')
           @else

           @endif 
        @endif

            <!-- Contenido Principal -->
            @yield('contenido')
            <!-- /Fin del contenido principal -->
    </div>
    <!--end vue-->
    </div>
    <!--end vue-->

    <footer class="app-footer">
        <span><a href="http://www.incanatoit.com/">Todos los derechos reservado</a> &copy; 2021</span>
        <span class="ml-auto">Desarrollado por <a href="https://subliowen.com/">subliowen</a></span>
    </footer>

</body>



<script src="js/app.js"></script>
<!--initial laravel mix js-->
<script src="js/plantilla.js"></script>
<!--end laravel mix js-->

</html>