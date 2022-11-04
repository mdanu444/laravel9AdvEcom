@include('templates/header')
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
@include('templates/preloader')
{{--  <x-preloader />  --}}
@include('templates/navbar')
{{--  <x-navbar />  --}}
@include('templates/sidebar')
{{--  <x-sidebar />  --}}


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            @if (Session::has('pageTitle'))
                {{Session::get('pageTitle')}}
            @endif
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  <!-- Main content -->
  <section class="content">





 @yield('main_content')





</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->


@include('templates/footer')
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

@include('templates/scripts')
{{--  <x-scripts />  --}}
</body>
</html>
