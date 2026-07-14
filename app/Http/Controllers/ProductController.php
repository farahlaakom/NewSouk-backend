<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // GET all products
    public function index()
    {
        return response()->json(
            Product::with(['user', 'category'])->latest()->get(),
            200
        );
    }

    // CREATE product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'stock' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|file|max:40960',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product = Product::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'stock' => $validated['stock'] ?? 0,
            'user_id' => auth()->id(),
            'category_id' => $validated['category_id'],
            'image' => $imagePath,
        ]);

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);
    }

    // GET single product
    public function show($id)
    {
        $product = Product::with(['user', 'category'])->find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json($product, 200);
    }

    // UPDATE product
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        $product->update($validated);

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product->fresh()
        ], 200);
    }

    // DELETE product
public function destroy($id)
{
    $product = Product::find($id);

    if (!$product) {
        return response()->json([
            'message' => 'Product not found'
        ], 404);
    }

    if ($product->image) {
        Storage::disk('public')->delete($product->image);
    }

    $product->delete();

    return response()->json([
        'message' => 'Product deleted successfully'
    ]);
}
}
