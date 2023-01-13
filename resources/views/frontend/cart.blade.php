@extends('frontend.master')
@section('mainbody')
    <style>
        th,
        td {
            vertical-align: center !important;
            line-height: 1;
        }
    </style>
    <div class="span9">
        @if (Session::has('error_msg'))
            <div class="alert alert-danger">{{ Session::get('error_msg') }}</div>
        @endif
        @if (Session::has('success_msg'))
            <div class="alert alert-success">{{ Session::get('success_msg') }}</div>
        @endif
        <ul class="breadcrumb">
            <li><a href="index.html">Home</a> <span class="divider">/</span></li>
            <li class="active"> SHOPPING CART</li>
        </ul>
        <h3> SHOPPING CART [ <small>
                <span class="cartitem">
                    @if (Session::has('numberOfCartItem'))
                        {{ Session::get('numberOfCartItem') }}
                    @else
                        0
                    @endif
                </span>
                Item(s) </small>]<a href="{{ route('frontend.index') }}" class="btn btn-large pull-right"><i
                    class="icon-arrow-left"></i> Continue Shopping </a></h3>
        <hr class="soft" />
        @guest


            <table class="table table-bordered">
                <tr>
                    <th> I AM ALREADY REGISTERED </th>
                </tr>
                <tr>
                    <td>
                        <form class="form-horizontal" action="{{ route('frontend.user.login') }}" method="post">@csrf
                            <div class="control-group">
                                <label class="control-label" for="email">Email Address</label>
                                <div class="controls">
                                    <input type="text" name="email" id="email" placeholder="Email">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="password">Password</label>
                                <div class="controls">
                                    <input type="password" name="password" id="password" placeholder="Password">
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls">
                                    <button type="submit" class="btn">Sign in</button> OR <a
                                        href="{{ route('frontend.logreg.index') }}" class="btn">Register Now!</a>
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls">
                                    <a href="{{ route('frontend.user.forgotpassview') }}"
                                        style="text-decoration:underline">Forgot password ?</a>
                                </div>
                            </div>
                        </form>
                    </td>
                </tr>
            </table>
        @endguest
        <div id="cartLoadable">
            @include('frontend.cart_ajax');
        </div>


        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td>
                        <form class="form-horizontal" action="/getcoupon">
                            @csrf
                            <div class="control-group">
                                <label class="control-label"><strong> COUPON CODE: </strong> </label>
                                <div class="controls">
                                    <input required id="coupone_code" type="text" class="input-medium" placeholder="CODE">
                                    <button onclick="getcoupon(event)" type="submit" class="btn"> ADD </button>
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
        <a href="{{ route('frontend.index') }}" class="btn btn-large"><i class="icon-arrow-left"></i> Continue Shopping </a>
        <a href="{{ route('frontend.logreg.index') }}" class="btn btn-large pull-right">Next <i
                class="icon-arrow-right"></i></a>

    </div>
    <script>

        let myinput = document.getElementById("quantityInput");

        let minimum = 1;

        function getcoupon(e) {
            e.preventDefault();
            let coupone_code_input = document.getElementById('coupone_code');
            @auth
             let user = 1;
            @endauth
            @guest
                let user = 0;
            @endguest
            if(user == 1){
                let code = coupone_code_input.value;
                if(code.length < 1){
                    alert('Please enter coupon code !');
                }
                if(code.length > 0){
                    updateCart(0, 0, code)
                    // coupone_code_input.disabled = true;
                    // e.target.disabled = true;
                }
            }else{
                alert("Please login to apply coupon !");
            }

        }

        function quantitycanger(input) {
            if (input.value < minimum) {
                input.value = minimum;
            }
            let id = input.getAttribute('data');
            updateCart(id, input.value)
        }

        function minus(minus) {
            let textInput = minus.parentElement.children[0];
            if (eval(textInput.value) > minimum) {
                textInput.value = eval(textInput.value) - 1;
                let id = textInput.getAttribute('data');
                updateCart(id, textInput.value)
            }
        }

        function plus(plus) {
            let textInput = plus.parentElement.children[0];
            textInput.value = eval(textInput.value) + 1;
            let id = textInput.getAttribute('data');
            updateCart(id, textInput.value)
        }

        function closer(closer) {
            let textInput = closer.parentElement.children[0];
            let id = textInput.getAttribute('data');
            deleteCart(id);
        }

        function updateCart(id, quantity, code="") {
            let url = "{{ route('frontend.cart.update') }}";
            let formData = new FormData();
            formData.append('id', id);
            formData.append('quantity', quantity);
            if(code != ""){
                formData.append('code', code);
            }
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

        function deleteCart(id) {
            let cartitems = document.querySelectorAll('.cartitem');
            for (let cartitem of cartitems) {
                let itemvalue = eval(eval(cartitem.textContent) - 1);
                cartitem.textContent = itemvalue;
            }

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
                    loadCart(data);
                })
        }

        function loadCart(data) {
            // console.log(data);
            // return 0;
            loading();
            let cartLoadable = document.getElementById('cartLoadable');
            if (data.status == true) {
                cartLoadable.innerHTML = data.html;
            }
            if (data.status == false) {
                alert(data.message);
                if(data.html){
                    cartLoadable.innerHTML = data.html;
                }
            }
            loading();
        }
    </script>
@endsection
