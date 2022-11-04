<x-admin.header/>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
{{--  @include('templates/preloader')  --}}
<x-admin.preloader />
{{--  @include('templates/navbar')  --}}
<x-admin.navbar />
{{--  @include('templates/sidebar')  --}}
<x-admin.sidebar />


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">@yield('title')</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            @yield('pagename')
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


{{--  @include('templates/footer')  --}}
<x-admin.footer />
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<x-admin.scripts/>
{{--  <x-admin.scripts />  --}}
</body>
</html>
