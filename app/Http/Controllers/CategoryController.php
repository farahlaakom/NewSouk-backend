<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // GET all categories
    public function index()
    {
        return response()->json(Category::all());
    }

    // CREATE category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = Category::create([
            'name' => $request->name
        ]);

        return response()->json($category, 201);
    }

    // GET single category
    public function show(Category $category)
    {
        return response()->json($category);
    }

    // UPDATE category
    public function update(Request $request, Category $category)
    {
        $category->update($request->only('name'));

        return response()->json($category);
    }

    // DELETE category
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(['message' => 'Deleted']);
    }
}