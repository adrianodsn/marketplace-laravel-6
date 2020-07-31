<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function index($slug)
    {
        $category = $this->category->whereSlug($slug)->firstOrFail();
        return view('category', compact('category'));
    }
}
