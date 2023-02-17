<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\CategoryCreateRequest;
use App\Models\Category;
use Str;

class CategoryController extends Controller
{
    public function index() {
        return abort(404);
    }

    public function store(Request $request) {
        try {
            $data = $request->all();
            $data['name'] = ucfirst($data['name']);
            
            $category = new Category($data);
            $category->save();
            return back()->with('message', 'Category added successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['message' => 'Could not store category name...']);
        }
    }
    
    public function destroy(Category $category) {
        $name = $category->name;
        $message = 'Category ' . $name . ' has not been removed.';

        if($category->deleteCategory()){
           $message = 'Category ' . $name . ' has been removed.';
           return back()->with('message', $message);
        }
    }
}
