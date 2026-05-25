<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        return Category::with('products')->get();
    }

    public function show($id) {
        return Category::with('products')->find($id);
    }

    public function store(Request $request) {
        return Category::create($request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]));
    }

    public function update(Request $request, $id) {
        $category = Category::find($id);
        $category->update($request->validate([
            'name' => 'sometimes|string',
            'description' => 'sometimes|string',
        ]));
        return $category;
    }

    public function destroy($id) {
        Category::destroy($id);
        return response()->noContent();
    }
}