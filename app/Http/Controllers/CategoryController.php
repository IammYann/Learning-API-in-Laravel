<?php
namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        return CategoryResource::collection(Category::all());
    }

    public function show($id) {
        return new CategoryResource(Category::find($id));
    }

    public function store(Request $request) {
        $validate = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);
        return new CategoryResource(Category::create($validate));
    }

    public function update(Request $request, $id) {
        $category = Category::find($id);
        $category->update($request->validate([
            'name' => 'sometimes|string',
            'description' => 'sometimes|string',
        ]));
        return new CategoryResource($category);
    }

    public function destroy($id) {
        Category::destroy($id);
        return response()->noContent();
    }
}