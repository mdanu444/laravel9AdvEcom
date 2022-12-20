{{--  <!-- jQuery -->
<script src={{ asset("plugins/jquery/jquery.min.js") }}></script>
<!-- jQuery UI 1.11.4 -->
<script src={{ asset("plugins/jquery-ui/jquery-ui.min.js") }}></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src={{ asset("plugins/bootstrap/js/bootstrap.bundle.min.js") }}></script>
<!-- ChartJS -->
<script src={{ asset("plugins/chart.js/Chart.min.js") }}></script>
<!-- Sparkline -->
<script src={{ asset("plugins/sparklines/sparkline.js") }}></script>
<!-- JQVMap -->
<script src={{ asset("plugins/jqvmap/jquery.vmap.min.js") }}></script>
<script src={{ asset("plugins/jqvmap/maps/jquery.vmap.usa.js") }}></script>
<!-- jQuery Knob Chart -->
<script src={{ asset("plugins/jquery-knob/jquery.knob.min.js") }}></script>
<!-- daterangepicker -->
<script src={{ asset("plugins/moment/moment.min.js") }}></script>
<script src={{ asset("plugins/daterangepicker/daterangepicker.js") }}></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src={{ asset("plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js") }}></script>
<!-- Summernote -->
<script src={{ asset("plugins/summernote/summernote-bs4.min.js") }}></script>
<!-- overlayScrollbars -->
<script src={{ asset("plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js") }}></script>
<!-- AdminLTE App -->
<script src={{ asset("dist/js/adminlte.js") }}></script>
<!-- AdminLTE for demo purposes -->
{{--  <script src={{ asset("dist/js/demo.js") }}></script>  --}}
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src={{ asset("dist/js/pages/dashboard.js") }}></script>  --}}



  {{--  <!-- DataTables  & Plugins -->  --}}
  <script src={{ asset("plugins/datatables/jquery.dataTables.min.js")}}></script>
  <script src={{ asset("plugins/datatables-bs4/js/dataTables.bootstrap4.min.js")}}></script>
  <script src={{ asset("plugins/datatables-responsive/js/dataTables.responsive.min.js")}}></script>
  <script src={{ asset("plugins/datatables-responsive/js/responsive.bootstrap4.min.js")}}></script>
  <script src={{ asset("plugins/datatables-buttons/js/dataTables.buttons.min.js")}}></script>
  <script src={{ asset("plugins/datatables-buttons/js/buttons.bootstrap4.min.js")}}></script>
  <script src={{ asset("plugins/jszip/jszip.min.js")}}></script>
  <script src={{ asset("plugins/pdfmake/pdfmake.min.js")}}></script>
  <script src={{ asset("plugins/pdfmake/vfs_fonts.js")}}></script>
  <script src={{ asset("plugins/datatables-buttons/js/buttons.html5.min.js")}}></script>
  <script src={{ asset("plugins/datatables-buttons/js/buttons.print.min.js")}}></script>
  <script src={{ asset("plugins/datatables-buttons/js/buttons.colVis.min.js")}}></script>


<script>
    $(document).ready(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>

<script>
    if(document.querySelectorAll('.statuschanger')){
        let stataschanger = document.querySelectorAll('.statuschanger');
        for (let checkbox of stataschanger){
            checkbox.addEventListener('click', ()=>{
                let id = checkbox.getAttribute('id').split('customSwitch')[1];
                let status = checkbox.getAttribute('status');
                let url = window.location.origin+"/admin/statuschanger";
                let formData = new FormData();
                formData.append('id', id);
                formData.append('status', status);
                fetch(url, {
                    method:'post',
                    body: formData
                }).then(res => res.json())
                .then((data) =>{
                    console.log(data);
                })
            });
        };
    }

    $(document).ready(()=>{
        $(".selecttion").select2();
    })



    $(document).ready(()=>{
        if($(".selectionloader")){
            $(".selectionloader").on('select2:select', function (e) {
            let formData = new FormData();
            formData.append('id', e.target.value);
            let loadableClass = $(".selectionloader").attr('loadableClass');
            url = window.location.origin +'/'+ $(".selectionloader").attr('location');
            let loadable = $("."+loadableClass)[0];

            fetch(url, {
                method:'post',
                body: formData
            }).then(res => res.json())
            .then((data)=>{
                loadable.innerHTML = data.html
            });
        });
       }
     })

    $(document).ready(()=>{
        if($("#selectionloader")){
            $("#selectionloader").on('select2:select', function (e) {
            let formData = new FormData();
            formData.append('id', e.target.value);
            let loadableClass = $("#selectionloader").attr('loadableClass');
            url = window.location.origin +'/'+ $("#selectionloader").attr('location');
            let loadable = $("."+loadableClass)[0];

            fetch(url, {
                method:'post',
                body: formData
            }).then(res => res.json())
            .then((data)=>{
                loadable.innerHTML = data.html
            });
        });
       }
     })

        $(document).ready(()=>{


            $('.delete').click((e)=>{
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                  }).then((result) => {
                    if (result.isConfirmed) {
                        if(e.target.parentElement.classList[0] == 'delete'){
                            console.log(e.target.parentElement.parentElement);
                            e.target.parentElement.parentElement.submit();
                        }else{
                            console.log(e.target.parentElement);
                            e.target.parentElement.submit();
                        }
                    }
                  })

            })
        });




</script>
