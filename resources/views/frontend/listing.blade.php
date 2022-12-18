@extends('frontend.master')
@section('mainbody')
<div class="span9">
    <ul class="breadcrumb">
        <li><a href="{{  route('frontend.index')}}">Home</a> </li>
        @if (isset($category))
        <span class="divider">/</span>
        <li class=@if(!isset($subcategory)) {{ "active" }} @endif><a href="{{url('c/'.$category->url)}}">{{ $category->title}}</a></li>
        @endif
        @if (isset($subcategory))
        <span class="divider">/</span>
        <li class="active"><a href="{{url($subcategory->url)}}">{{ $subcategory->title}}</a></li>
        @endif
    </ul>
    <h3>
        @if(isset($category) && !isset($subcategory))
            {{ $category->title}}
        @elseif(isset($subcategory))
            {{ $subcategory->title}}
        @endif
        <small class="pull-right"> {{$numberofproducts}} products are available </small></h3>
    <hr class="soft"/>
    <p>
        @if(isset($category) && !isset($subcategory))
            {{ $category->description}}
        @elseif(isset($subcategory))
            {{ $subcategory->description}}
        @endif
    </p>
    <hr class="soft"/>
    <form id="productsortform" class="form-horizontal span6">
        <div class="control-group">
            <label class="control-label alignL">Sort By </label>
            <select onchange="productsort()" name="sort">
                <option  >Select</option>
                <option @if(isset($_GET['sort']) && $_GET['sort'] == 'latest') {{ "selected" }} @endif value="latest">Latest</option>
                <option @if(isset($_GET['sort']) && $_GET['sort'] == 'by-lowest-price') {{ "selected" }} @endif value="by-lowest-price">Sort By Lowest Price</option>
                <option @if(isset($_GET['sort']) && $_GET['sort'] == 'by-heighest-price') {{ "selected" }} @endif value="by-heighest-price">Sort By Heighest Price</option>
            </select>
        </div>
    </form>

    <div id="myTab" class="pull-right">
        <a href="#listView" data-toggle="tab"><span class="btn btn-large"><i class="icon-list"></i></span></a>
        <a href="#blockView" data-toggle="tab"><span class="btn btn-large btn-primary"><i class="icon-th-large"></i></span></a>
    </div>
    <br class="clr"/>
    <div class="tab-content">
        <div class="tab-pane" id="listView">
            @foreach ($products as $product)


            <div class="row">
                <div class="span2">
                    <img src={{  url('images/product_image/small/'.$product->image)}} alt=""/>
                </div>
                <div class="span4">
                    <h3>New | Available</h3>
                    <hr class="soft"/>
                    <h5>{{  $product->title}} </h5>
                    <p>
                        {{  Str::words($product->description, 25)}}
                    </p>
                    <a class="btn btn-small pull-right" href="product_details.html">View Details</a>
                    <br class="clr"/>
                </div>
                <div class="span3 alignR">
                    <form class="form-horizontal qtyFrm">
                        <h3> Rs. {{  $product->price}}</h3>
                        <label class="checkbox">
                            <input type="checkbox">  Adds product to compair
                        </label><br/>

                        <a href="product_details.html" class="btn btn-large btn-primary"> Add to <i class=" icon-shopping-cart"></i></a>
                        <a href="product_details.html" class="btn btn-large"><i class="icon-zoom-in"></i></a>

                    </form>
                </div>
            </div>
            <hr class="soft"/>
         @endforeach
        </div>
        <div class="tab-pane  active" id="blockView">
            <ul class="thumbnails">
                @foreach ($products as $product)
                <li class="span3">
                    <div class="thumbnail">
                        <a href="product_details.html"><img  src={{url("images/product_image/small/".$product->image)}} alt=""/></a>
                        <div class="caption">
                            <h5>{{ Str::words($product->title, 4)}}</h5>
                            <p>
                                {{  Str::words($product->description, 11)}}
                            </p>
                            <h4 style="text-align:center"><a class="btn" href="product_details.html"> <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">Rs.{{ $product->price}}</a></h4>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            <hr class="soft"/>
        </div>
    </div>
    <a href="compair.html" class="btn btn-large pull-right">Compair Product</a>
    <div class="pagination">
        <ul>
            @if (isset($_GET['sort']) && $_GET['sort'] != "")
                {{ $products->appends(['sort'=>$_GET['sort']])->links() }}
            @else
            {{ $products->links() }}
            @endif
        </ul>
    </div>
    <br class="clr"/>
</div>

<script>
    function productsort(){
        document.getElementById("productsortform").submit();
    }
</script>
@endsection
