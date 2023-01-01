
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
<div id="cartLoadable">
    @include('frontend.cart_ajax');
</div>


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

    let id = input.getAttribute('data');
    updateCart(id, input.value)

}

function minus(minus){
    let textInput = minus.parentElement.children[0];
    if(eval(textInput.value) > minimum){
        textInput.value = eval(textInput.value) - 1;
        let id = textInput.getAttribute('data');
        updateCart(id, textInput.value)
    }
}

function plus(plus){
    let textInput = plus.parentElement.children[0];
    textInput.value = eval(textInput.value) + 1;
    let id = textInput.getAttribute('data');
    updateCart(id, textInput.value)
}

function closer(closer){
    let textInput = closer.parentElement.children[0];
    let id = textInput.getAttribute('data');
    deleteCart(id);
}

function updateCart(id, quantity){
    let url = "{{ route('frontend.cart.update') }}";
    let formData = new FormData();
    formData.append('id', id);
    formData.append('quantity', quantity);
    fetch(url, {
        method: "post",
        body: formData,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}",
        }
    })
    .then(res => res.json())
    .then((data) => {
    loadCart(data)
    })
}

function deleteCart(id){
    let url = "{{ route('frontend.cart.delete') }}";
    let formData = new FormData();
    formData.append('id', id);
    fetch(url, {
        method: "post",
        body: formData,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}",
        }
    })
    .then(res => res.json())
    .then((data) => {
    loadCart(data)
    })
}
function loadCart(data){
   // console.log(data);
    // return 0;
    loading();
    let cartLoadable = document.getElementById('cartLoadable');
    if(data.status == true){
        cartLoadable.innerHTML= data.html;
    }
    if(data.status == false){
        cartLoadable.innerHTML= data.html;
        alert(data.message);
    }
    loading();
}
</script>
@endsection
