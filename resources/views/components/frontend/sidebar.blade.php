@php
use App\Models\Admin\ProductSection;
$navsections = ProductSection::orderBy('id', 'desc')->get();
@endphp
<!-- Sidebar ================================================== -->
			<div id="sidebar" class="span3">
				<div class="well well-small"><a id="myCart" href="product_summary.html"><img src={{ asset("frontend/themes/images/ico-cart.png")}} alt="cart">3 Items in your cart</a></div>
				<ul id="sideManu" class="nav nav-tabs nav-stacked">
@foreach ($navsections as $section)
    @if (count($section->product_categories) > 0)


					<li class="subMenu"><a>{{ $section->title}}</a>
						<ul>
        @foreach ($section->product_categories as $category)

							<li><a href="products.html"><strong>{{  $category->title  }}</strong></a></li>
            @foreach ($category->product_sub_categories as $sub)
                    <li><a href="products.html"><i class="icon-chevron-right"></i>{{  $sub->title }}</></a></li>
            @endforeach
        @endforeach
						</ul>
					</li>
    @endif
@endforeach
				</ul>
				<br/>
				<div class="thumbnail">
					<img src={{ asset("frontend/themes/images/payment_methods.png")}} title="Payment Methods" alt="Payments Methods">
					<div class="caption">
						<h5>Payment Methods</h5>
					</div>
				</div>
			</div>
			<!-- Sidebar end=============================================== -->
