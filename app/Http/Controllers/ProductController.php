<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // GET /api/products - Get all with tags
    public function index() {
        return Product::with('tags')->get();
    }

    // GET /api/products/1 - Get one
    public function show($id) {
        return Product::with('tags')->find($id);
    }

    // POST /api/products - Create
    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'sometimes|exists:categories,id',
            'tags' => 'sometimes|array',
            'tags.*' => 'exists:tags,id'
        ]);

        $tags = $validated['tags'] ?? [];
        unset($validated['tags']);

        $product = Product::create($validated);
        if (!empty($tags)) {
            $product->tags()->attach($tags);
        }
        return $product->load('tags');
    }

    // PUT /api/products/1 - Update
    public function update(Request $request, $id) {
        $product = Product::find($id);
        $validated = $request->validate([
            'name' => 'sometimes|string',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'category_id' => 'sometimes|exists:categories,id',
            'tags' => 'sometimes|array',
            'tags.*' => 'exists:tags,id'
        ]);

        $tags = $validated['tags'] ?? null;
        unset($validated['tags']);

        $product->update($validated);
        if ($tags !== null) {
            $product->tags()->sync($tags);
        }
        return $product->load('tags');
    }

    // DELETE /api/products/1 - Delete
    public function destroy($id) {
        Product::destroy($id);
        return response()->noContent();
    }
}