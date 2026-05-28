<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Jobs\SendNotificationEmail;
use App\Jobs\GenerateInvoicePDF;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    const PRODUCTS_CACHE_TTL = 3600; // Cache duration in seconds (1 hour)
    
    // GET /api/products - Get all with tags and category (paginated)
    public function index(Request $request) {
        $page = $request->get('page', 1);
        $cacheKey = "products_page_{$page}";
        
        // Cache each page separately for 1 hour
        return Cache::remember(
            $cacheKey,
            self::PRODUCTS_CACHE_TTL,
            function () {
                return ProductResource::collection(
                    Product::with('tags', 'category')->paginate(15)
                );
            }
        );
    }

    // GET /api/products/1 - Get one
    public function show($id) {
        // Cache individual products for 1 hour
        $product = Cache::remember(
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
        }

        // Clear all product caches when new product is created
        Cache::tags(['products'])->flush();

        // Dispatch the email job
        $userEmail = auth()->user() ? auth()->user()->email : 'admin@example.com'; // Assuming user is authenticated
        
        SendNotificationEmail::dispatch($product, $userEmail);
        GenerateInvoicePDF::dispatch($product);

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
        }

        // Clear all product-related caches
        Cache::forget("product_{$id}");
        Cache::tags(['products'])->flush(); // Clears all product pages

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

        // Clear all product-related caches when product is deleted
        Cache::tags(['products'])->flush();

        return response()->json(null, 204);
    }
}