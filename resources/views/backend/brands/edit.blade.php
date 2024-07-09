@extends('backend.layout.layout')
@section('title')
    Edit Brand
@endsection

@section('content')
    <form action="{{ route('brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="card-body">

            <div class="mb-3">
                <label for="name" class="form-label h5">Name</label>
                <input value=" {{ old('name', $brand->name) }}" type="text"
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
                <input value=" {{ old('slug', $brand->slug) }}" type="text"
                    class=" @error('slug') is-invalid @enderror form-control-lg form-control" id="slug" name="slug"
                    placeholder="slug" readonly>
                @error('slug')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="name" class="form-label h5">Status</label>
                <select class=" @error('status') is-invalid @enderror form-control-lg form-control" name="status"
                    id="status">
                    <option value="1" {{ $brand->status == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $brand->status == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class=" text-center "> <button type="submit" class="btn btn-lg btn-primary">Update</button></div>
        </div>
    </form>
@endSection
