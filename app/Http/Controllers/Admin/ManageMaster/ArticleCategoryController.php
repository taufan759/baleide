<?php

namespace App\Http\Controllers\Admin\ManageMaster;

use App\Http\Controllers\Controller;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleCategoryController extends Controller
{
    // Tampilkan halaman index
    public function index()
    {
        return view('admin.manage-master.article-category.index');
    }

    // Get all categories
    public function getall()
    {
        $categories = ArticleCategory::withCount('articles')
            ->orderBy('name', 'asc')
            ->get();
        
        return response()->json(['data' => $categories]);
    }

    // Get single category
    public function get(Request $request)
    {
        $category = ArticleCategory::findOrFail($request->id);
        return response()->json($category);
    }

    // Create new category
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        // Generate slug
        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $counter = 1;
        while (ArticleCategory::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        ArticleCategory::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori artikel berhasil ditambahkan',
        ]);
    }

    // Update category
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:article_categories,id',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $category = ArticleCategory::findOrFail($request->id);

        // Generate new slug if name changed
        if ($category->name != $request->name) {
            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $counter = 1;
            while (ArticleCategory::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            $category->slug = $slug;
        }

        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();

        return response()->json([
            'success' => true,
            'message' => 'Kategori artikel berhasil diupdate',
        ]);
    }

    // Delete category
    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:article_categories,id',
        ]);

        $category = ArticleCategory::findOrFail($request->id);
        
        // Check if category has articles
        if ($category->articles()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak bisa dihapus karena masih memiliki artikel',
            ], 422);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori artikel berhasil dihapus',
        ]);
    }
}