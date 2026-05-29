<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Events\ProductCreated;
use App\Events\ProductUpdated;
use App\Events\ProductDeleted;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    const PRODUCTS_CACHE_TTL = 3600; 
    
    public function index(Request $request) {
        $page = $request->get('page', 1);
        $cacheKey = "products_page_{$page}";
        
        return Cache::tags(['products'])->remember(
            $cacheKey,
            self::PRODUCTS_CACHE_TTL,
            function () {
                return ProductResource::collection(
                    Product::with('tags', 'category')->paginate(15)
                );
            }
        );
    }

    public function show($id) {
        $product = Cache::tags(['products'])->remember(
            "product_{$id}",
            self::PRODUCTS_CACHE_TTL,
            function () use ($id) {
                return Product::with('tags', 'category')->find($id);
            }
        );
        
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        
        return new ProductResource($product);
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
            Cache::tags(['products'])->flush();
        }

        // Cache is automatically cleared by ProductObserver on create
        // Dispatch the ProductCreated event - listeners will handle the rest
        ProductCreated::dispatch($product->load('tags', 'category'));

        return new ProductResource($product->load('tags', 'category'));
    }

    // PUT /api/products/1 - Update
    public function update(Request $request, $id) {
        if (!$request->user() || !$request->user()->isAdmin()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

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

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->update($validated);
        if ($tags !== null) {
            $product->tags()->sync($tags);
            Cache::tags(['products'])->flush();
        }

        // Cache is automatically cleared by ProductObserver on update
        // Dispatch the ProductUpdated event
        ProductUpdated::dispatch($product->load('tags', 'category'));

        return new ProductResource($product->load('tags', 'category'));
    }

    // DELETE /api/products/1 - Delete
    public function destroy(Request $request, $id) {
        // Only admin can delete
        if (!$request->user() || !$request->user()->isAdmin()) {
            return response()->json(['message' => 'Only admins can delete products'], 403);
        }

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();

        // Cache is automatically cleared by ProductObserver on delete
        // Dispatch the ProductDeleted event
        ProductDeleted::dispatch($product);

        return response()->json(null, 204);
    }
}