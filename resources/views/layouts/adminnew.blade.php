@include('admin.includes.headerstart')
  @section ('headerLinks')
{{-- Font Awesome Icons --}}
  <link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
  {{-- Theme style --}}
  {{-- <link rel="stylesheet" href="{{ asset('assets/admin/dist/css/adminlte.min.css') }}"> --}}
  {{-- Google Font: Source Sans Pro --}}
  <link rel="stylesheet" href="{{ asset('assets/admin/fonts/SansPro/SansPro.min.css') }}">
  {{-- <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap_rtl-v4.2.1/bootstrap.min.css') }}"> --}}
  <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap-4.0.0-dist/css/bootstrap.min.css') }}">
  {{-- <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap_rtl-v4.2.1/custom_rtl.css') }}"> --}}
  <link rel="stylesheet" href="{{ asset('assets/admin/css/myNewStyle.css') }}">

  <script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>
  @show
</head>
<body class="hold-transition sidebar-mini" dir="rtl">
<div class="wrapper">

 
  @include('admin.includes.contentsnew')
 
  @include('admin.includes.footer')
</div>
{{--   ./wrapper   --}}

  {{-- -- REQUIRED SCRIPTS -- --}}
  @section('footerLinks')
  {{-- jQuery  --}}

  {{-- Bootstrap 4  --}}
  <script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
  {{-- <script async src="https://cdn.jsdelivr.net/npm/es-module-shims@1/dist/es-module-shims.min.js" crossorigin="anonymous"></script> --}}

  <script src="{{ asset('assets/admin/dist/js/adminlte.min.js') }}"></script>
  @show

  @yield('script')
</body>
</html>
