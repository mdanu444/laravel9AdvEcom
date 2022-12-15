

@extends('frontend.master')
@section('mainbody')
<div id="mainBody">
	<div class="container">
		<div class="row">
			<!-- Sidebar ================================================== -->
			<div id="sidebar" class="span3">
				<div class="well well-small"><a id="myCart" href="product_summary.html"><img src={{ asset("frontend/themes/images/ico-cart.png")}} alt="cart">3 Items in your cart</a></div>
				<ul id="sideManu" class="nav nav-tabs nav-stacked">

					<li class="subMenu"><a>MEN</a>
						<ul>
							<li><a href="products.html"><i class="icon-chevron-right"></i><strong>T-Shirts</strong></a></li>
							<li><a href="products.html"><i class="icon-chevron-right"></i>Casual T-Shirts</a></li>
							<li><a href="products.html"><i class="icon-chevron-right"></i>Formal T-Shirts</a></li>
						</ul>
						<ul>
							<li><a href="products.html"><i class="icon-chevron-right"></i><strong>Shirts</strong></a></li>
							<li><a href="products.html"><i class="icon-chevron-right"></i>Casual Shirts</a></li>
							<li><a href="products.html"><i class="icon-chevron-right"></i>Formal Shirts</a></li>
						</ul>
					</li>
					<li class="subMenu"><a> WOMEN </a>
						<ul>
							<li><a href="products.html"><i class="icon-chevron-right"></i><strong>Tops</strong></a></li>
							<li><a href="products.html"><i class="icon-chevron-right"></i>Casual Tops</a></li>
							<li><a href="products.html"><i class="icon-chevron-right"></i>Formal Tops</a></li>
						</ul>
						<ul>
							<li><a href="products.html"><i class="icon-chevron-right"></i><strong>Dresses</strong></a></li>
							<li><a href="products.html"><i class="icon-chevron-right"></i>Casual Dresses</a></li>
							<li><a href="products.html"><i class="icon-chevron-right"></i>Formal Dresses</a></li>
						</ul>
					</li>
					<li class="subMenu"><a>KIDS</a>
						<ul>
							<li><a href="products.html"><i class="icon-chevron-right"></i><strong>T-Shirts</strong></a></li>
							<li><a href="products.html"><i class="icon-chevron-right"></i>Casual T-Shirts</a></li>
							<li><a href="products.html"><i class="icon-chevron-right"></i>Formal T-Shirts</a></li>
						</ul>
						<ul>
							<li><a href="products.html"><i class="icon-chevron-right"></i><strong>Shirts</strong></a></li>
							<li><a href="products.html"><i class="icon-chevron-right"></i>Casual Shirts</a></li>
							<li><a href="products.html"><i class="icon-chevron-right"></i>Formal Shirts</a></li>
						</ul>
					</li>
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
			<div class="span9">
				<div class="well well-small">
					<h4>Featured Products <small class="pull-right">200+ featured products</small></h4>
					<div class="row-fluid">
						<div id="featured" class="carousel slide">
							<div class="carousel-inner">
								<div class="item active">
									<ul class="thumbnails">
										<li class="span3">
											<div class="thumbnail">
												<i class="tag"></i>
												<a href="product_details.html"><img src={{ asset("frontend/themes/images/products/b1.jpg")}} alt=""></a>
												<div class="caption">
													<h5>Product name</h5>
													<h4><a class="btn" href="product_details.html">VIEW</a> <span class="pull-right">Rs.1000</span></h4>
												</div>
											</div>
										</li>
										<li class="span3">
											<div class="thumbnail">
												<i class="tag"></i>
												<a href="product_details.html"><img src={{ asset("frontend/themes/images/products/b2.jpg")}} alt=""></a>
												<div class="caption">
													<h5>Product name</h5>
													<h4><a class="btn" href="product_details.html">VIEW</a> <span class="pull-right">Rs.1000</span></h4>
												</div>
											</div>
										</li>
										<li class="span3">
											<div class="thumbnail">
												<i class="tag"></i>
												<a href="product_details.html"><img src={{ asset("frontend/themes/images/products/b3.jpg")}} alt=""></a>
												<div class="caption">
													<h5>Product name</h5>
													<h4><a class="btn" href="product_details.html">VIEW</a> <span class="pull-right">Rs.1000</span></h4>
												</div>
											</div>
										</li>
										<li class="span3">
											<div class="thumbnail">
												<i class="tag"></i>
												<a href="product_details.html"><img src={{ asset("frontend/themes/images/products/b4.jpg")}} alt=""></a>
												<div class="caption">
													<h5>Product name</h5>
													<h4><a class="btn" href="product_details.html">VIEW</a> <span class="pull-right">Rs.1000</span></h4>
												</div>
											</div>
										</li>
									</ul>
								</div>
								<div class="item">
									<ul class="thumbnails">
										<li class="span3">
											<div class="thumbnail">
												<i class="tag"></i>
												<a href="product_details.html"><img src={{ asset("frontend/themes/images/products/5.jpg")}} alt=""></a>
												<div class="caption">
													<h5>Product name</h5>
													<h4><a class="btn" href="product_details.html">VIEW</a> <span class="pull-right">Rs.1000</span></h4>
												</div>
											</div>
										</li>
										<li class="span3">
											<div class="thumbnail">
												<i class="tag"></i>
												<a href="product_details.html"><img src={{ asset("frontend/themes/images/products/6.jpg")}} alt=""></a>
												<div class="caption">
													<h5>Product name</h5>
													<h4><a class="btn" href="product_details.html">VIEW</a> <span class="pull-right">Rs.1000</span></h4>
												</div>
											</div>
										</li>
										<li class="span3">
											<div class="thumbnail">
												<a href="product_details.html"><img src={{ asset("frontend/themes/images/products/7.jpg")}} alt=""></a>
												<div class="caption">
													<h5>Product name</h5>
													<h4><a class="btn" href="product_details.html">VIEW</a> <span class="pull-right">Rs.1000</span></h4>
												</div>
											</div>
										</li>
										<li class="span3">
											<div class="thumbnail">
												<a href="product_details.html"><img src={{ asset("frontend/themes/images/products/8.jpg")}} alt=""></a>
												<div class="caption">
													<h5>Product name</h5>
													<h4><a class="btn" href="product_details.html">VIEW</a> <span class="pull-right">Rs.1000</span></h4>
												</div>
											</div>
										</li>
									</ul>
								</div>
								<div class="item">
									<ul class="thumbnails">
										<li class="span3">
											<div class="thumbnail">
												<a href="product_details.html"><img src={{ asset("frontend/themes/images/products/9.jpg")}} alt=""></a>
												<div class="caption">
													<h5>Product name</h5>
													<h4><a class="btn" href="product_details.html">VIEW</a> <span class="pull-right">Rs.1000</span></h4>
												</div>
											</div>
										</li>
										<li class="span3">
											<div class="thumbnail">
												<a href="product_details.html"><img src={{ asset("frontend/themes/images/products/10.jpg")}} alt=""></a>
												<div class="caption">
													<h5>Product name</h5>
													<h4><a class="btn" href="product_details.html">VIEW</a> <span class="pull-right">Rs.1000</span></h4>
												</div>
											</div>
										</li>
										<li class="span3">
											<div class="thumbnail">
												<a href="product_details.html"><img src={{ asset("frontend/themes/images/products/11.jpg")}} alt=""></a>
												<div class="caption">
													<h5>Product name</h5>
													<h4><a class="btn" href="product_details.html">VIEW</a> <span class="pull-right">Rs.1000</span></h4>
												</div>
											</div>
										</li>
										<li class="span3">
											<div class="thumbnail">
												<a href="product_details.html"><img src={{ asset("frontend/themes/images/products/1.jpg")}} alt=""></a>
												<div class="caption">
													<h5>Product name</h5>
													<h4><a class="btn" href="product_details.html">VIEW</a> <span class="pull-right">Rs.1000</span></h4>
												</div>
											</div>
										</li>
									</ul>
								</div>
								<div class="item">
									<ul class="thumbnails">
										<li class="span3">
											<div class="thumbnail">
												<a href="product_details.html"><img src={{ asset("frontend/themes/images/products/2.jpg")}} alt=""></a>
												<div class="caption">
													<h5>Product name</h5>
													<h4><a class="btn" href="product_details.html">VIEW</a> <span class="pull-right">Rs.1000</span></h4>
												</div>
											</div>
										</li>
										<li class="span3">
											<div class="thumbnail">
												<a href="product_details.html"><img src={{ asset("frontend/themes/images/products/3.jpg")}} alt=""></a>
												<div class="caption">
													<h5>Product name</h5>
													<h4><a class="btn" href="product_details.html">VIEW</a> <span class="pull-right">Rs.1000</span></h4>
												</div>
											</div>
										</li>
										<li class="span3">
											<div class="thumbnail">
												<a href="product_details.html"><img src={{ asset("frontend/themes/images/products/4.jpg")}} alt=""></a>
												<div class="caption">
													<h5>Product name</h5>
													<h4><a class="btn" href="product_details.html">VIEW</a> <span class="pull-right">Rs.1000</span></h4>
												</div>
											</div>
										</li>
										<li class="span3">
											<div class="thumbnail">
												<a href="product_details.html"><img src={{ asset("frontend/themes/images/products/5.jpg")}} alt=""></a>
												<div class="caption">
													<h5>Product name</h5>
													<h4><a class="btn" href="product_details.html">VIEW</a> <span class="pull-right">Rs.1000</span></h4>
												</div>
											</div>
										</li>
									</ul>
								</div>
							</div>
							<a class="left carousel-control" href="#featured" data-slide="prev">‹</a>
							<a class="right carousel-control" href="#featured" data-slide="next">›</a>
						</div>
					</div>
				</div>
				<h4>Latest Products </h4>
				<ul class="thumbnails">
					<li class="span3">
						<div class="thumbnail">
							<a  href="product_details.html"><img src={{ asset("frontend/themes/images/products/6.jpg")}} alt=""/></a>
							<div class="caption">
								<h5>Product name</h5>
								<p>
									Lorem Ipsum is simply dummy text.
								</p>

								<h4 style="text-align:center"><a class="btn" href="product_details.html"> <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">Rs.1000</a></h4>
							</div>
						</div>
					</li>
					<li class="span3">
						<div class="thumbnail">
							<a  href="product_details.html"><img src={{ asset("frontend/themes/images/products/7.jpg")}} alt=""/></a>
							<div class="caption">
								<h5>Product name</h5>
								<p>
									Lorem Ipsum is simply dummy text.
								</p>
								<h4 style="text-align:center"><a class="btn" href="product_details.html"> <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">Rs.1000</a></h4>
							</div>
						</div>
					</li>
					<li class="span3">
						<div class="thumbnail">
							<a  href="product_details.html"><img src={{ asset("frontend/themes/images/products/8.jpg")}} alt=""/></a>
							<div class="caption">
								<h5>Product name</h5>
								<p>
									Lorem Ipsum is simply dummy text.
								</p>
								<h4 style="text-align:center"><a class="btn" href="product_details.html"> <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">Rs.1000</a></h4>
							</div>
						</div>
					</li>
					<li class="span3">
						<div class="thumbnail">
							<a  href="product_details.html"><img src={{ asset("frontend/themes/images/products/9.jpg")}} alt=""/></a>
							<div class="caption">
								<h5>Product name</h5>
								<p>
									Lorem Ipsum is simply dummy text.
								</p>
								<h4 style="text-align:center"><a class="btn" href="product_details.html"> <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">Rs.1000</a></h4>
							</div>
						</div>
					</li>
					<li class="span3">
						<div class="thumbnail">
							<a  href="product_details.html"><img src={{ asset("frontend/themes/images/products/10.jpg")}} alt=""/></a>
							<div class="caption">
								<h5>Product name</h5>
								<p>
									Lorem Ipsum is simply dummy text.
								</p>
								<h4 style="text-align:center"><a class="btn" href="product_details.html"> <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">Rs.1000</a></h4>
							</div>
						</div>
					</li>
					<li class="span3">
						<div class="thumbnail">
							<a  href="product_details.html"><img src={{ asset("frontend/themes/images/products/11.jpg")}} alt=""/></a>
							<div class="caption">
								<h5>Product name</h5>
								<p>
									Lorem Ipsum is simply dummy text.
								</p>
								<h4 style="text-align:center"><a class="btn" href="product_details.html"> <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">Rs.1000</a></h4>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
@endsection
