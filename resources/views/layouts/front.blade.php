@include('admin.includes.headerstart')
@section('headerLinks')
    {{-- Font Awesome Icons --}}
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
    {{-- Theme style --}}
    <link rel="stylesheet" href="{{ asset('assets/admin/dist/css/adminlte.min.css') }}">
    {{-- Google Font: Source Sans Pro --}}
    <link rel="stylesheet" href="{{ asset('assets/admin/fonts/SansPro/SansPro.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap_rtl-v4.2.1/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap_rtl-v4.2.1/custom_rtl.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/mycustomstyle.css') }}">
@show

</head>

<body class="hold-transition sidebar-mini ">
    <div class="wrapper front">

        {{-- Navbar --}}
        {{-- @include('admin.includes.homenavbar') --}}
        {{-- /.navbar --}}

        {{-- Content Wrapper. Contains page content --}}
        @include('admin.includes.contents')
        {{-- /.content-wrapper --}}

        {{-- Control Sidebar --}}
        <aside class="control-sidebar control-sidebar-dark">
            {{--  Control sidebar content goes here  --}}
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        {{-- /.control-sidebar --}}

        {{-- Main Footer --}}
        @include('admin.includes.footer')
    </div>
    {{--   ./wrapper   --}}

    {{-- -- REQUIRED SCRIPTS -- --}}
    @section('footerLinks')
        {{-- jQuery  --}}
        <script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>
        {{-- Bootstrap 4  --}}
        <script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        {{-- AdminLTE App  --}}
        <script src="{{ asset('assets/admin/dist/js/adminlte.min.js') }}"></script>
    @show
</body>

</html>
