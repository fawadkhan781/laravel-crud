@extends('backend.layout.layout')
@section('mystyle')
<style>
    .select2-container{
        z-index: 999999 !important;
    }
</style>
@endsection
@section('title')
    <span class="mx-3">Products</span> <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#products_create"
        class="btn btn-primary btn-sm ms-3"><i class="fas fa-plus"></i></a>
@endsection

@section('content')
    <div class="container ">
        <div class="row justify-content-end w-25">
            <form action="{{ route('products.index') }}" method="get" class="d-flex justify-content-end mb-3 mt-3 ">
                @csrf
                <div>
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm me-2 mt-1"><i
                            class="fa fa-refresh fa-spin" style="font-size:24px"></i></a>
                </div>
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search"
                    value="{{ request()->search }}">
                <button class="btn btn-outline-success" type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>
    {{-- products table --}}

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
            {{-- products table header --}}
            <th>ID</th>
            <th>title</th>
            <th>slug</th>
            <th>Image</th>
            <th>sku</th>
            <th>Description</th>
            <th>price</th>
            <th>original price</th>        
            <th>Quantity</th>
            <th>Status</th>
            <th>Category-id</th>
            <th>brand-id</th>
            <th>Featured</th>
            <th>Created_at</th>
            <th>Action</th>


        </tr>
        @php
            $counter = $products->firstItem();
        @endphp

        @if ($products->isNotEmpty())
            @foreach ($products as $product)
                <tr>
                    {{-- {{ $product->iteration() }} --}}
                    <td> {{ $counter++ }}</td>
                    <td> {{ $product->title }}</td>
                    <td> {{ $product->slug }}</td>
                    <td>
                        @if ($product->image != '')
                            <img width="50" src="{{ asset('uploads/products/' . $product->image) }}" width="100"
                                alt="">
                        @endif
                    </td>
                    <td> {{ $product->sku }}</td>
                    <td> {!! $product->description !!}</td>

                    <td> {{ $product->price }}</td>
                    <td> {{ $product->original_price }}</td>
                    <td> {{ $product->quantity }}</td>
                    <td> <button class="btn btn-{{ $product->status == 1 ? 'success' : 'danger' }} btn-sm"><i
                                class="fa fa-{{ $product->status == 1 ? 'check-circle' : 'times-circle' }} btn-sm "></i></button>
                    </td>
                    <td> {{ $product?->category?->name }} </td>
                    <td> {{ $product?->brand?->name }}</td>
                    <td> <button class="btn btn-{{ $product->is_featured == 1 ? 'success' : 'danger' }} btn-sm"><i
                                class="fa fa-{{ $product->is_featured == 1 ? 'check-circle' : 'times-circle' }} btn-sm "></i></button>
                    </td>
                    <td> {{ \Carbon\Carbon::parse($product->created_at)->format('d-M-Y') }}</td>
                    <td>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm"><i
                                class="fas fa-edit "></i></a>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-success btn-sm"><i
                                class="fas fa-eye "></i></a>
                        <a href=""
                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $product->id }}').submit();"
                            class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                        <form id="delete-form-{{ $product->id }}" style="display:none"
                            action="{{ route('products.destroy', $product->id) }} " method="POST">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
            @endforeach
        @endif

    </table>

    {{ $products->links() }}
@endsection

