<x-frontend.header />
<x-frontend.navbar/>
<!-- Header End====================================================================== -->
@if (Session::has('pagetitle'))
    @if(Session::get('pagetitle') == 'Home')
        <x-frontend.carousel/>
    @endif
@endif
<div id="mainBody">
	<div class="container">
		<div class="row">
<x-frontend.sidebar/>
@yield('mainbody')
</div>
</div>
</div>

<x-frontend.footer />
