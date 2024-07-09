@extends('backend.layout.layout')
@section('title')
    <span class="mx-3">Brands</span></span> <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#brand_create"
        class="btn btn-primary btn-sm ms-3"><i class="fas fa-plus"></i></a>
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Brands</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Brands</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->

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
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form action="{{ route('brands.index') }}" method="get">
                            @csrf
                            <div class="card-header">
                                <h3 class="card-title">Brands</h3>
                                <div class="card-tools">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <div>
                                            <a href="{{ route('brands.index') }}"
                                                class="btn btn-primary btn-sm me-2 mt-1 fs-6"><i
                                                    class="fa fa-refresh fa-spin fs-6" style="font-size:24px"></i></a>
                                        </div>
                                        <input type="search" name="search" class="form-control float-right"
                                            placeholder="Search" value="{{ request()->search }}">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- /.card-header -->

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Status</th>
                                        <th>Created_at</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($brands as $brand)
                                        <tr>
                                            <td>{{ $brand->id }}</td>
                                            <td>{{ $brand->name }}</td>
                                            <td>{{ $brand->slug }}</td>
                                            <td><button
                                                    class="btn btn-{{ $brand->status == 1 ? 'success' : 'danger' }} btn-sm"><i
                                                        class="fa fa-{{ $brand->status == 1 ? 'check-circle' : 'times-circle' }} btn-sm "></i></button>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($brand->created_at)->format('d-M-Y') }}</td>
                                            <td>
                                                <a href="{{ route('brands.edit', $brand->id) }}"
                                                    class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                                <a href="{{ route('brands.show', $brand->id) }}"
                                                    class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>
                                                <a href=""
                                                    onclick="event.preventDefault(); document.getElementById('delete-form-{{ $brand->id }}').submit();"
                                                    class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                                                <form id="delete-form-{{ $brand->id }}" style="display:none"
                                                    action="{{ route('brands.destroy', $brand->id) }} " method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->

    {{ $brands->links() }}
@endSection

@section('my-modal')
    <div class="modal fade" id="brand_create" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Create Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('brands.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" value="{{ old('name') }}" name="name" id="name"
                                class="form-control" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label for="">Slug</label>
                            <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label for="">Status</label>
                            <select name="status" id="" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
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

        document.getElementById('name').addEventListener('input', function(event) {
            var name = this.value;
            var slug = slugify(name);
            document.getElementById('slug').value = slug;
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
@endsection
