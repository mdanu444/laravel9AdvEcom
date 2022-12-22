@extends('frontend.master')
@section('mainbody')
<div class="span9" >
				<div class="well well-small">
					<h4>Featured Products <small class="pull-right">{{ $numberofproduct }} featured products</small></h4>
					<div class="row-fluid">
						<div id="featured" class="carousel slide">
							<div class="carousel-inner">
                                @php
                                    $i = 0;
                                @endphp
                            @foreach ($featured_products as $featured_product)
								<div class="item {{  $i == 0 ? 'active':''}}">
									<ul class="thumbnails">
                                        @foreach ($featured_product as $featured)
										<li class="span3">
											<div class="thumbnail">
												<i class="tag"></i>
												<a href="{{ route('frontend.product_details', ['id' => $featured['id']]) }}"><img src={{ asset("images/product_image/small/".$featured['image'])}} alt=""></a>
												<div class="caption">
													<h5>{{ Str::words($featured['title'],5) }}</h5>
													<h4><a class="btn" href="{{ route('frontend.product_details', ['id' => $featured['id']]) }}">VIEW</a> <span class="pull-right">Rs.{{ $featured['price'] }}</span></h4>
												</div>
											</div>
										</li>
                                    @endforeach
									</ul>
								</div>
@php
    $i++;
@endphp
                            @endforeach
							</div>
							<a class="left carousel-control" href="#featured" data-slide="prev">‹</a>
							<a class="right carousel-control" href="#featured" data-slide="next">›</a>
						</div>
					</div>
				</div>
				<h4>Latest Products </h4>
				<ul class="thumbnails">
                    @foreach ($collection as $item)
					<li class="span3">
						<div class="thumbnail">
							<a  href="{{ route('frontend.product_details', ['id' => $featured['id']]) }}"><img src={{ asset("images/product_image/small/".$item->image)}} alt=""/></a>
							<div class="caption">
								<h5>{{ Str::words($item->title, 5)}}</h5>
								<p>
									{{ Str::words($item->description, 8)}}
								</p>

								<h4 style="text-align:center"><a class="btn" href="{{ route('frontend.product_details', ['id' => $featured['id']]) }}"> <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">Rs.{{ $item->price}}</a></h4>
							</div>
						</div>
					</li>
                    @endforeach
				</ul>

    </div>


@endsection

