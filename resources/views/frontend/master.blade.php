<x-frontend.header />
<x-frontend.navbar/>
<!-- Header End====================================================================== -->
@if (Session::has('pagetitle'))
    @if(Session::get('pagetitle') == 'home')
        <x-frontend.carousel/>
    @endif
@endif
@yield('mainbody')
<x-frontend.footer />
