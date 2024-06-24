@extends('templates.admin.master')

@section('main_content')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


    {{--  Product Data  --}}

    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="card-title">Title: {{ $product->title }}</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body" style="display: grid; grid-template-columns: auto auto;  grid-gap: 0px 10px">
            <div>
                <table style="width: 100%">
                    <tr>
                        <td>Color</td>
                        <td>:</td>
                        <td>{{ $product->color }}</td>
                    </tr>
                    <tr>
                        <td>Price</td>
                        <td>:</td>
                        <td>{{ $product->price }}</td>
                    </tr>
                    <tr>
                        <td>Code</td>
                        <td>:</td>
                        <td>{{ $product->code }}</td>
                    </tr>
                    <tr>
                        <td>weight</td>
                        <td>:</td>
                        <td>{{ $product->weight }}</td>
                    </tr>
                    <tr>
                        <td>Category</td>
                        <td>:</td>
                        <td>{{ $product->product_categories->title }}</td>
                    </tr>
                    <tr>
                        <td>Sub Category</td>
                        <td>:</td>
                        <td>{{ !empty($product->product_sub_categories->title) ? $product->product_sub_categories->title : 'None' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Discount</td>
                        <td>:</td>
                        <td>{{ $product->discount }}</td>
                    </tr>
                    <tr>
                        <td>Featured</td>
                        <td>:</td>
                        <td>{{ $product->featured == 0 ? 'No' : 'Yes' }}</td>
                    </tr>
                    <tr>
                        <td>Occassion</td>
                        <td>:</td>
                        <td>{{ $product->occassion }}</td>
                    </tr>
                </table>
            </div>
            <div class="p-3 text-gray img-fluid shadow">
                <img class="" style="" src="{{ url('images/product_image/small/' . $product->image) }}"
                    alt="">
            </div>
        </div>
        <!-- /.card-body -->
    </div>





    {{--  Add Image  --}}
    <div class="card">
        <div class="card-header bg-primary">
            <h4>Upload New Image</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.p_image.store', Crypt::encryptString($product->id)) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                @method('post')
                <input type="file" name="images[]" multiple accept="image/*">
                <input type="submit" value="Upload" class="btn btn-primary">
            </form>
        </div>
    </div>


    <div class="card">
        <div class="card-header bg-primary">
            <h3>Product Images</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover table-striped" style="width: 100%">
                <tr>
                    <th>Serial</th>
                    <th style="width: 80%">Image</th>
                    <th>Action</th>
                </tr>
                @php
                    $i = 1;
                @endphp
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $i }}</td>
                        <td class="p-3 text-center">
                            <img width="100" height="100"
                                src="{{ url('images/product_image/alternative/' . $item->title) }}" alt="Product Image">
                        </td>
                        <td>
                            <form
                                action="{{ route('admin.p_image.destroy', [Crypt::encryptString($product->id), Crypt::encryptString($item->id)]) }}"
                                method="post">
                                @csrf
                                @method('delete')
                                <button title="Delete Image" type="submit" class="delete btn btn-primary">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </table>
        </div>
    </div>




    <style>
        #example1_filter,
        #example1_paginate {
            float: right;
        }
    </style>
@endsection
