@extends('backend.layout.layout')
@section('title')
    Edit Sub Category
@endsection
@section('content')
    <form enctype="multipart/form-data" action="{{ route('subcategories.update', $subcategory->id) }}" method="POST"
        enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="card-body">
            <div class="mb-3">
                <label for="name" class=" form-label h5">Name</label>
                <input value=" {{ old('name', $subcategory->name) }}" type="text"
                    class=" @error('name') is-invalid @enderror form-control-lg form-control" id="name" name="name"
                    placeholder="name">

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

            </div>

            <div class="mb-3">
                <label for="name" class="form-label h5">Slug</label>
                <input value="{{ $subcategory->slug }}" type="text"
                    class=" @error('slug') is-invalid @enderror form-control-lg form-control" id="slug" name="slug"
                    placeholder="slug">
                @error('slug')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="name" class="form-label h5">Image</label>
                <input type="file" class=" @error('image') is-invalid @enderror form-control-lg form-control"
                    id="image" name="image">
                @error('image')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="name" class="form-label h5">Category</label>
                <select name="category_id" id="category_id" class="form-control">
                    <option>----Select category ----</option>
                    @foreach ($category as $cat)
                        <option {{ $subcategory->category_id == $cat->id ? 'selected' : '' }} value="{{ $cat->id }}">
                            {{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label h5">Status</label>
                <select name="status" id="status" class="form-control">
                    <option {{ $subcategory->status == 1 ? 'selected' : '' }} value="1">Active</option>
                    <option {{ $subcategory->status == 0 ? 'selected' : '' }} value="0">Inactive</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="showHome" class="form-label h5">Show on home page</label>
                <select name="showHome" id="showHome" class="form-control">
                    <option {{ Str::lower($subcategory->showHome) == 'Yes' ? 'selected' : '' }} value="Yes">Yes</option>
                    <option {{ $subcategory->showHome == 'No' ? 'selected' : '' }} value="No">No</option>
                </select>
            </div>

            <div class="text-center d-grid"><button type="submit" class="btn btn-lg btn-primary">update</button></div>
        </div>
    </form>
@endsection
