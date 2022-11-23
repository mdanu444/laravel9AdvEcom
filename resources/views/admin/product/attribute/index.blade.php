@extends('templates.admin.master')

@section('main_content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<div class="card">
    <div class="card-header bg-primary">
      <h3 class="card-title">Title: {{ $product->title }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body" style="display: grid; grid-template-columns: auto auto;  grid-gap: 0px 10px">
        <div>
            <table style="width: 100%">
                <tr><td>Color</td><td>:</td><td>{{ $product->color }}</td></tr>
                <tr><td>Price</td><td>:</td><td>{{ $product->price }}</td></tr>
                <tr><td>Code</td><td>:</td><td>{{ $product->code }}</td></tr>
                <tr><td>weight</td><td>:</td><td>{{ $product->weight }}</td></tr>
                <tr><td>Category</td><td>:</td><td>{{ $product->product_categories->title }}</td></tr>
                <tr><td>Sub Category</td><td>:</td><td>{{ !empty($product->product_sub_categories->title)?$product->product_sub_categories->title:'None' }}</td></tr>
                <tr><td>Discount</td><td>:</td><td>{{ $product->discount }}</td></tr>
                <tr><td>Featured</td><td>:</td><td>{{ $product->featured ==0?'No':'Yes' }}</td></tr>
                <tr><td>Occassion</td><td>:</td><td>{{ $product->occassion }}</td></tr>
            </table>
        </div>
        <div class="p-3 text-gray img-fluid shadow">
            <img class="" style=""  src="{{ url('images/product_image/small/'.$product->image) }}" alt="">
        </div>
    </div>
    <!-- /.card-body -->
</div>
<div class="card">
    <div class="card-header bg-primary">
        <h4>Add Attribute</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.p_attribute.store', Crypt::encryptString($product->id)) }}" method="post">
            @csrf
            <div class="field_wrapper">
    <div style="display: grid; grid-template-columns: auto auto auto auto auto; grid-gap: 10px 10px; margin-bottom: 10px;">
        <input class="form-control" type="text" name="size[]" placeholder="Size" />
        <input class="form-control" type="text" name="sku[]" placeholder="SKU" />
        <input class="form-control" type="text" name="price[]" placeholder="Price" />
        <input class="form-control" type="text" name="stock[]" placeholder="Stock" />
        <a href="javascript:void(0);" class="add_button btn btn-primary" title="Add field">
         <i class="fa fa-plus"></i>
        </a>
    </div>
            </div>
            <input class="btn btn-primary btn-blcok mt-3 px-5 float-right" type="submit" value="Add">
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header bg-primary">
      <h3 class="card-title">Product Section List</h3>
      <a href="{{ route('admin.productsections.create') }}" class="btn btn-light float-right" style="color: black !important;">+ Add New</a>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>Id</th>
          <th>Size</th>
          <th>SKU</th>
          <th>Price</th>
          <th>Stock</th>
          <th>Action</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->size }}</td>
                <td>{{ $item->sku }}</td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->stock }}</td>
                <td class="d-flex">
                    <form method="post" action="{{ route('admin.p_attribute.destroy', [Crypt::encryptString($product->id), Crypt::encryptString($item->id)]) }}">
                        @csrf
                        @method('delete')
                        <button class="delete border-0 bg-primary p-3" type="submit"><i class="fa fa-trash "></i></button>
                    </form>
                </td>
              </tr>
            @endforeach

        </tbody>
        <tfoot>
        <tr>
            <th>Id</th>
            <th>Size</th>
            <th>SKU</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Action</th>
        </tr>
        </tfoot>
      </table>
    </div>
    <!-- /.card-body -->
  </div>



<style>
  #example1_filter, #example1_paginate{
    float: right;
  }
</style>
<script type="text/javascript">
    $(document).ready(function(){
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        


        var fieldHTML = `

        <div style="display: grid; grid-template-columns: auto auto auto auto auto; grid-gap: 10px 10px; margin-bottom: 10px;">
            <input class="form-control" type="text" name="size[]" placeholder="Size" />
            <input class="form-control" type="text" name="sku[]" placeholder="SKU" />
            <input class="form-control" type="text" name="price[]" placeholder="Price" />
            <input class="form-control" type="text" name="stock[]" placeholder="Stock" />
            <a href="javascript:void(0);" class="remove_button btn btn-danger" title="Remove field">
             <i class="fa fa-minus" ></i>
            </a>
        </div>

        `; //New input field html





        var x = 1; //Initial field counter is 1

        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });
    </script>
@endsection
