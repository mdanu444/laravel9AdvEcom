<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@if(Session::has('pageTitle'))
    {{Session::get('pageTitle')}}
  @endif</title>
  {{--  <!-- jQuery -->  --}}
  <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
  {{--  <!-- jQuery UI 1.11.4 -->  --}}
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>


  {{--  Select js 2  --}}
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  {{--  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->  --}}
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  {{--  <!-- Bootstrap 4 -->  --}}
  <script src={{ asset("plugins/bootstrap/js/bootstrap.bundle.min.js") }}></script>
  {{--  <!-- ChartJS -->  --}}
  <script src={{ asset("plugins/chart.js/Chart.min.js") }}></script>
  {{--  <!-- Sparkline -->  --}}
  <script src={{ asset("plugins/sparklines/sparkline.js") }}></script>
  {{--  <!-- JQVMap -->  --}}
  <script src={{ asset("plugins/jqvmap/jquery.vmap.min.js") }}></script>
  <script src={{ asset("plugins/jqvmap/maps/jquery.vmap.usa.js") }}></script>
  {{--  <!-- jQuery Knob Chart -->  --}}
  <script src={{ asset("plugins/jquery-knob/jquery.knob.min.js") }}></script>
  {{--  <!-- daterangepicker -->  --}}
  <script src={{ asset("plugins/moment/moment.min.js") }}></script>
  <script src={{ asset("plugins/daterangepicker/daterangepicker.js") }}></script>
  {{--  <!-- Tempusdominus Bootstrap 4 -->  --}}
  <script src={{ asset("plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js") }}></script>
  {{--  <!-- Summernote -->  --}}
  <script src={{ asset("plugins/summernote/summernote-bs4.min.js") }}></script>
  {{--  <!-- overlayScrollbars -->  --}}
  <script src={{ asset("plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js") }}></script>
  {{--  <!-- AdminLTE App -->  --}}
  <script src={{ asset("dist/js/adminlte.js") }}></script>
  {{--  <!-- AdminLTE for demo purposes -->  --}}
  {{--  <script src={{ asset("dist/js/demo.js") }}></script>  --}}
  {{--  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->  --}}
  <script src={{ asset("dist/js/pages/dashboard.js") }}></script>







  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href={{ asset("plugins/fontawesome-free/css/all.min.css")}}>
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href={{ asset("plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css")}}>
  <!-- iCheck -->
  <link rel="stylesheet" href={{ asset("plugins/icheck-bootstrap/icheck-bootstrap.min.css")}}>
  <!-- JQVMap -->
  <link rel="stylesheet" href={{ asset("plugins/jqvmap/jqvmap.min.css")}}>
  <!-- Theme style -->
  <link rel="stylesheet" href={{ asset("dist/css/adminlte.min.css")}}>
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href={{ asset("plugins/overlayScrollbars/css/OverlayScrollbars.min.css")}}>
  <!-- Daterange picker -->
  <link rel="stylesheet" href={{ asset("plugins/daterangepicker/daterangepicker.css")}}>
  <!-- summernote -->
  <link rel="stylesheet" href={{ asset("plugins/summernote/summernote-bs4.min.css")}}>


</head>
