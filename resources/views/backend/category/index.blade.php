@extends('backend.layout.layout')
@section('mystyle')
@endsection
@section('title')
    <span class="mx-3">
        Categorys</span> <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#category_create"
        class="btn btn-primary btn-sm ms-3"><i class="fas fa-plus"></i></a>
    {{-- search form --}}


@endSection


@section('content')
    <div class="container ">
        <div class="row justify-content-end w-25">
            <form action="{{ route('categories.index') }}" method="get" class="d-flex justify-content-end mb-3 mt-3 ">
                @csrf
                <div>
                    <a href="{{ route('categories.index') }}" class="btn btn-primary btn-sm me-2 mt-1"><i
                            class="fa fa-refresh fa-spin" style="font-size:24px"></i></a>
                </div>
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search"
                    value="{{ request()->search }}">
                <button class="btn btn-outline-success" type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>


    @if (session()->has('success'))
        <div id="success-alert" class="alert alert-success alert-dismissible fade show d-flex align-items-center p-4 mb-4"
            role="alert" style="background-color: #d4edda; border-color: #c3e6cb;">
            <i class="fa fa-check-circle me-3 fa-2x" style="color: #28a745;"></i> <!-- Font Awesome Icon -->
            <div class="flex-grow-1">
                <h4 class="alert-heading">Success!</h4>
                <p>{{ session()->get('success') }}</p>
            </div>
            <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session()->has('error'))
        <div id="error-alert" class="alert alert-danger alert-dismissible fade show d-flex align-items-center p-4 mb-4"
            role="alert" style="background-color: #f8d7da; border-color: #f5c6cb;">
            <i class="fa fa-exclamation-circle me-3 fa-2x" style="color: #dc3545;"></i> <!-- Font Awesome Icon -->
            <div class="flex-grow-1">
                <h4 class="alert-heading">Error!</h4>
                <p>{{ session()->get('error') }}</p>
            </div>
            <button type="button" class="btn-close ms-2" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <table class="table">
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Slug</th>
            <th>Status</th>
            <th>Created_at</th>
            <th>Action</th>
        </tr>
        @php
            $counter = $categories->firstItem();
        @endphp
        @if ($categories->isNotEmpty())
            @foreach ($categories as $category)
                <tr>
                    <td> {{ $counter++ }}</td>
                    <td>
                        @if ($category->image != '')
                            <img width="50" src="{{ asset('uploads/category/' . $category->image) }}" width="100"
                                alt="">
                        @endif
                    </td>
                    <td> {{ $category->name }}</td>
                    <td> {{ $category->slug }}</td>
                    <td> <button class="btn btn-{{ $category->status == 1 ? 'success' : 'danger' }} btn-sm "><i
                                class="fa fa-{{ $category->status == 1 ? 'check-circle' : 'times-circle' }} btn-sm  "></i></button>
                    </td>
                    <td> {{ \Carbon\Carbon::parse($category->created_at)->format('d-M-Y') }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary btn-sm"><i
                                class="fas fa-edit"></i></a>
                        <a href="{{ route('categories.show', $category->id) }}" class="btn btn-success btn-sm"><i
                                class="fas fa-eye"></i></a>
                        <a href=""
                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $category->id }}').submit();"
                            class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                        <form id="delete-form-{{ $category->id }}" style="display:none"
                            action="{{ route('categories.destroy', $category->id) }} " method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
            @endforeach
        @endif
    </table>

    {{ $categories->links() }}

@endsection

@section('my-modal')

    <div class="modal fade" id="category_create" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg"role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="category_create">Create Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data"
                        id="categoryForm">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name">Name</label>
                                            <input value=" {{ old('name') }}" required type="text" name="name"
                                                id="name" class="form-control" placeholder="Name">

                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email">Slug</label>
                                            <input value=" {{ old('slug') }}" required type="text" name="slug"
                                                id="slug" class="form-control" placeholder="Slug" readonly>

                                            @error('slug')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
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
                                            <label for="showHome">Show on home page</label>
                                            <select name="showHome" id="showHome" class="form-control">
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="image">image</label>
                                            <input type="file" name="image" id="image" class="form-control">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="pb-5 pt-3">
                            <button type="submit" name="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

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

        document.getElementById('status').addEventListener('change', function() {
            var statusIndicator = document.getElementById('status-indicator');
            var statusValue = this.value;

            if (statusValue === '1') {
                statusIndicator.className = 'status-indicator active';
            } else {
                statusIndicator.className = 'status-indicator inactive';
            }
        });

        // Set a timeout to automatically dismiss the alert
        setTimeout(function() {
            let successAlert = document.getElementById('success-alert');
            if (successAlert) {
                let bsAlert = new bootstrap.Alert(successAlert);
                bsAlert.close();
            }

            let errorAlert = document.getElementById('error-alert');
            if (errorAlert) {
                let bsAlert = new bootstrap.Alert(errorAlert);
                bsAlert.close();
            }
        }, 3000); // Time in milliseconds (5000 ms = 5 seconds)
    </script>
