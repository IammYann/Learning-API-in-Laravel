<?php
namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() {
        return CategoryResource::collection(Category::paginate(15));
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
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        $category->update($request->validate([
            'name' => 'sometimes|string',
            'description' => 'sometimes|string',
        ]));
        return new CategoryResource($category);
    }

    public function destroy($id) {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }
        $category->delete();
        return response()->noContent();
    }
}