<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;



class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->search) {
            $categories = Category::where('name', 'like', '%' . $request->search . '%')->orderBy('created_at', 'asc')->paginate(3)->onEachSide(4);
            return view('backend.category.index', [
                'categories' => $categories
            ]);
        }

        $categories = Category::orderBy('created_at', 'asc')->paginate(3)->onEachSide(4);
        return view('backend.category.index', [
            'categories' => $categories
        ]);
    }

    public function create()
    {

        return view('backend.category.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required |unique:categories,slug',
            'status' => 'required',
            "showHome" => 'required',

        ];

        if ($request->image != '') {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            //   return Response()->json($validator->errors());
            return redirect()->route('categories.create')->withInput()->withErrors($validator);
        }

        // here we will insert category in db
        $category = new Category();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->status = $request->status;
        $category->showHome = $request->showHome;
        $category->save();

        if ($request->image != '') {
            // here we will store image in public folder
            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $image_name = time() . '.' . $ext;
            $image->move(public_path('/uploads/category'), $image_name);
            $category->image = $image_name;
            $category->save();
        }

        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }


    public function edit($id)
    {
        $category = Category::find($id);
        return view('backend.category.editcat', [
            'category' => $category
        ]);
    }

    public function show($id)
    {
        $category = Category::find($id);
        return view('backend.category.viewcat', [
            'category' => $category
        ]);
    }

    public function update($id, Request $request)
    {
        $category = Category::findorfail($id);
        $rules = [
            'name' => 'required',
            'slug' => 'required',
            'status' => 'required',
            "showHome" => 'required',


        ];

        if ($request->image != '') {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route('category.edit', $id)->withInput()->withErrors($validator);
        }

        $category = Category::findorfail($id);
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->status = $request->status;
        $category->showHome = $request->showHome;
        $category->save();

        if ($request->image != '') {
            // here we will delete old image
            File::delete(public_path('uploads/category/' . $category->image));

            // here we will store image in public folder
            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $image_name = time() . '.' . $ext;
            $image->move(public_path('/uploads/category'), $image_name);
            $category->image = $image_name;
            $category->save();
        }

        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = Category::findorfail($id);
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }

    //get slug
    public function getSlug(Request $request)
    {
        $slug = Str::slug($request->name);
        return response()->json(['slug' => $slug]);
    }
}
