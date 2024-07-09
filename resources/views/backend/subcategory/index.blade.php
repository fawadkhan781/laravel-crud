@extends('backend.layout.layout')
@section('title')
    <span class="mx-3">Sub Categories</span> <a href="javascript:void(0)" data-bs-toggle="modal"
        data-bs-target="#subcategory_create" class="btn btn-primary btn-sm ms-3"><i class="fas fa-plus"></i></a>
@endsection
@section('content')
    <div class="container ">
        <div class="row justify-content-end w-25">
            <form action="{{ route('subcategories.index') }}" method="get" class="d-flex justify-content-end mb-3 mt-3 ">
                @csrf
                <div>
                    <a href="{{ route('subcategories.index') }}" class="btn btn-primary btn-sm me-2 mt-1"><i
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
            <i class="fa fa-check-circle me-3 fa-2x" style="color: #028f23;"></i> <!-- Font Awesome Icon -->
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
            <th>Name</th>
            <th>Slug</th>
            <th>Image</th>
            <th>Description</th>
            <th>Category</th>
            <th>Status</th>
            <th>Created_at</th>
            <th>Action</th>
        </tr>

        @php
            $counter = $subcategories->firstItem();
        @endphp
       {{-- {{dd($subcategories->toArray())}} --}}
        @foreach ($subcategories as $subcategory)

            <tr>
                <td> {{ $counter++ }}</td>
                <td> {{ $subcategory->name }}</td>
                <td> {{ $subcategory->slug }}</td>
                <td> {{ $subcategory->image }}</td>
                <td>{{ $subcategory->description }}</td>
                <td>{{ $subcategory?->category?->name }}</td>
                <td><button class="btn btn-{{ $subcategory->status == 1 ? 'success' : 'danger' }} btn-sm"><i
                            class="fa fa-{{ $subcategory->status == 1 ? 'check-circle' : 'times-circle' }} btn-sm "></i></button>
                </td>

                <td> {{ \Carbon\Carbon::parse($subcategory->created_at)->format('d-M-Y') }}</td>
                <td>
                    <a href="{{ route('subcategories.edit', $subcategory->id) }}" class="btn btn-primary btn-sm"><i
                            class="fas fa-edit"></i></a>
                    <a href="{{ route('subcategories.show', $subcategory->id) }}" class="btn btn-success btn-sm"><i
                            class="fas fa-eye"></i></a>
                    <a href=""
                        onclick="event.preventDefault(); document.getElementById('delete-form-{{ $subcategory->id }}').submit();"
                        class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                    <form id="delete-form-{{ $subcategory->id }}" style="display:none"
                        action="{{ route('subcategories.destroy', $subcategory->id) }} " method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>

            </tr>
        @endforeach
    </table>


    {{ $subcategories->links() }}
@endsection

@section('my-modal')
    <div class="modal fade" id="subcategory_create" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg"role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="subcategory_create">Create Sub Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('subcategories.store') }}" method="POST" enctype="multipart/form-data"
                        id="subcategoryForm">
                        @csrf
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="name" class=" form-label h5">Name</label>
                                <input value=" {{ old('name') }}" type="text"
                                    class=" @error('name') is-invalid @enderror form-control-lg form-control"
                                    id="name_subcat" name="name" placeholder="name">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label h5">Slug</label>
                                <input value=" {{ old('slug') }}" type="text" class=" form-control-lg form-control"
                                    id="slug_subcat" name="slug_subcat" placeholder="slug" readonly>

                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label h5">Image</label>
                                <input type="file"
                                    class=" @error('image') is-invalid @enderror form-control-lg form-control"
                                    id="image" name="image">
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>


                            <div>
                                <label for="name" class="form-label h5"></label>
                                <select name="category_id" id="category_id" class="form-control">
                                    <option>----Select category ----</option>
                                    @foreach ($category as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
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


                            <div class="mb-3">
                                <label for="name" class="form-label h5">Description</label>
                                <textarea rows="2" value=" {{ old('description') }}" class="form-control-lg form-control" name="description"
                                    cols="30" rows="10" placeholder="description"></textarea>

                            </div>
                            <div class="text-center d-grid">
                                <button type="submit" class="btn btn-lg btn-primary">create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@endSection

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
        }, 5000);
    </script>
@endsection
