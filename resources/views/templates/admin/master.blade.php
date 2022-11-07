<x-admin.header/>
<body onload="activer()" class="hold-transition sidebar-mini layout-fixed"  >








<div class="wrapper">
{{--  @include('templates/preloader')  --}}
@if (Session::get('pageTitle') == "Home")
<x-admin.preloader />
@endif

{{--  @include('templates/navbar')  --}}
<x-admin.navbar />
{{--  @include('templates/sidebar')  --}}
<x-admin.sidebar  />

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="position: relative">
  <!-- Content Header (Page header) -->


{{--  // default alert  --}}
@if (Session::has('message'))
<div class="alert alert-dark alert-dismissible fade show" role="alert" id="myCustomAlert" style="z-index: +2; position: absolute; right: 0;">
    {{Session::get('message')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span class="text-light" aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@if ($errors->any())
<div class="alert bg-primary alert-dismissible fade show" role="alert" id="myCustomAlert" style="z-index: +2; position: absolute; right: 0;">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span class="text-light" aria-hidden="true">&times;</span>
    </button>
</div>
@endif


 <script>
    function hiddable(){
        let myCustomAlert = document.getElementById('myCustomAlert');
    myCustomAlert.style.display = 'none';
    }
setTimeout(hiddable, 5000);
 </script>



  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">
            @if (Session::has('pageTitle'))
            {{Session::get('pageTitle')}}
            @endif
          </h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            {{--  @yield('pagename')  --}}
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
