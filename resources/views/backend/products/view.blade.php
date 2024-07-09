@extends('backend.layout.layout')
@section('title')
    View Product
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Products</h2>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <td>{{ $product->name }}</td>
                        </tr>

                        <tr>
                            <th scope="col">Description</th>
                            <td>{{ $product->description }}</td>
                        </tr>

                        <tr>
                            <th scope="col">Price</th>
                            <td>{{ $product->price }}</td>
                        </tr>




                    </thead>

                </table>

            </div>
        @endsection
