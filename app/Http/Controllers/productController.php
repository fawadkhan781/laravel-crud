<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;



class productController extends Controller
{
    // this method will show product page
    public function index(Request $request)
    {
        if ($request->search) {
            $products = Product::where('name', 'like', '%' . $request->search . '%')->orderBy('created_at', 'desc')->paginate(3)->onEachSide(4);
            return view('backend.products.list', [
                'products' => $products
            ]);
        }

        $products = Product::with('category', 'brand')->orderBy('created_at', 'asc')->paginate(3)->onEachSide(4);
        //dd($products->toArray());
        $categories = Category::orderBy('name', 'asc')->get();
        $brands = Brand::orderBy('name', 'asc')->get();
        $related_products = Product::where('status', 1)->get();   
        return view('backend.products.list', [
            'products' => $products,
             'categories' => $categories, 
             'brands' => $brands,
             'related_products' => $related_products
        ]);
    }

    // this method will show craete page
    public function create()
    {

        $categories = Category::orderBy('name', 'asc')->get();
        $brands = Brand::orderBy('name', 'asc')->get();
        $related_products = [];
        $related_products = Product::where('status', 1)->get();        
        return view('backend.products.create', compact('categories', 'brands', 'related_products'));
    }

    // this method will store product in db table
    public function store(Request $request)
    {
        
        //dd($request->all());
        $rules = [
            'title' => 'required',
            'slug' => 'required',

        ];

        if ($request->image != '') {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route('products.index')->withInput()->withErrors($validator);
        }

        $product = new Product();
        $product->title = $request->title;
        $product->slug = $request->slug;
        $product->sku = $request->sku;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->original_price = $request->original_price;
        // $product->showHome = $request->showHome;
        $product->is_featured = $request->is_featured ? 1 : 0;
        $product->quantity = $request->qty;
        $product->category_id = $request->category;
        $product->brand_id = $request->brand_id;
        $product->status = $request->status;
        $product->shipping_returns = $request->shipping_returns ? 1 : 0;
        $product->short_description = $request->short_description;
        $product->related_products = (!empty($request->related_products)) ? implode(',',$request->related_products) : '';

        $product->save();

        if ($request->image != '') {
            // here we will store image in public folder
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext; //unique name for image

            //save image to products folder
            $image->move(public_path('uploads/products'), $imageName);

            //save image name in db
            $product->image = $imageName;
            $product->save();
        }
        return redirect()->route('products.index')->with('success', 'Product added successfully');
    }



    // this method will show edit product page
    public function edit($id, Request $request)
    {


        $product = Product::findorfail($id);
        $categories = Category::orderBy('name', 'asc')->get();
        $brands = Brand::orderBy('name', 'asc')->get();      
        $related_products = [];
           //fech related products   
           if ($product->related_products != '') {
            $productArray= explode(',', $product->related_products);
            $related_products = Product::whereIn('id',$productArray)->get();        
        }
        return view('backend.products.edit', compact('product', 'categories', 'brands', 'related_products'));
    }   
    public function show($id)
    {
        $product = product::findorfail($id);
        return view('backend.products.view', [
            'product' => $product

        ]);
    }

    // this method will update product 

    public function update(Request $request)
    {
        // Validate the request data
        // $request->validate([
        //     'product_id' => 'required',
        //     'title' => 'required',
        //     'slug' => 'required',
        //     'sku' => 'required',
        //     'price' => 'required',
        //     'category_id' => 'required',
        // ]);
        $id = $request->product_id;
        // Find the product
        $product = Product::findOrFail($id);
        //dd( $product);
        // Update the product attributes
        $product->title = $request->title;
        $product->slug = $request->slug;
        $product->sku = $request->sku;
        $product->price = $request->price ?? 0;
        $product->original_price = $request->original_price ?? 0;
        $product->description = $request->description;
        // $product->showHome = $request->showHome;
        $product->category_id = $request->category_id ?? 0;
        $product->brand_id = $request->brand_id ?? 0;
        $product->quantity = $request->quantity;
        $product->status = $request->status;
        $product->is_featured = $request->is_featured ?? 0;
        $product->shipping_returns = $request->shipping_returns ?? 0;
        $product->short_description = $request->short_description;
        $product->related_products = (!empty($request->related_products)) ? implode(',',$request->related_products) : '';
        $product->save();



        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($product->image) {
                $oldImagePath = public_path('uploads/products/' . $product->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Upload the new image
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/products'), $imageName);
            $product->image = $imageName;
        }

        // Save the updated product
        $product->save();

        // Redirect with success message
        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    // this method will delete product
    public function destroy($id)
    {
        $product = product::findorfail($id);

        //delete image
        File::delete(public_path('uploads/products/' . $product->image));

        //delete product from db
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }

    public function getProducts(Request $request)
    {

        $data = [];
        if ($request->term !== '') {
            $products = Product::where('title', 'like', '%' . $request->term . '%')->get();

            if ($products !== null) {
                foreach ($products as $product) {
                    $data[] = array('id' => $product->id, 'text' => $product->title);
                }
            }
        }

        return response()->json([
            'tags' => $data,
            'status' => true
        ]);
    }
}
