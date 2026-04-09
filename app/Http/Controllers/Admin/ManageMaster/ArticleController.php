<?php

namespace App\Http\Controllers\Admin\ManageMaster;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    // Tampilkan halaman index
    public function index()
    {
        return view('admin.manage-master.article.index');
    }

    // Get all articles (untuk DataTables)
    public function getall()
    {
        $articles = Article::with(['categories', 'tags'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json(['data' => $articles]);
    }

    // Get single article
    public function get(Request $request)
    {
        $article = Article::with(['categories', 'tags'])->findOrFail($request->id);
        
        return response()->json([
            'article' => $article,
            'category_ids' => $article->categories->pluck('id'),
            'tag_ids' => $article->tags->pluck('id'),
        ]);
    }

    // Create new article
    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'author' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'categories' => 'required|array',
            'tags' => 'nullable|array',
        ]);

        // Generate slug
        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $counter = 1;
        while (Article::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Upload thumbnail
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('articles/thumbnails', 'public');
        }

        // Create article
        $article = Article::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'content_format' => $request->content_format ?? 'wordpress',
            'thumbnail' => $thumbnailPath,
            'author' => $request->author,
            'excerpt' => $request->excerpt,
            'post_type' => $request->post_type ?? 'post',
        ]);

        // Attach categories
        if ($request->categories) {
            $article->categories()->attach($request->categories);
        }

        // Attach tags
        if ($request->tags) {
            $article->tags()->attach($request->tags);
        }

        return response()->json([
            'success' => true,
            'message' => 'Artikel berhasil ditambahkan',
        ]);
    }

    // Update article
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:articles,id',
            'title' => 'required|string|max:255',
            'content' => 'required',
            'author' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'categories' => 'required|array',
            'tags' => 'nullable|array',
        ]);

        $article = Article::findOrFail($request->id);

        // Generate new slug if title changed
        if ($article->title != $request->title) {
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $counter = 1;
            while (Article::where('slug', $slug)->where('id', '!=', $article->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            $article->slug = $slug;
        }

        // Update thumbnail if new file uploaded
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($article->thumbnail && Storage::disk('public')->exists($article->thumbnail)) {
                Storage::disk('public')->delete($article->thumbnail);
            }
            $article->thumbnail = $request->file('thumbnail')->store('articles/thumbnails', 'public');
        }

        // Update article
        $article->title = $request->title;
        $article->content = $request->content;
        $article->content_format = $request->content_format ?? 'wordpress';
        $article->author = $request->author;
        $article->excerpt = $request->excerpt;
        $article->post_type = $request->post_type ?? 'post';
        $article->save();

        // Sync categories
        $article->categories()->sync($request->categories);

        // Sync tags
        $article->tags()->sync($request->tags ?? []);

        return response()->json([
            'success' => true,
            'message' => 'Artikel berhasil diupdate',
        ]);
    }

    // Delete article
    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:articles,id',
        ]);

        $article = Article::findOrFail($request->id);

        // Delete thumbnail
        if ($article->thumbnail && Storage::disk('public')->exists($article->thumbnail)) {
            Storage::disk('public')->delete($article->thumbnail);
        }

        $article->delete();

        return response()->json([
            'success' => true,
            'message' => 'Artikel berhasil dihapus',
        ]);
    }
}