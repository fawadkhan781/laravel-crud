@extends('backend.layout.layout')
@section('title')
    view Category
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Category</h2>
            <table class="table table-bordered table-striped" >
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <td>{{ $category->name }}</td>
                    </tr>

                    <tr>
                        <th scope="col">Slug</th>
                        <td>{{ $category->slug }}</td>
                    </tr>

                    <tr>
                        <th scope="col">Status</th>
                        <td>{{ $category->status }}</td>
                    </tr>

                    <tr>
                        <th scope="col">Created_at</th>
                        <td>{{ \Carbon\Carbon::parse($category->created_at)->format('d-M-Y') }}</td>
                    </tr>

                </thead>
            </table>
        </div>
    </div>
</div>
@endSection