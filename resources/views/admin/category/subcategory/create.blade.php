@extends('templates.admin.master')


@section('main_content')
<div class="card col-md-6">
    <div class="card-header bg-primary">Product Sub Category</div>
    <div class="card-body">
        <form action="{{ route('admin.productsubcategory.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input class="form-control" type="text" name="title" id="title">
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="selectionloader">Section</label>
                <select loadableClass="categoryoptionviewer" action="{{ route('admin.getcategorybysection') }}"  class="form-control js-example-basic-single" name="product_sections_id"  id="selectionloader">
                    <option selected value="">Select Section</option>
                    @foreach ($sections as $section)
                        <option value="{{ $section->id }}">{{ $section->title }}</option>
                    @endforeach
                </select>
                @error('section')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="section">Category</label>
                <select  class="form-control js-example-basic-single categoryoptionviewer" name="product_categories_id" id="section">
                    <option selected value="">Select Category</option>
                    <option value="h">h</option>
                </select>
                @error('section')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <input type="submit" value="Add" class="btn btn-primary">
        </form>
    </div>
</div>
<script>

</script>
@endsection

