@extends('backend.layout.layout')
@section('title')
    edit Product
@endsection
@section('content')

    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Product</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="{{ route('products.update') }}" method="POST" enctype="multipart/form-data" id="productForm">
                @csrf
                @method('PUT')
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="title">Title</label>
                                            <input value="{{ $product->title }}" type="text" name="title" id="title" class="form-control" placeholder="Title">
                                        </div>
                                    </div>
            
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="slug">Slug</label>
                                            <input value="{{ $product->slug }}" type="text" name="slug" id="slug" class="form-control" placeholder="Slug" readonly>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="image" class="form-label">Image</label>
                                        <input type="file" class="form-control" id="image" name="image">
                                        @if ($product->image)
                                            <img src="{{ asset('uploads/products/'.$product->image) }}" alt="{{ $product->title }}" width="100">
                                        @endif
                                    </div> 
            
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="sku" class="form-label">SKU</label>
                                            <input value="{{ $product->sku }}" type="text" class="form-control" id="sku" name="sku" required>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Short Description</label>
                                            <textarea class="form-control" id="short_description" name="short_description" rows="3" required>{{ old('description', $product->short_description) }}</textarea>
                                        </div>
                                    </div>
            
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $product->description) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="discription" class="form-label">Shipping and Returns</label>
                                            <textarea class="form-control" id="shipping_returns" name="shipping_returns" rows="3" required>{{ old('discription', $product->shipping_returns) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Price</label>
                                            <input value="{{ $product->price }}" type="text" class="form-control" id="price" name="price" required>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="original_price" class="form-label"> Original Price</label>
                                            <input value="{{ $product->original_price }}" type="text" class="form-control" id="original_price" name="original_price" required>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                      
                        
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', $product->quantity) }}" required>
                        </div>
            
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
            
                        <div class="mb-3">
                            <label for="showHome" class="form-label">Show on Home Page</label>
                            <select name="showHome" id="showHome" class="form-control">
                                <option value="Yes" {{ strtolower($product->showHome) == 'yes' ? 'selected' : '' }}>Yes</option>
                                <option value="No" {{ strtolower($product->showHome) == 'no' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                    </div>
                                                                                                          
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product category</h2>
                                <div class="mb-3">
                                    <label for="category">Category</label>
                                    <select name="category_id" id="category" class="form-control">
                                        <option value="">Select category</option>
                                        @if (!empty($data['categories']))
                                            @foreach ($data['categories'] as $category)
                                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="sub_category">Sub category</label>
                                    <select name="sub_category_id" id="sub_category" class="form-control">
                                        <option value="">Select sub category</option>
                                        @if (!empty($data['subcategories']))
                                            @foreach ($data['subcategories'] as $subcategory)
                                                <option value="{{ $subcategory->id }}" {{ $product->category_id == $subcategory->category_id ? 'selected' : '' }}>{{ $subcategory->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product brand</h2>
                                <div class="mb-3">
                                    <label for="brand">Brand</label>
                                    <select name="brand_id" id="brand" class="form-control">
                                        <option value="">Select brand</option>
                                        @if (!empty($data['brands']))
                                            @foreach ($data['brands'] as $brand)
                                                <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
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
                                    <select name="is_featured" id="is_featured" class="form-control">
                                        <option value="0" {{ $product->is_featured == 0 ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ $product->is_featured == 1 ? 'selected' : '' }}>Yes</option>
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
                                                <option selected value="{{ $relProduct->id }}">{{ $relProduct->title }}</option>
                                            @endforeach
                                          
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>


        <!-- /.card -->

    </section>

@endsection

@section('custom-js')
    <script>

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
        $(document).ready(function() {
        $('#category').on('change', function() {
            var categoryId = $(this).val();
            if (categoryId) {
                $.ajax({
                    url: '{{ url('get-subcategories') }}/' + categoryId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#sub_category').empty();
                        $('#sub_category').append('<option value="">Select sub category</option>');
                        $.each(data, function(key, value) {
                            $('#sub_category').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#sub_category').empty();
                $('#sub_category').append('<option value="">Select sub category</option>');
            }
        });
    });
    </script>
@endsection
