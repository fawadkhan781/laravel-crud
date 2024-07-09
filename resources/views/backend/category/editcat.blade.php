@php
    use Illuminate\Support\Str;
@endphp
@extends('backend.layout.layout')
@section('title')
    Edit Category
@endsection
@section('content')
    <form enctype="multipart/form-data" action="{{ route('categories.update', $category->id) }}" method="POST"
        enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="card-body">
            <div class="mb-3">
                <label for="name" class=" form-label h5">Name</label>
                <input value=" {{ old('name', $category->name) }}" type="text"
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
                <input value=" {{ old('slug', $category->slug) }}" type="text"
                    class=" @error('slug') is-invalid @enderror form-control-lg form-control" id="slug" name="slug"
                    placeholder="slug">
                @error('slug')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="name" class="form-label h5">Status</label>
                <select name="status" id="status" class="form-control">
                    <option {{ $category->status == 1 ? 'selected' : '' }} value="1">Active</option>
                    <option {{ $category->status == 0 ? 'selected' : '' }} value="0">Inactive</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="showHome" class="form-label h5">Show on home page</label>
                <select name="showHome" id="showHome" class="form-control">
                    <option {{ Str::lower($category->showHome) == 'yes' ? 'selected' : '' }} value="Yes">Yes</option>
                    <option {{ $category->showHome == 'no' ? 'selected' : '' }} value="No">No</option>
                </select>
            </div>

            <div class="mb-3 row">
                <div class="col-md-8">
                    <label for="name" class="form-label h5">Image</label>
                    <input type="file" class=" @error('image') is-invalid @enderror form-control-lg form-control"
                        id="image" name="image">
                </div>
                <div class="col-md-4">
                    @if (!empty($category->image))
                        <img width="100px" src="{{ asset('uploads/category/' . $category->image) }}" alt="">
                    @else
                        <img width="100px" src="{{ asset('uploads/category/default.png') }}" alt="">
                    @endif
                    @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="text-center d-grid"><button type="submit" class="btn btn-lg btn-primary">update</button></div>
        </div>
    </form>
@endsection
