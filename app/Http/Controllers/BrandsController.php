<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;



class BrandsController extends Controller
{

    public function index(Request $request)
    {
        if ($request->search) {
            $brands = Brand::where('name', 'like', '%' . $request->search . '%')->orderBy('created_at', 'asc')->paginate(3)->onEachSide(4);
            return view('backend.brands.index', [
                'brands' => $brands
            ]);
        }
        $brands = Brand::orderBy('created_at', 'asc')->paginate(3)->onEachSide(4);
        return view('backend.brands.index', [
            'brands' => $brands

        ]);
    }

    public function create()
    {
        return view('backend.brands.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required |unique:brands,slug',
            'status' => 'required',

        ];


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            return redirect()->route('brands.create')->withInput()->withErrors($validator);
        }

        // here we will insert brand in db
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = $request->slug;
        $brand->status = $request->status;
        $brand->save();

        return redirect()->route('brands.index')->with('success', 'Brand created successfully');
    }



    public function edit($id)
    {
        $brand = Brand::find($id);

        return view('backend.brands.edit', [
            'brand' => $brand
        ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required |unique:brands,slug,' . $id,
            'status' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            return redirect()->route('brands.edit', $id)->withInput()->withErrors($validator);
        }

        $brand = Brand::find($id);
        $brand->name = $request->name;
        $brand->slug = $request->slug;
        $brand->status = $request->status;
        $brand->save();
        return redirect()->route('brands.index')->with('success', 'Brand updated successfully');
    }

    public function show($id)
    {
        $brand = Brand::find($id);
        return view('backend.brands.view', [
            'brand' => $brand
        ]);
    }

    public function destroy($id)
    {
        $brand = Brand::find($id);
        $brand->delete();
        return redirect()->route('brands.index')->with('success', 'Brand deleted successfully');
    }
}
