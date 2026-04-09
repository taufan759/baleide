<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Tag;
use Illuminate\Http\Request;

class ArticleGuestController extends Controller
{
    /**
     * Menampilkan semua artikel (halaman index)
     */
    public function allArticles(Request $request)
    {
        $articles = Article::with(['categories', 'tags'])
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        $categories = ArticleCategory::withCount('articles')
            ->orderBy('name', 'asc')
            ->get();

        $tags = Tag::withCount('articles')
            ->orderBy('name', 'asc')
            ->get();

        // Artikel terbaru untuk sidebar
        $recentArticles = Article::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('guest.article.index', compact(
            'articles',
            'categories',
            'tags',
            'recentArticles'
        ));
    }

    /**
     * Menampilkan detail artikel
     */
    public function showArticle($slug)
    {
        $article = Article::with(['categories', 'tags'])
            ->where('slug', $slug)
            ->firstOrFail();

        $categories = ArticleCategory::withCount('articles')
            ->orderBy('name', 'asc')
            ->get();

        $tags = Tag::withCount('articles')
            ->orderBy('name', 'asc')
            ->get();

        // Artikel terkait berdasarkan kategori yang sama
        $relatedArticles = Article::whereHas('categories', function($query) use ($article) {
                $query->whereIn('article_categories.id', $article->categories->pluck('id'));
            })
            ->where('id', '!=', $article->id)
            ->limit(3)
            ->get();

        return view('guest.article.show', compact(
            'article',
            'categories',
            'tags',
            'relatedArticles'
        ));
    }

    /**
     * Menampilkan artikel berdasarkan kategori
     */
    public function showArticleCategory($slug)
    {
        $category = ArticleCategory::where('slug', $slug)->firstOrFail();

        // Ambil artikel yang memiliki kategori ini
        $articles = Article::whereHas('categories', function($query) use ($category) {
                $query->where('article_categories.id', $category->id);
            })
            ->with(['categories', 'tags'])
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        $categories = ArticleCategory::withCount('articles')
            ->orderBy('name', 'asc')
            ->get();

        $tags = Tag::withCount('articles')
            ->orderBy('name', 'asc')
            ->get();

        return view('guest.article.category', compact(
            'category',
            'articles',
            'categories',
            'tags'
        ));
    }

    /**
     * Menampilkan artikel berdasarkan tag
     */
    public function showArticleTag($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();

        // Ambil artikel yang memiliki tag ini
        $articles = Article::whereHas('tags', function($query) use ($tag) {
                $query->where('tags.id', $tag->id);
            })
            ->with(['categories', 'tags'])
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        $categories = ArticleCategory::withCount('articles')
            ->orderBy('name', 'asc')
            ->get();

        $allTags = Tag::withCount('articles')
            ->orderBy('name', 'asc')
            ->get();

        return view('guest.article.tag', compact(
            'tag',
            'articles',
            'categories',
            'allTags'
        ));
    }
}