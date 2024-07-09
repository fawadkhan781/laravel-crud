<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Enums\Yes;

class FrontController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_featured', 1)->orderBy('id', 'desc')->take(8)->where('status', 1)->get();
        $latestProducts = Product::where('status', 1)->orderBy('created_at', 'desc')->where('is_featured', 0)->take(8)->get();

        return view('front.home', compact('featuredProducts', 'latestProducts'));
    }
      
    
}
