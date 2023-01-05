<option value="">Select Category</option>
<option value="{{ Crypt::encryptString(0) }}">None</option>
@foreach ($categories as $category)
    <option value="{{ Crypt::encryptString($category->id) }}">{{ $category->title }}</option>
@endforeach
