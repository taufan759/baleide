<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Tag;
use Illuminate\Http\Request;

class ArticleGuestController extends Controller
{
    // Halaman daftar semua artikel
    public function allArticles(Request $request)
    {
        $query = Article::with(['categories', 'tags'])
            ->orderBy('created_at', 'desc');

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        $articles = $query->paginate(12);
        $categories = ArticleCategory::withCount('articles')->get();
        $tags = Tag::withCount('articles')->get();

        return view('guest.article.index', compact('articles', 'categories', 'tags'));
    }

    // Halaman detail artikel
    public function showArticle($slug)
    {
        $article = Article::with(['categories', 'tags'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Artikel terkait dari kategori yang sama
        $relatedArticles = Article::with(['categories', 'tags'])
            ->whereHas('categories', function($query) use ($article) {
                $query->whereIn('article_categories.id', $article->categories->pluck('id'));
            })
            ->where('id', '!=', $article->id)
            ->limit(3)
            ->get();

        return view('guest.article.show', compact('article', 'relatedArticles'));
    }

    // Halaman artikel berdasarkan kategori
    public function showArticleCategory($slug)
    {
        $category = ArticleCategory::where('slug', $slug)->firstOrFail();
        
        $articles = Article::with(['categories', 'tags'])
            ->whereHas('categories', function($query) use ($category) {
                $query->where('article_categories.id', $category->id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $allCategories = ArticleCategory::withCount('articles')->get();
        $tags = Tag::withCount('articles')->get();

        return view('guest.article.category', compact('category', 'articles', 'allCategories', 'tags'));
    }

    // Halaman artikel berdasarkan tag
    public function showArticleTag($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        
        $articles = Article::with(['categories', 'tags'])
            ->whereHas('tags', function($query) use ($tag) {
                $query->where('tags.id', $tag->id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $categories = ArticleCategory::withCount('articles')->get();
        $allTags = Tag::withCount('articles')->get();

        return view('guest.article.tag', compact('tag', 'articles', 'categories', 'allTags'));
    }
}