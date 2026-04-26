<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SPK MOORA Laravel">
    <meta name="author" content="Admin">

    <title>@yield('title', 'Admin Dashboard')</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('sbadmin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('sbadmin/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <style>
        /* Override SB Admin 2 Default Blue with TK Al Azkar Emerald Green */
        .bg-gradient-alazkar {
            background-color: #1b7a43;
            background-image: linear-gradient(180deg, #1b7a43 10%, #0c381f 100%);
            background-size: cover;
        }
        .text-primary {
            color: #1b7a43 !important;
        }
        .bg-primary {
            background-color: #1b7a43 !important;
        }
        .btn-primary {
            background-color: #1b7a43;
            border-color: #1b7a43;
        }
        .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
            background-color: #145c32 !important;
            border-color: #12522c !important;
        }
        .outline-primary {
            border-color: #1b7a43;
            color: #1b7a43;
        }
        .outline-primary:hover {
            background-color: #1b7a43;
            color: white;
        }
        .page-item.active .page-link {
            background-color: #1b7a43;
            border-color: #1b7a43;
        }
        .dropdown-item.active, .dropdown-item:active {
            background-color: #1b7a43;
        }
    </style>
    @stack('css')
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include('layouts.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('layouts.topbar')
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
                        <span>Copyright &copy; TK Al Azkar 2026</span>
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

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('sbadmin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('sbadmin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('sbadmin/js/sb-admin-2.min.js') }}"></script>

    @stack('js')
</body>

</html>
