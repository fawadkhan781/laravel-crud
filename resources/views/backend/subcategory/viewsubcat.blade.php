@extends('backend.layout.layout')

@section('title')
    view Sub Category
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Sub Category</h2>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <td>{{ $subcategory->name }}</td>
                        </tr>

                        <tr>
                            <th scope="col">Slug</th>
                            <td>{{ $subcategory->slug }}</td>
                        </tr>

                        <tr>
                            <th scope="col">Status</th>
                            <td>{{ $subcategory->status }}</td>
                        </tr>

                        <tr>
                            <th scope="col">Created_at</th>
                            <td>{{ \Carbon\Carbon::parse($subcategory->created_at)->format('d-M-Y') }}</td>
                        </tr>

                    </thead>
                </table>
            </div>
        </div>
    </div>
@endSection
