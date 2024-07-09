@extends('backend.layout.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Category</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('categories.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data" id="categoryForm">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input value=" {{ old('name') }}" type="text" name="name" id="name"
                                        class="form-control" placeholder="Name">

                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input value=" {{ old('slug') }}" type="text" name="slug" id="slug"
                                        class="form-control" placeholder="Slug" readonly>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="">Show on home page</label>
                                    <select name="showHome" id="showHome" class="form-control">
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>


                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="pb-5 pt-3">
                        <button href="{{ route('categories.index') }}" type="submit" name="submit"
                            class="btn btn-primary">Create</button>
                    </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
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

        // Listen for form submission
        document.getElementById('name').addEventListener('input', function(event) {
            // Get the value of the name field
            var name = this.value;
            // Generate the slug
            var slug = slugify(name);
            // Append the slug to the form data
            document.getElementById('slug').value = slug;


        });

        // Listen for form submission
        document.getElementById('categoryForm').addEventListener('submit', function(event) {
            // Get the value of the name field
            var name = document.getElementById('categoryForm').value;
            // Generate the slug
            var slug = slugify(slugify(name));
            // Append the slug to the form data
            document.getElementById('slug').value = slug;

        })
    </script>
@endsection
