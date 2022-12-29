@php
    use App\Models\Cart;
@endphp

@extends('frontend.master')
@section('mainbody')
<style>
    th, td{
        vertical-align: center !important;
        line-height: 1;
      }
</style>
<div class="span9">
    <ul class="breadcrumb">
		<li><a href="index.html">Home</a> <span class="divider">/</span></li>
		<li class="active"> SHOPPING CART</li>
    </ul>
	<h3>  SHOPPING CART [ <small>3 Item(s) </small>]<a href="products.html" class="btn btn-large pull-right"><i class="icon-arrow-left"></i> Continue Shopping </a></h3>
	<hr class="soft"/>
	<table class="table table-bordered">
		<tr><th> I AM ALREADY REGISTERED  </th></tr>
		 <tr>
		 <td>
			<form class="form-horizontal">
				<div class="control-group">
				  <label class="control-label" for="inputUsername">Username</label>
				  <div class="controls">
					<input type="text" id="inputUsername" placeholder="Username">
				  </div>
				</div>
				<div class="control-group">
				  <label class="control-label" for="inputPassword1">Password</label>
				  <div class="controls">
					<input type="password" id="inputPassword1" placeholder="Password">
				  </div>
				</div>
				<div class="control-group">
				  <div class="controls">
					<button type="submit" class="btn">Sign in</button> OR <a href="register.html" class="btn">Register Now!</a>
				  </div>
				</div>
				<div class="control-group">
					<div class="controls">
					  <a href="forgetpass.html" style="text-decoration:underline">Forgot password ?</a>
					</div>
				</div>
			</form>
		  </td>
		  </tr>
	</table>

	<table class="table table-bordered">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Description</th>
                  <th>Quantity/Update</th>
				  <th>Price <br>Per Unit</th>
                  <th>Discount <br> Per Unit</th>
                  <th>Total</th>
				</tr>
              </thead>
              <tbody>
                @php
                   $totalAmount = 0;
                   $productDiscount = 0;
                   $couponDiscount = 0;
                   $grandTotal = 0;
                @endphp
                @foreach ($cartitems as $cartitem)
                @php
                // product attribute discount
                    $CartProduct = Cart::getCartProducts($cartitem->products_id, $cartitem->attributes_id);
                @endphp
                <tr>
                  <td> <img width="60" src="{{ url('images/product_image/small/'.$CartProduct['product']->image) }}" alt=""/></td>
                  <td>{{ $CartProduct['product']->title }}({{ $CartProduct['attribute']->sku }})<br/>Color : {{ $CartProduct['product']->color }}
                  <br>Size : {{ $CartProduct['attribute']->size }}
                </td>
				  <td>
					<div class="input-append">
                        <input title="Minimum Value is 1 !" id="quantityInput" onblur="quantitycanger(this)" class="span1" style="max-width:34px" placeholder="1" value="{{ $cartitem->quantity }}" id="appendedInputButtons" name="quantity" size="16" type="text">

                        <button onclick="minus(this)" id="minus" class="btn" type="button"><i class="icon-minus"></i></button>

                        <button onclick="plus(this)" id="plus" class="btn" type="button"><i class="icon-plus"></i></button>

                        <button onclick="close(this)" id="close" class="btn btn-danger" type="button"><i class="icon-remove icon-white"></i></button>
                    </div>
				  </td>
                  @php
                  $totalAmount += $cartitem->quantity * ($cartitem->price - ($cartitem->price * ($CartProduct['discount']/100)));
                  $productDiscount = ($cartitem->price * ($CartProduct['discount']/100));
                  $couponDiscount = 0;
                  $grandTotal = ($totalAmount-$productDiscount)-$couponDiscount;
                  @endphp

                  <td>Rs.{{ number_format($cartitem->price,2) }}</td>
                  <td>Rs.{{ number_format($cartitem->price * ($CartProduct['discount']/100),2) }}</td>
                  <td>Rs.{{ number_format($cartitem->quantity * ($cartitem->price - ($cartitem->price * ($CartProduct['discount']/100))),2) }}</td>
                </tr>
                @endforeach

                <tr>
                  <td colspan="5" style="text-align:right">Total Price:	</td>
                  <td> Rs. {{ number_format($totalAmount,2) }}</td>
                </tr>
				 <tr>
                  <td colspan="5" style="text-align:right">Total Discount:	</td>
                  <td> Rs. {{ number_format($couponDiscount,2) }}</td>
                </tr>
				 <tr>
                  <td colspan="5" style="text-align:right"><strong>GRAND TOTAL (Total Price  - Coupon Discount) =</strong></td>
                  <td class="label label-important" style="display:block"> <strong> Rs. {{ number_format($grandTotal,2) }} </strong></td>
                </tr>
				</tbody>
            </table>


            <table class="table table-bordered">
			<tbody>
				 <tr>
                  <td>
				<form class="form-horizontal">
				<div class="control-group">
				<label class="control-label"><strong> VOUCHERS CODE: </strong> </label>
				<div class="controls">
				<input type="text" class="input-medium" placeholder="CODE">
				<button type="submit" class="btn"> ADD </button>
				</div>
				</div>
				</form>
				</td>
                </tr>

			</tbody>
			</table>

			<!-- <table class="table table-bordered">
			 <tr><th>ESTIMATE YOUR SHIPPING </th></tr>
			 <tr>
			 <td>
				<form class="form-horizontal">
				  <div class="control-group">
					<label class="control-label" for="inputCountry">Country </label>
					<div class="controls">
					  <input type="text" id="inputCountry" placeholder="Country">
					</div>
				  </div>
				  <div class="control-group">
					<label class="control-label" for="inputPost">Post Code/ Zipcode </label>
					<div class="controls">
					  <input type="text" id="inputPost" placeholder="Postcode">
					</div>
				  </div>
				  <div class="control-group">
					<div class="controls">
					  <button type="submit" class="btn">ESTIMATE </button>
					</div>
				  </div>
				</form>
			  </td>
			  </tr>
            </table> -->
	<a href="products.html" class="btn btn-large"><i class="icon-arrow-left"></i> Continue Shopping </a>
	<a href="login.html" class="btn btn-large pull-right">Next <i class="icon-arrow-right"></i></a>

</div>
<script>
    let myinput = document.getElementById("quantityInput");
    let minimum = 1;

function quantitycanger(input){
    if(input.value > minimum){
        return true;
    }
    else{
        input.value = minimum;
    }
}

function minus(minus){
    let textInput = minus.parentElement.children[0];
    if(eval(textInput.value) > minimum){
        textInput.value = eval(textInput.value) - 1;
    }
}

function plus(plus){
    let textInput = plus.parentElement.children[0];
    textInput.value = eval(textInput.value) + 1;
}

function close(close){
    console.log(close);
}

</script>
@endsection
