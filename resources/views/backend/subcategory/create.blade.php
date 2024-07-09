@extends('backend.layout.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Sub Category</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('subcategories.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form enctype="multipart/form-data" action="{{ route('subcategories.store') }}" method="POST"
                enctype="multipart/form-data" id="subcategoryForm">
                @csrf
                <div class="card-body">
                    <div class="mb-3">
                        <label for="name" class=" form-label h5">Name</label>
                        <input value=" {{ old('name') }}" type="text"
                            class=" @error('name') is-invalid @enderror form-control-lg form-control" id="name_subcat"
                            name="name" placeholder="name">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label h5">Slug</label>
                        <input value=" {{ old('slug') }}" type="text" class=" form-control-lg form-control"
                            id="slug_subcat" name="slug" placeholder="slug" readonly>

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
                        <label for="name" class="form-label h5">Description</label>
                        <textarea value=" {{ old('description') }}" class="form-control-lg form-control" name="description" cols="30"
                            rows="10" placeholder="description"></textarea>

                    </div>

                    <div>
                        <label for="name" class="form-label h5"></label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option>----Select category ----</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label h5">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="showHome" class="form-label h5">Show on home page</label>
                        <select name="showHome" id="showHome" class="form-control">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>

                    <div class="text-center d-grid"><button type="submit" class="btn btn-lg btn-primary">create</button>
                    </div>
                </div>
            </form>
        @endsection

        @section('custom-js')
            <script>
                // Function to create a slug
                function slugify(text) {
                    return text.toString().toLowerCase()
                        .replace(/\s+/g, '-') // Replace spaces with -
                        .replace(/[^\w\-]+/g, '') // Remove all non-word chars
                        .replace(/\-\-+/g, '-') // Replace multiple - with single -
                        .replace(/^-+/, '') // Trim - from start of text
                        .replace(/-+$/, ''); // Trim - from end of text
                }

                document.getElementById('name_subcat').addEventListener('input', function(event) {
                    var name = this.value;
                    var slug = slugify(name);
                    document.getElementById('slug_subcat').value = slug;


                });
            </script>
        @endsection
