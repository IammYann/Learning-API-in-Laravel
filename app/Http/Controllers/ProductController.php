<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // GET /api/products - Get all
    public function index() {
        return Product::all();
    }

    // GET /api/products/1 - Get one
    public function show($id) {
        return Product::find($id);
    }

    // POST /api/products - Create
    public function store(Request $request) {
        return Product::create($request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'sometimes|exists:categories,id',  // ← Add this
        ]));
    }

    // PUT /api/products/1 - Update
    public function update(Request $request, $id) {
        $product = Product::find($id);
        $product->update($request->validate([
            'name' => 'sometimes|string',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'category_id' => 'sometimes|exists:categories,id',  // ← Add this
        ]));
        return $product;
    }

    // DELETE /api/products/1 - Delete
    public function destroy($id) {
        Product::destroy($id);
        return response()->noContent();
    }
}