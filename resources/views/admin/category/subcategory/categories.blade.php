<option value="">Select Category</option>
@foreach ($categories as $category)
    <option value="{{ Crypt::encryptString($category->id) }}">{{ $category->title }}</option>
@endforeach
