@extends('front.layouts.app')

@section('content')

<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.home') }}">Home</a></li>
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.homepage') }}">Shop</a></li>
                <li class="breadcrumb-item"><a class="white-text" href="{{ route('front.product', $product->slug) }}">{{ $product->title }}</a></li>
            </ol>
        </div>
    </div>
</section>

<section class="section-7 pt-3 mb-3">
    <div class="container">
        <div class="row ">
            <div class="col-md-5">
                <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner bg-light">

                         @if ($product->image != '')
                         @foreach (is_array($product->image) ? $product->image : [$product->image] as $key => $image)
                         <div class="carousel-item {{ ($key == 0) ? 'active' : '' }}">
                            <img class="w-100 h-100" src="{{ asset('uploads/products/' . $product->image) }}" alt="Image">
                        </div> 
                         @endforeach
                             
                         @endif
                       
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-bs-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-bs-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-7">
                <div class="bg-light right">
                    <h1>{{ $product->title }}</h1>
                    <div class="d-flex mb-3">
                        <div class="text-primary mr-2">
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star-half-alt"></small>
                            <small class="far fa-star"></small>
                        </div>
                        <small class="pt-1">(99 Reviews)</small>
                    </div>

                    @if ($product->original_price > 0)
                    <h2 class="price text-secondary"><del>${{ $product->original_price }}</del></h2>
                    @endif
                  
                    <h2 class="price ">${{ $product->price }}</h2>

                    {!! $product->short_description !!}
                    <a href="cart.php" class="btn btn-dark"><i class="fas fa-shopping-cart"></i> &nbsp;ADD TO CART</a>
                </div>
            </div>

            <div class="col-md-12 mt-5">
                <div class="bg-light">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping" type="button" role="tab" aria-controls="shipping" aria-selected="false">Shipping & Returns</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                            <p>
                                {!! $product->description !!} 
                            </p>
                        </div>
                        <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                        {!! $product->shipping_returns !!}
                        </div>
                        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        
                        </div>
                    </div>
                </div>
            </div> 
        </div>           
    </div>
</section>


    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center">Related Products</h2>
                </div>
            </div>
           
            <div class="row">
                @if($relatedProducts?->count() > 0)
                @foreach ($relatedProducts as $relatedProduct)  
                    <div class="col-md-3">
                        <div class="card product-card">
                            <div class="product-image position-relative">
                                <a href="{{ route('front.product', $relatedProduct->slug) }}" class="product-img">
                                    @if ($relatedProduct->image != '')
                                        <img class="card-img-top img-fluid h-200 customImgHg"
                                            src="{{ asset('uploads/products/' . $relatedProduct->image) }}"
                                            alt="">
                                </a>
                            @else
                                <img class="card-img-top img-fluid h-200px customImgHg"
                                    src="{{ asset('uploads/products/default.png') }}" alt=""></a>   
                             @endif
                                <a class="whishlist" href="#"><i class="far fa-heart"></i></a>
                                <div class="product-action">
                                    <a class="btn btn-dark" href="#">
                                        <i class="fa fa-shopping-cart"></i> Add To Cart
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $relatedProduct->title }}</h5>
                                <p class="card-text">৳ {{ $relatedProduct->price }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
                @else
                <div class="text-center mb-3">
                    <h6 class="pt-3">No Related Product Found</h6>
                </div>
                @endif
            </div>
        </div>
    </section>

    @endsection

    @section('custom-js')


      

    @endsection