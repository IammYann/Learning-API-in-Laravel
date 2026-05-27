<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Jobs\SendNotificationEmail;
use App\Jobs\GenerateInvoicePDF;

class ProductController extends Controller
{
    // GET /api/products - Get all with tags and category
    public function index() {
        return ProductResource::collection(Product::with('tags', 'category')->get());
    }

    // GET /api/products/1 - Get one
    public function show($id) {
        return new ProductResource(Product::with('tags', 'category')->find($id));
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
        // Dispatch the email job
        $userEmail = auth()->user() ? auth()->user()->email : 'admin@example.com'; // Assuming user is authenticated
        
        SendNotificationEmail::dispatch($product, $userEmail);
        GenerateInvoicePDF::dispatch($product);

        return new ProductResource($product->load('tags', 'category'));
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

        return new ProductResource($product->load('tags', 'category'));
    }

    // DELETE /api/products/1 - Delete
    public function destroy($id) {
        Product::destroy($id);
        return response()->noContent();
    }
}