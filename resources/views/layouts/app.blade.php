<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">


  <title>{{ config('app.name') }}</title>

    <!-- Custom fonts for this template-->
    <link href="/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->

    <link href="/admin/css/sb-admin-2.css" rel="stylesheet">

    <link rel="stylesheet" href="/css/checkbox.css">  
    <link rel="stylesheet" href="/css/toastr.min.css">
    <link rel="stylesheet" href="/css/sweetalert.min.css">
    <link rel="stylesheet" href="/css/src.css">

    <!-- PIVOT CSS -->
    <script src="/js/jquery-3.3.1.min.js"></script>
    <!-- Bootstrap CDN Plugin -->
    <script src="/js/jquery.min.js"></script>
    <script src="/js/jquery-1.11.4.min.js"></script>
    <script src="/js/loader.js"></script>  
     @livewireStyles

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-webpanel-c sidebar sidebar-dark accordion toggled" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-window-maximize"></i> 
                </div>
                <div class="sidebar-brand-text mx-3">SISTEMA TAREAS</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Inicio</span></a>
            </li>
            @role('ADMINISTRADOR')
                <li class="nav-item">
                  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFooda"
                      aria-expanded="true" aria-controls="collapseFooda">
                      <i class="fab fa-product-hunt"></i>
                      <span>Administración</span>
                  </a>
                  <div id="collapseFooda" class="collapse" aria-labelledby="headingUtilities"
                      data-parent="#accordionSidebar">
                      <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="{{url('/users')}}">Admi. Usuarios</a> 
                            <!--a class="collapse-item" href="{{url('/roles')}}">Admi. Roles</a-->
                            <!--a class="collapse-item" href="{{url('/permissions')}}">Admi. Permisos</a-->
                            <!--Nav Bar Hooks - Do not delete!!-->
                            <a href="{{ url('/groups') }}" class="collapse-item"> Admin. Grupos</a>
                            <a href="{{ url('/departments') }}" class="collapse-item">Admin. Departamentos</a>
                      </div>
                  </div>
                </li>
            @endrole




            @role('ADMINISTRADOR|USUARIO')
                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFooda6"
                        aria-expanded="true" aria-controls="collapseFooda6">
                        <i class="fab fa-product-hunt"></i>
                        <span>Transacciones</span>
                    </a>
                    <div id="collapseFooda6" class="collapse" aria-labelledby="headingUtilities"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="{{route('tasks.index')}}">Adm. Tareas</a> 
                            <a class="collapse-item" href="#">Tareas Asignadas</a>
                            <a class="collapse-item" href="#">Tareas Realizadas</a>  
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFooda7"
                        aria-expanded="true" aria-controls="collapseFooda7">
                        <i class="fab fa-product-hunt"></i>
                        <span>Reportes</span>
                    </a>
                    <div id="collapseFooda7" class="collapse" aria-labelledby="headingUtilities"
                        data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                            <a class="collapse-item" href="#">Detallado</a> 
                            <a class="collapse-item" href="#">Resumido</a> 
                        </div>
                    </div>
                </li>

            @endrole








            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                          <li class="nav-item dropdown">
                              <a style="font-size: 14px;" id="navigation" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre style="color: black;">
                                    @if(Auth::user()->person)
                                        {{ strtoupper(Auth::user()->person->last_name) }} {{ strtoupper(Auth::user()->person->name) }}
                                    @endif
                              </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                  onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                  {{ __('Cerrar sesión') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                  @csrf
                                </form>
                            </div>
                            
                          </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    @yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; @ 2023</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- AdminLTE App -->
    @livewireScripts
    <script src="/dist/js/adminlte.min.js"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="/admin/vendor/jquery/jquery.min.js"></script>
    <script src="/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/admin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/admin/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="/admin/vendor/chart.js/Chart.min.js"></script>

    <!--NUEVOS-->
    <script src="/js/sweetalert.min.js"></script>
    <!--SELECT 2-->
    <script src="/plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!--Datatable -->
    <script src="/js/bootstrap-show-password.js"></script>
    <script type="text/javascript" src="/js/toastr.min.js"></script>
    <!-- bs-custom-file-input -->

    <script type="text/javascript">
        window.livewire.on('closeModal', () => {
            $('#createDataModal').modal('hide');
        });
    </script>


    <script>
        $("#success-alert").fadeTo(1000, 200).slideUp(200, function(){
        $("#success-alert").slideUp(200);
            });
        //Datemask dd/mm/yyyy
    </script>

    <script> 
      @if (Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}"

        switch(type){

        case 'info':
          toastr.options.timeOut = 10000;
          toastr.info("{{Session::get('message')}}");
        break;

        case 'success':
          toastr.options.timeOut = 10000;
          toastr.success("{{Session::get('message')}}");
        break;

        case 'warning':
          toastr.options.timeOut = 10000;
          toastr.warning("{{Session::get('message')}}");
        break;

        case 'error':
          toastr.options.timeOut = 10000;
          toastr.error("{{Session::get('message')}}");
        break;
                }
      @endif
    </script>

</body>

</html>