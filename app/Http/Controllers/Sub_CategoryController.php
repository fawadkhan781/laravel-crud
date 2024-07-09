<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Sub_CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->search) {
            $subcategories = SubCategory::where('name', 'like', '%' . $request->search . '%')->orderBy('created_at', 'asc')->paginate(3)->onEachSide(4);
            return view('backend.subcategory.index', [
                'subcategories' => $subcategories
            ]);
        }

        $subcategories = SubCategory::with('category')->orderBy('created_at', 'asc')->paginate(3)->onEachSide(4);
        $category = Category::orderBy('name', 'asc')->get();

        return view('backend.subcategory.index', compact('subcategories', 'category'));
    }

    public function create()
    {
        $categories = Category::get();
        return view('backend.subcategory.create', [
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {

        $rules = [
            'name' => 'required',
            'slug_subcat' => 'required|unique:sub_categories,slug',
            'status' => 'required',
            'category_id' => 'required',
        ];

        if ($request->image != '') {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route('subcategories.index')->withInput()->withErrors($validator);
        }

        // here we will insert subcategory in db
        $subcategory = new SubCategory();
        $subcategory->name = $request->name;
        $subcategory->slug = $request->slug_subcat;
        $subcategory->category_id = $request->category_id;
        $subcategory->description = $request->description;
        $subcategory->image = $request->image;
        $subcategory->status = $request->status;
        $subcategory->showHome = $request->showHome;
        $subcategory->save();

        if ($request->image != '') {
            // here we will store image in public folder
            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $image_name = time() . '.' . $ext;
            $image->move('public/uploads/subcategory/', $image_name);
            $subcategory->image = $image_name;
            $subcategory->save();
        }

        return redirect()->route('subcategories.index')->with('success', 'SubCategory created successfully');
    }

    public function edit($id)
    {
        $subcategory = SubCategory::find($id);
        $category = Category::get();
        return view('backend.subcategory.editsub', compact('subcategory', 'category'));
    }

    public function update(Request $request, $id)
    {

        $subcategory = SubCategory::find($id);
        $rules = [
            'name' => 'required',
            'slug' => 'required |unique:sub_categories,slug,' . $subcategory->id,
            'status' => 'required',


        ];


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route('subcategories.edit', $subcategory->id)->withInput()->withErrors($validator);
        }


        $subcategory->name = $request->name;
        $subcategory->slug = $request->slug;
        $subcategory->category_id = $request->category_id;
        $subcategory->description = $request->description;
        $subcategory->status = $request->status;
        $subcategory->showHome = $request->showHome;
        $subcategory->image = $request->image;
        $subcategory->save();

        if ($request->image != '') {
            // here we will delete old image
            if (file_exists('public/uploads/subcategory/' . $subcategory->image)) {
                unlink('public/uploads/subcategory/' . $subcategory->image);
            }

            // here we will store image in public folder
            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();
            $image_name = time() . '.' . $ext;
            $image->move('public/uploads/subcategory/', $image_name);
            $subcategory->image = $image_name;
            $subcategory->save();
        }

        return redirect()->route('subcategories.index')->with('success', 'SubCategory updated successfully');
    }

    public function show($id)
    {
        $subcategory = SubCategory::find($id);
        return view('backend.subcategory.viewsubcat', [
            'subcategory' => $subcategory
        ]);
    }

    public function destroy($id)
    {
        $subcategory = SubCategory::find($id);
        $subcategory->delete();
        return redirect()->route('subcategories.index')->with('success', 'SubCategory deleted successfully');
    }

    //get sub category slug

    public function getSlug(Request $request)
    {
        $slug = Str::slug($request->name);
        return response()->json(['slug' => $slug]);
    }
    public function get_ajax_subcategory(Request $request)
    {
        $subcategory = SubCategory::where('category_id', $request->category_id)->get();
        return response()->json(['subcategory' => $subcategory]);
    }
}
