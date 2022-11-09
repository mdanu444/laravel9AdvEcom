@extends('templates.admin.master')


@section('main_content')
<div class="card col-md-6">
    <div class="card-header bg-primary">Product Section</div>
    <div class="card-body">
        <form action="{{ route('admin.productsubcategory.update', $item->id) }}" method="POST">
            @csrf
            @method('put')
            <div class="form-group">
                <label for="title">Title</label>
                <input value="{{ $item->title }}" class="form-control" type="text" name="title" id="title">
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="section">Section</label>
                <select  class="form-control js-example-basic-single" name="product_sections_id" id="section">
                    <option value="">Select Section</option>
                    @foreach ($sections as $section)
                        <option @if ($section->id == $item->product_sections->id)
                            selected
                        @endif value="{{ $section->id }}">{{ $section->title }}</option>
                    @endforeach
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
    // In your Javascript (external .js resource or <script> tag)

</script>
@endsection

