<div class="content-wrapper">
  {{-- Content Header (Page header) --}}
  <div class="content-header">

    @include('admin.includes.topheader')

  </div>
  {{-- /.content-header --}}

  {{-- Main content --}}
  <div class="content">
    <div class="container-fluid">
      @include('admin.includes.alerts.failure')
      @include('admin.includes.alerts.success')
      @yield('content')
    </div>{{-- /.container-fluid --}}
  </div>
  {{-- /.content --}}
</div>