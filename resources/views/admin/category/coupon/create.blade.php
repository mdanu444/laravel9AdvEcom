@extends('templates.admin.master')


@section('main_content')
<style>
    .form-group{
        padding-top: 10px;
    }
</style>
    <div class="card col-md-6">
        <div class="card-header bg-primary">Add New coupons</div>
        <div class="card-body">
            <form action="{{ route('admin.coupons.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <h3 class="h4">Coupon Option</h3>
                    <label for="automatic"> Automatic&nbsp;
                        <input checked onclick="optionchanger('automatic')" type="radio" value="automatic" name="option"
                            id="automatic" class="option">
                    </label>&nbsp;&nbsp;
                    <label for="manual"> Manual&nbsp;
                        <input onclick="optionchanger('manual')" type="radio" value="manual" name="option" id="manual"
                            class="option">
                    </label>
                    <br>
                    <hr style="border-color: lightgray">
                </div>
                <div class="form-group code" style="display: none;">
                    <h3 class="h4">Coupon Code</h3>
                    <input class="form-control w-100" type="text" value="" name="code" id="code"
                        placeholder="Coupon Code">
                    <br>
                    <hr style="border-color: lightgray">
                </div>
                <div class="form-group">
                    <h3 class="h4">Coupon Type</h3>
                    <label for="multiple"> Multiple Times&nbsp;
                        <input checked type="radio" value="multiple" name="coupon_type" id="multiple" class="coupon_type">
                    </label>&nbsp;&nbsp;
                    <label for="single"> Single Time&nbsp;
                        <input type="radio" value="single" name="coupon_type" id="single" class="coupon_type">
                    </label>
                    <br>
                    <hr style="border-color: lightgray">
                </div>
                <div class="form-group">
                    <h3 class="h4" for="selectionloader">Select Category</h3>
                    <select multiple class=" col-md-11  selecttion form-control js-example-basic-single"
                        name="categories[]">
                        @foreach ($sections as $section)
                            <option disabled style="font-weight: bold !important"> &nbsp; &nbsp;{{ $section->title }}
                            </option>
                            @foreach ($section->product_categories as $category)
                                <option value="{{ 'c-' . $category->id }}"> &nbsp; &nbsp; &#8594; {{ $category->title }}
                                </option>
                                @foreach ($category->product_sub_categories as $sub)
                                    <option value="{{ 's-' . $sub->id }}"> &nbsp; &nbsp; &#8594; &#8594; {{ $sub->title }}
                                    </option>
                                @endforeach
                            @endforeach
                        @endforeach
                    </select>
                    @error('product_categories_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <br>
                    <hr style="border-color: lightgray">
                </div>
                <div class="form-group">
                    <h3 class="h4" for="selectionloader">Select User</h3>
                    <select multiple class=" col-md-11  selecttion form-control js-example-basic-single"
                        name="users[]">
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"> &nbsp; &nbsp;&nbsp;{{ $user->email }}</option>
                        @endforeach
                    </select>
                    @error('product_categories_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <br>
                    <hr style="border-color: lightgray">
                </div>
                <div class="form-group">
                    <h3 class="h4">Coupon Amount Type</h3>
                    <label for="persantage"> Persantage&nbsp;
                        <input checked type="radio" value="persantage" name="amount_type"
                            id="persantage" class="amount_type">
                    </label>&nbsp;&nbsp;
                    <label for="fixed"> Fixed Amount in BDT &nbsp;
                        <input type="radio" value="fixed" name="amount_type" id="fixed"
                            class="amount_type">
                    </label>
                    <br>
                    <hr style="border-color: lightgray">
                </div>
                <div class="form-group">
                    <h3 class="h4">Coupon Amount [% or BDT]</h3>
                    <input name="amount" type="number" placeholder="Coupon Amount" class="form-control">
                    <br>
                    <hr style="border-color: lightgray">
                </div>




                <div class="form-group">
                    <label>Date:</label>
                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate"
                            name="expiry_date" />
                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
                <input type="submit" value="Add" class="btn btn-block btn-primary">
            </form>
        </div>
    </div>
    <script>
        function optionchanger(option) {
            let code = document.querySelector('.code');
            if (option == "automatic") {
                code.style.display = 'none';
            } else {
                code.style.display = 'block';
            }
        }
        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'L'
        });
    </script>
@endsection
