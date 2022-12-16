@extends('templates.admin.master')


@section('main_content')
<div class="card col-md-12">
    <div class="card-header bg-primary">Add Product Sub Category </div>
    <div class="card-body">
        <form action="{{ route('admin.productsubcategory.update', Crypt::encryptString($item->id)) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div style="display: grid; grid-template-columns: 50% 50%; width: 100%;  grid-gap: 30px 10px; box-sizing: border-box;">


            <div class="form-group">
                <label for="selectionloader">Section</label>
                <select location="admin/getcategorybysection" loadableClass="categoryoptionviewer"  class="col-md-11 form-control js-example-basic-single selecttion" name="product_sections_id"  id="selectionloader">
                    <option selected value="">Select Section</option>
                    @foreach ($sections as $section)
                        <option
                        {{ $section->id == $item->product_sections_id?"selected": "" }}
                        value="{{ Crypt::encryptString( $section->id) }}">{{ $section->title }}</option>
                    @endforeach
                </select>
                @error('section')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="section">Category</label>
                <select  class="col-md-11 categoryoptionviewer selecttion form-control js-example-basic-single" name="product_categories_id" id="section">
                    <option selected value="">Select Category</option>
                    @foreach ($category as $cat)
                        <option
                        {{ $cat->id == $item->	product_categories_id?"selected": "" }}
                        value="{{ Crypt::encryptString($cat->id) }}">{{ $cat->title }}</option>
                    @endforeach
                </select>
                @error('section')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="form-group">
                <label for="title">Title</label>
                <input value="{{ $item->title }}" class="form-control col-md-11" type="text" name="title" id="title">
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <div class="">
                <label for="url">URL</label>
                <input value="{{ $item->url }}" class="form-control col-md-11" type="text" name="url" id="url">
                @error('url')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="col-md-11 ">
                <img style="float:right; border: 1px solid black;" height="100" width="100" src="{{ asset($item->image) }}" alt="">
                <p class="float-right d-inline mx-2" style="line-hight: 1.5"><strong>Category Image</strong> <br> If you want to delete this, you have to update the image. <br> A Category image is required.</p>
            </div>
            <div class="">
                <label for="image">Image</label>
                <input  class="form-control col-md-11" type="file" name="image" id="image">
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="">
                <label for="discount">Discount</label>
                <input value="{{ $item->discount }}" class="form-control col-md-11" type="number" name="discount" id="discount">
                @error('discount')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="">
                <label for="meta-title">Meta Title</label>
                <input value="{{ $item->meta_title }}" class="form-control col-md-11" type="text" name="meta_title" id="meta-title">
                @error('meta-title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>






            <div class="">
                <label for="meta_description">Meta Description</label>
                <textarea  class="form-control col-md-11" type="textarea" name="meta_description" id="meta_description">{{$item->meta_description }}</textarea>
                @error('meta_description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>



            <div class="">
                <label for="description">Description</label>
                <textarea class="form-control col-md-11" type="textarea" name="description" id="description">{{ $item->description }}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="">
                <label for="meta_keywords">Meta Key Words</label>
                <input value="{{ $item->meta_keywords }}" class="form-control col-md-11" type="text" name="meta_keywords" id="meta_keywords">
                @error('meta_keywords')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>


            <input style="grid-" type="submit" value="Update" class="btn btn-primary  col-md-11">
        </div>
        </form>
    </div>
</div>

@endsection
