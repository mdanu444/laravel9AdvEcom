<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src={{ asset($sitelogo)}} alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">{{ $siteName }}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src={{ asset(Auth::guard('admin')->check() ? url('storage/'.Auth::guard('admin')->user()->photo) : "images/unknown.webp" )}} class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ Auth::guard('admin')->check() ? Auth::guard('admin')->user()->name : "Unknown"}}</a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    {{--  <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append"
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>  --}}




    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="{{route('admin.home')}}" class="nav-link @if(Session::get('pageTitle') == 'Home')
            active
          @endif">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
              <i class="right "></i>
            </p>
          </a>
        </li>
        <li class="nav-item {{Session::get('pageTitle') == 'Profile' ? 'menu-open':''}}">
          <a href="" class="nav-link {{Session::get('pageTitle') == 'Profile' ? 'active ':''}}">
            <i class="nav-icon fa fa-user"></i>
            <p>
              Profile
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('admin.profile.changePassword')}}" class="nav-link   activable" activable="pwdchange" onclick="linkactiver(event)">
                <i class="far fa-circle nav-icon"></i>
                <p>Change Password</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('admin.profile.update')}}" class="nav-link   activable" activable="profileupdate" onclick="linkactiver(event)">
                <i class="far fa-circle nav-icon"></i>
                <p>Update Profile</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item {{Session::get('pageTitle') == 'Product Category' ? 'menu-open ':''}}">
          <a href="" class=" nav-link {{Session::get('pageTitle') == 'Product Category' ? 'active ':''}}">
            <i class="nav-icon fa fa-clipboard"></i>
            <p>
                Product Category
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('admin.productsections.index')}}" class="nav-link    activable" activable="productsection" onclick="linkactiver(event)">
                <i class="far fa-circle nav-icon"></i>
                <p>Section</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('admin.productcategory.index')}}" class="nav-link   activable" activable="productcategory" onclick="linkactiver(event)">
                <i class="far fa-circle nav-icon"></i>
                <p>Category</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('admin.productsubcategory.index')}}" class="nav-link   activable" activable="productsubcategory" onclick="linkactiver(event)">
                <i class="far fa-circle nav-icon"></i>
                <p>Sub Category</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
  <script>
    function linkactiver(event){
        event.preventDefault();
        let parent = event.target.parentNode;
        if(parent.getAttribute('activable')){
            let attribute = parent.getAttribute('activable');
            //console.log(parent.getAttribute('activable'))
           sessionStorage.setItem('activer', attribute);
           //console.log(sessionStorage.getItem('activer'));
           window.location = parent.getAttribute('href');
        }else{
            let attribute = parent.childNodes[1].getAttribute('activable');
            //console.log(parent.childNodes[1].getAttribute('activable'))
            sessionStorage.setItem('activer', attribute);
            //console.log(sessionStorage.getItem('activer'));
            window.location = parent.childNodes[1].getAttribute('href');
        }
    }
    function activer(){
        let activables = document.querySelectorAll('.activable');
        for (let activable of activables){
            if (activable.getAttribute('activable') == sessionStorage.getItem('activer')){
                activable.classList.add('active');
            }
        }
    }
  </script>
</aside>