@section('my-modal')

    <div class="modal fade" id="products_create" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl"role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Create Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="title">Title</label>
                                                    <input value="{{ old('title') }}" type="text" name="title"
                                                        id="title" class="form-control" placeholder="Title">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="slug">Slug</label>
                                                    <input value="{{ old('slug') }}" type="text" name="slug"
                                                        id="slug" class="form-control" placeholder="Slug" readonly>
                                                </div>
                                            </div>

                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="sku">SKU (Stock Keeping Unit)</label>
                                                                <input type="text" name="sku" id="sku"
                                                                    class="form-control" placeholder="sku">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label for="description">Description</label>
                                                                <textarea name="description" id="description" cols="30" rows="10" class="summernote"
                                                                    placeholder="Description"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card mb-3">
                                                <div class="card-body">
                                                    <h2 class="h4 mb-3">image</h2>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label for="image">Image</label>
                                                                <input type="file" name="image" id="image"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="card mb-3">
                                                    <div class="card-body">
                                                        <h2 class="h4 mb-3">Pricing</h2>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="price">Price</label>
                                                                    <input type="text" name="price" id="price"
                                                                        class="form-control" placeholder="Price">
                                                                </div>


                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="mb-3">
                                                                    <label for="original_price"> Original Price</label>
                                                                    <input type="text" name="original_price"
                                                                        id="original_price" class="form-control"
                                                                        placeholder="Original Price">
                                                                </div>
                                                                
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="qty">Qty</label>
                                                    <input type="number" min="0" name="qty" id="qty"
                                                        class="form-control" placeholder="Qty">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Product status</h2>
                                        <div class="mb-3">
                                            <select name="status" id="status" class="form-control">
                                                <option value="1">Active</option>
                                                <option value="0">Block</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <h2 class="h4  mb-3">Product category</h2>
                                        <div class="mb-3">
                                            <label for="category">Category</label>
                                            <select name="category" id="category" class="form-control">
                                                <option value="">select category</option>
                                                @if (!empty($categories))
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="category">Sub category</label>
                                            <select name="sub_category" id="sub_category" class="form-control">
                                                <option value="">Mobile</option>
                                                <option value="">Home Theater</option>
                                                <option value="">Headphones</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Product brand</h2>
                                        <div class="mb-3">
                                            <select name="brand_id" id="brand_id" class="form-control">
                                                <option value="">select brand</option>
                                                @if (!empty($brands))
                                                    @foreach ($brands as $brand)
                                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Featured product</h2>
                                        <div class="mb-3">
                                            <select name="status" id="status" class="form-control">
                                                <option value="0">No</option>
                                                <option value="1">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="status">status</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Related product</h2>
                                        <div class="mb-3">  
                                            <select name="related_products[]" id="related_products" class="form-control related_product" multiple >
                                                @if (!empty($related_products))
                                                @foreach ($related_products as $relProduct)
                                                    <option value="{{ $relProduct->id }}">{{ $relProduct->title }}</option>
                                                @endforeach
                                              
                                            @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pb-5 pt-3">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>

                </div>
            </div>

        </div>
    </div>
    </div>
    </form>
    </section>

@endsection

@section('custom-js')
    <script>
        // Select2
         $('.related_product').select2({
            ajax: {
                url: "{{ route('get_ajax_products') }}",
                datatype: 'json',
                tags : true,
                multiple: true,
                minimumInputLength: 3,
                processResults: function (data) {
                    return {
                        results: data.tags
                    };
                }
            }
        });
        // Function to create a slug
        function slugify(text) {
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-') // Replace spaces with -
                .replace(/[^\w\-]+/g, '') // Remove all non-word chars
                .replace(/\-\-+/g, '-') // Replace multiple - with single -
                .replace(/^-+/, '') // Trim - from start of text
                .replace(/-+$/, ''); // Trim - from end of text

        }

        document.getElementById('title').addEventListener('input', function(event) {
            var name = this.value;
            var slug = slugify(name);
            document.getElementById('slug').value = slug;

        });
        $('#category').on('change', function() {
            var category_id = this.value;
            $.ajax({
                type: "GET",
                url: "{{ route('get_ajax_subcategory') }}",
                data: {
                    'category_id': category_id
                }
            }).done(function(response) {
                var subcategories = response.subcategory;
                var subCategoryHtml = '';
                if (subcategories.length > 0) {
                    subcategories.forEach(function(subcategory) {
                        subCategoryHtml += '<option value="' + subcategory.id + '">' + subcategory
                            .name + '</option>';
                    });
                } else {
                    subCategoryHtml += '<option value="">No subcategory found</option>';
                }


                $('#sub_category').html(subCategoryHtml);
            });
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
        }, 3000);
    </script>
@endsection
