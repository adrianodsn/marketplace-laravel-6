<?php

namespace App\Http\Views;

use App\Models\Category;

class CategoryViewComposer
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function compose($view)
    {
        $categories = $this->category::all(['name', 'slug']);
        return $view->with('categories', $categories);
    }
}
