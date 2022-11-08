<script>


    $("#selectionloader").on('select2:select', (e)=>{
        let loader = e.target;
        let url = loader.getAttribute('action')
        let loadableClass = loader.getAttribute('loadableClass');
        let loadable = $("."+loadableClass)[0];
        let formData = new FormData();
        formData.append('section', loader.value);
        fetch(url, {
            'method': 'post',
            'body': formData,

        }).then(res =>res.json()).then((data) =>{
            loadable.innerHTML = data.html;
        })

    });
</script>
<footer class="main-footer">
    <strong>Copyright &copy; 2022-2022 <a href="https://adminlte.io">Md. Anwar Hossain</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>
