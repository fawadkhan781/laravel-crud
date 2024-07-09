<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;




class ShopController extends Controller
{

    public function index(Request $request, $categorySlug = null, $subCategorySlug = null)
    {

        $categorySelected = '';
        $subCategorySelected = '';

        $categories = Category::orderBy('name', 'asc')->with('SubCategory')->where('status', 1)->get();
        $brands = Brand::orderBy('name', 'asc')->where('status', 1)->get();

        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->first();
            $products = Product::where('category_id', $category->id)->where('status', 1)->paginate(3);
            $categorySelected = $category->id;
            return view('front.shop', compact('categories', 'brands', 'products', 'categorySelected', 'subCategorySelected'));
        }

        if ($subCategorySlug) {
            $subCategory = SubCategory::where('slug', $subCategorySlug)->first();
            $products = Product::where('category_id', $subCategory->category_id)->paginate(3);
            $subCategorySelected = $subCategory->id;
            return view('front.shop', compact('categories', 'brands', 'products', 'categorySelected', 'subCategorySelected'));
        }
        $products = Product::orderBy('id', 'desc')->where('status', 1)->paginate(3);
        if ($request->has('brands')) {
            $selectedBrands = $request->input('brands');
            $products = $products->whereIn('brand_id', $selectedBrands);
        }

        //pigination 




        return view('front.shop', compact('categories', 'brands', 'products'));
    }
    public function priceFilter(Request $request)
    {
        $response = [];
        // $response['result'] = $request->all();
        $request->validate([
            'min' => 'required|numeric|min:0',
            'max' => 'required|numeric|min:0',
        ]);
        if ($request->has('min') && $request->has('max')) {
            $response['result'] = $request->all();
        }
        $min = $request->input('min');
        $max = $request->input('max');

        $products = Product::where('status', 1)->whereBetween('price', [$min, $max])->orderby('id', 'desc')->get();
        $response['products'] = $products;
        return response()->json($response);
    }



    public function sortFilter(Request $request)
    {


        $request->validate([
            'sort' => 'required',
        ]);

        $sort = $request->input('sort');

        if ($sort == 'latest') {
            $products = Product::where('status', 1)->orderBy('created_at', 'desc')->get();
        } elseif ($sort == 'price_desc') {
            $products = Product::where('status', 1)->orderBy('price', 'desc')->get();
        } elseif ($sort == 'price_asc') {
            $products = Product::where('status', 1)->orderBy('price', 'asc')->get();
        } else {
            $products = Product::where('status', 1)->get();
        }

        return response()->json(['products' => $products]);
    }

    // products page 

    public function product($slug)
    {
        $product = Product::where('slug', $slug)->with('category', 'subCategory', 'brand')->first();

        if (!$product) {
            abort(404);
        }

           // Fetch related products
        $relatedProducts=[];
        $related_products_array = [];
        if($product->related_products){
            $related_products_array = explode(',', $product->related_products);
        }
        //$relatedProducts = Product::where('category_id', $product->category_id)->where('status', 1)->where('id', '!=', $product->id)->get();
        $relatedProducts = Product::whereIn('id', $related_products_array)->where('status', 1)->get();

        return view('front.product', compact('product', 'relatedProducts'));
    }

    //add to cart
    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|numeric|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()]);
        }

        $product = Product::where('slug', $request->slug)->first();
        if (!$product) {
            abort(404);
        }

        $cart = session()->get('cart');
        if (!$cart) {
            $cart = [
                $product->slug => [
                    "name" => $product->name,
                    "quantity" => $request->quantity,
                    "price" => $product->price,
                    "image" => $product->image,
                ]
            ];
            session()->put('cart', $cart);
            return response()->json(['success' => 'Product added to cart.']);
        }

        if (isset($cart[$product->slug])) {
            $cart[$product->slug]['quantity'] += $request->quantity;
            session()->put('cart', $cart);
            return response()->json(['success' => 'Product added to cart.']);
        }

        $cart[$product->slug] = [
            "name" => $product->name,
            "quantity" => $request->quantity,
            "price" => $product->price,
            "image" => $product->image,
        ];
        session()->put('cart', $cart);
        return response()->json(['success' => 'Product added to cart.']);
    }


  
}
