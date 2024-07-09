<?php 

use App\Models\Category;
use App\Models\Product;

function getCategories(){

  return Category::orderBy('name', 'asc')
  ->with('subCategory')
  ->where('status', 1)
  ->where('showHome', 'Yes')
  ->get();
}

function getproducts(){

  return Product::orderBy('title', 'asc')
  ->with('category')
  ->orderBy('id', 'desc')
  ->where('status', 1)
  ->where('is_featured', 1)
  ->get();
}


?>