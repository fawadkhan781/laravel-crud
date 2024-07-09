@extends('front.layouts.app')

@section('content')


    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                    <li class="breadcrumb-item active">Shop</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-6 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 sidebar">
                    <div class="sub-title mt-5">
                        <h2>Price</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <input type="text" class="js-range-slider" name="my_range" value="0;100" />
                        </div>
                    </div>
                    <div class="sub-title">
                        <h2>Categories</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="accordion accordion-flush" id="accordionExample">
                                @if ($categories->isNotEmpty())
                                    <a href="{{ route('front.homepage') }}"
                                        class="nav-item nav-link {{ request()->routeIs('front.homepage') && !request()->segment(2) ? 'text-primary' : '' }}">All</a>
                                    @foreach ($categories as $key => $category)
                                        <div class="accordion-item">
                                            @if ($category->subCategory->isNotEmpty())
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseOne-{{ $key }}"
                                                        aria-expanded="false"
                                                        aria-controls="collapseOne-{{ $key }}">
                                                        {{ $category->name }}
                                                    </button>
                                                </h2>
                                            @else
                                                <a href="{{ route('front.homepage', $category->slug) }}"
                                                    class="nav-item nav-link {{ request()->is('shop/' . $category->slug) ? 'text-primary' : '' }}">
                                                    {{ $category->name }}
                                                </a>
                                            @endif

                                            @if ($category->subCategory->isNotEmpty())
                                                <div id="collapseOne-{{ $key }}"
                                                    class="accordion-collapse collapse {{ request()->is('shop/' . $category->slug) ? 'show' : '' }}"
                                                    aria-labelledby="headingOne-{{ $key }}"
                                                    data-bs-parent="#accordionExample" style="">
                                                    <div class="accordion-body">
                                                        <div class="navbar-nav">
                                                            @foreach ($category->subCategory as $subCategory)
                                                                <a href="{{ route('front.homepage', [$category->slug, $subCategory->slug]) }}"
                                                                    class="nav-item nav-link {{ request()->is('shop/' . $category->slug . '/' . $subCategory->slug) ? 'text-primary' : '' }}">
                                                                    {{ $subCategory->name }}
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>


                    {{-- Brands --}}
                   
                    <div class="sub-title mt-5">
                        <h2>{{ $categoryName ?? 'Brands' }}</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            @if ($brands->isNotEmpty())
                                <form method="GET" action="{{ route('front.homepage', [$categorySlug ?? '', $subCategorySlug ?? '']) }}">
                                    @foreach ($brands as $key => $brand)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input brand-label" name="brands[]" type="checkbox"
                                                value="{{ $brand->id }}" id="brand-{{ $brand->id }}"
                                                {{ request()->has('brands') && in_array($brand->id, request()->input('brands')) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="brand-{{ $brand->id }}">
                                                {{ $brand->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                    <button type="submit" class="btn btn-primary mt-2">Apply Filters</button>
                                </form>
                            @endif
                        </div>
                        
                        <!-- Display Products -->
                        {{-- <div class="products">
                            @foreach ($products as $product)
                                <div class="product-item text-center border border-gray-200 text-primary font-weight-bold fs-3">
                                    <h3>{!! $product->name !!}</h3>
                                    <p>{!! $product->description !!}</p>
                                    <!-- Add other product details here -->
                                </div>
                            @endforeach
                        </div> --}}
                        
                    </div>

                 
                </div>
                <div class="col-md-9">
                    <div class="row pb-3">
                        <div class="col-12 pb-1">
                            <div class="d-flex align-items-center justify-content-end mb-4">
                                <div class="ml-2">
                                    {{-- <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                                            data-bs-toggle="dropdown">Sorting</button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#">Latest</a>
                                            <a class="dropdown-item" href="#">Price High</a>
                                            <a class="dropdown-item" href="#">Price Low</a>
                                        </div>
                                    </div> --}}

                                    <select name="sort" id="sort" class="form-control">
                                        <option value="latest">Latest</option>
                                        <option value="price_desc">Price High</option>
                                        <option value="price_asc">Price Low</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row pb-3 sdfsd" id="myProductContainer">
                        @if ($products?->isNotEmpty())
                            @foreach ($products as $product)
                                <div class="col-md-4">
                                    <div class="card product-card">
                                        <div class="product-image position-relative">
                                            <a href="#" class="product-img">
                                                @if ($product->image != '')
                                                    <img class="card-img-top img-fluid customImgHg"
                                                        src="{{ asset('uploads/products/' . $product->image) }}"
                                                        alt="">
                                                @else
                                                    <img class="card-img-top img-fluid customImgHg"
                                                        src="{{ asset('uploads/products/default.png') }}" alt="">
                                                @endif
                                            </a>

                                            <a class="whishlist" href="222"><i class="far fa-heart"></i></a>
                                            <div class="product-action">
                                                <a class="btn btn-dark" href="#">
                                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                                </a>
                                            </div>
                                        </div>

                                        <div class="card-body text-center mt-3">
                                            <a class="h6 link" href="product.php">{{ $product->title }}</a>
                                            <div class="price mt-2">
                                                <span class="h5"><strong>${{ $product->price }}</strong></span>
                                                @if ($product->original_price > $product->price)
                                                    <span
                                                        class="h6 text-underline"><del>${{ $product->original_price }}</del></span>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>No Products Available</p>
                        @endif
                    </div>
                    <div class="row pb-3">
                        <div class="col-md-12 pt-5">
                            {{ $products->links() }}


                            {{-- <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end">
                                    <li class="page-item disabled">
                                        <a class="page-link" href="#" tabindex="-1"
                                            aria-disabled="true">Previous</a>
                                    </li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item">
                                        <a class="page-link" href="#">Next</a>
                                    </li>
                                </ul>
                            </nav> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endSection

@section('custom-js')
<script>


rangeSlider= $('.js-range-slider').ionRangeSlider({
    type: "double",
    min: 0,
    max: 1000,
    from: 0,
    step: 10,
    to: 500,
    skip: "round",
    max_postfix: "+",
    prefix: '$',
    onFinish: function () {
        applyFilters();

    }
});

//saving it's instance in a variable
var rangeSlider = $(".js-range-slider").data("ionRangeSlider");


 
//apply sorting and filter
$('#sort').on('change', function() {

    applyFilters();
});





function applyFilters() {

    var min = rangeSlider.result.from;
    var max = rangeSlider.result.to;

    $('input[name=min]').val(min);
    $('input[name=max]').val(max);
    $.ajax({
    type: "POST",
    url: "{{ route('front.homepage.filter') }}",
    data: {
        min: min,
        max: max,
        _token: '{{ csrf_token() }}'
    },
    success: function (data) {
        
        let html = '';
        if(data.products.length == 0){
            html = '<p>No Products Available</p>';
        }
        data.products.forEach(function(product) {
            html += `
                <div class="col-md-4">
                    <div class="card product-card">
                        <div class="product-image position-relative">
                            <a href="#" class="product-img">
                                ${product.image !== '' ? 
                                    `<img class="card-img-top img-fluid customImgHg" src="{{ asset('uploads/products/') }}/${product.image}" alt="${product.title}">` : 
                                    `<img class="card-img-top img-fluid customImgHg" src="{{ asset('uploads/products/default.png') }}" alt="default image">`}
                            </a>
                            <a class="whishlist" href="#"><i class="far fa-heart"></i></a>
                            <div class="product-action">
                                <a class="btn btn-dark" href="#">
                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                </a>
                            </div>
                        </div>
                        <div class="card-body text-center mt-3">
                            <a class="h6 link" href="product.php">${product.title}</a>
                            <div class="price mt-2">
                                <span class="h5"><strong>$${product.price}</strong></span>
                                ${product.original_price > product.price ? 
                                    `<span class="h6 text-underline"><del>$${product.original_price}</del></span>` : ''}
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });

        $('#myProductContainer').html(html);

      
      


    }
});

  //sorting

  $(document).ready(function() {
            $('#sort').change(function() {
                var sort = $(this).val();
                $.ajax({
                    url: '{{ route("front.homepage.sort") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        sort: sort
                    },
                    success: function(response) {
                        var products = response.products;
                        var container = $('#myProductContainer');
                        container.empty();
                        if (products.length > 0) {
                            products.forEach(function(product) {
                                var productHtml = `
                                    <div class="col-md-4 item" data-date="${product.created_at}" data-price="${product.price}">
                                        <div class="card product-card">
                                            <div class="product-image position-relative">
                                                <a href="#" class="product-img">
                                                    <img class="card-img-top img-fluid customImgHg" src="/uploads/products/${product.image ? product.image : 'default.png'}" alt="">
                                                </a>
                                                <a class="whishlist" href="222"><i class="far fa-heart"></i></a>
                                                <div class="product-action">
                                                    <a class="btn btn-dark" href="#"><i class="fa fa-shopping-cart"></i> Add To Cart</a>
                                                </div>
                                            </div>
                                            <div class="card-body text-center mt-3">
                                                <a class="h6 link" href="product.php">${product.title}</a>
                                                <div class="price mt-2">
                                                    <span class="h5"><strong>$${product.price}</strong></span>
                                                    ${product.original_price > product.price ? `<span class="h6 text-underline"><del>$${product.original_price}</del></span>` : ''}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                container.append(productHtml);
                            });
                        } else {
                            container.html('<p>No Products Available</p>');
                        }
                    },
                    error: function() {
                        alert('An error occurred while sorting the products.');
                    }
                });
            });
        });
   
}



</script>

 @endsection


