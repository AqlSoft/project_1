@include('admin.includes.headerstart')
@section('headerLinks')
    {{-- Font Awesome Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" 
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--<link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome-free/css/all.min.css') }}">-->
    {{-- Bootstrap css --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    {{-- Font Family Cairo --}}
    {{-- <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap"
        rel="stylesheet"> --}}

    {{-- Theme style --}}
    <link rel="stylesheet" href="{{ asset('assets/admin/dist/css/adminlte.css') }}">

    {{-- <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap_rtl-v4.2.1/custom_rtl.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/admin/css/mycustomstyle.css') }}">

@show
@yield('header_includes')
</head>

<body class="hold-transition sidebar-mini" dir="rtl">
    <div class="wrapper">

        {{-- Navbar --}}
        @include('admin.includes.navbar')
        {{-- /.navbar --}}

        {{-- Main Sidebar Container --}}
        @include('admin.includes.sidebar')

        {{-- Content Wrapper. Contains page content --}}
        @include('admin.includes.contents')
        {{-- /.content-wrapper --}}

        {{-- Modals here --}}
        @yield('modals')
        {{-- Modals here --}}

        {{-- Main Footer --}}
        @include('admin.includes.footer')
    
    </div>

    {{--   ./wrapper   --}}

    {{-- -- REQUIRED SCRIPTS -- --}}
    @section('footerLinks')
        {{-- jQuery  --}}
        <script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>
        {{-- Bootstrap 4  --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
        </script>
        {{-- Data Tables --}}
        <script src="{{ asset('assets/admin/dist/js/adminlte.min.js') }}"></script>
        <script src="{{ asset('assets\admin\js\myscripts.js') }}"></script>
    @show 

    @yield('script')
</body>

</html>
