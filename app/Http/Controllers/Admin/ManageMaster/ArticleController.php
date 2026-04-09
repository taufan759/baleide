<?php

namespace App\Http\Controllers\Admin\ManageMaster;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Tag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ArticleController extends Controller
{
    public function index()
    {
        $categories = ArticleCategory::select('id', 'name')->orderBy('name', 'ASC')->get();
        $tags = Tag::select('id', 'name')->orderBy('name', 'ASC')->get();
        
        return view('admin.manage_master.article.index')->with([
            'sb' => 'Article',
            'categories' => $categories,
            'tags' => $tags
        ]);
    }

    public function getall()
    {
        $query = Article::with(['categories', 'tags'])->orderBy('id', 'desc')->get();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('thumbnail_preview', function (Article $article) {
                if ($article->thumbnail && file_exists(public_path($article->thumbnail))) {
                    return '<img src="' . asset($article->thumbnail) . '" width="50" class="img-thumbnail">';
                }
                return '<span class="text-muted">No Image</span>';
            })
            ->addColumn('categories_display', function (Article $article) {
                if ($article->categories->count() > 0) {
                    return $article->categories->map(function($cat) {
                        return '<span class="badge badge-info">' . $cat->name . '</span>';
                    })->implode(' ');
                }
                return '<span class="text-muted">-</span>';
            })
            ->addColumn('tags_display', function (Article $article) {
                if ($article->tags->count() > 0) {
                    return $article->tags->map(function($tag) {
                        return '<span class="badge badge-secondary">' . $tag->name . '</span>';
                    })->implode(' ');
                }
                return '<span class="text-muted">-</span>';
            })
            ->addColumn('excerpt_short', function (Article $article) {
                return Str::limit($article->excerpt ?? strip_tags($article->content), 60);
            })
            ->addColumn('action', function (Article $article) {
                return '
                <div class="dropdown d-inline dropleft">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                        Aksi
                    </button>
                    <ul class="dropdown-menu">
                        <li><a data-id="' . $article->id . '" class="dropdown-item edit" style="cursor:pointer">Edit</a></li>
                        <li><a data-id="' . $article->id . '" class="dropdown-item hapus text-danger" style="cursor:pointer">Hapus</a></li>
                    </ul>
                </div>';
            })
            ->rawColumns(['thumbnail_preview', 'categories_display', 'tags_display', 'action'])
            ->make(true);
    }

    public function get(Request $request)
    {
        $article = Article::with(['categories', 'tags'])->findOrFail($request->id);
        
        return response()->json([
            'article' => $article,
            'category_ids' => $article->categories->pluck('id')->toArray(),
            'tag_ids' => $article->tags->pluck('id')->toArray(),
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required',
            'author' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:article_categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Generate slug
        $slug = Str::slug($request->title);
        $count = Article::where('slug', 'LIKE', "$slug%")->count();
        $finalSlug = $count > 0 ? $slug . '-' . ($count + 1) : $slug;

        // Upload thumbnail
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/articles/thumbnails'), $filename);
            $thumbnailPath = 'assets/articles/thumbnails/' . $filename;
        }

        // Create article
        $article = Article::create([
            'title' => $request->title,
            'slug' => $finalSlug,
            'content' => $request->content,
            'content_format' => $request->content_format ?? 'html',
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

        return response()->json(['message' => 'Artikel berhasil ditambahkan'], 200);
    }

    public function update(Request $request)
    {
        $article = Article::findOrFail($request->id);

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:articles,id',
            'title' => 'required|string|max:255',
            'content' => 'required',
            'author' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:article_categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Update thumbnail if new file uploaded
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($article->thumbnail && file_exists(public_path($article->thumbnail))) {
                unlink(public_path($article->thumbnail));
            }
            
            $file = $request->file('thumbnail');
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/articles/thumbnails'), $filename);
            $article->thumbnail = 'assets/articles/thumbnails/' . $filename;
        }

        // Generate new slug if title changed
        if ($article->title !== $request->title) {
            $slug = Str::slug($request->title);
            $count = Article::where('slug', 'LIKE', "$slug%")->where('id', '!=', $article->id)->count();
            $article->slug = $count > 0 ? $slug . '-' . ($count + 1) : $slug;
        }

        // Update article
        $article->update([
            'title' => $request->title,
            'content' => $request->content,
            'content_format' => $request->content_format ?? 'html',
            'thumbnail' => $article->thumbnail,
            'author' => $request->author,
            'excerpt' => $request->excerpt,
            'post_type' => $request->post_type ?? 'post',
        ]);

        // Sync categories
        $article->categories()->sync($request->categories);

        // Sync tags
        $article->tags()->sync($request->tags ?? []);

        return response()->json(['message' => 'Artikel berhasil diperbarui'], 200);
    }

    public function delete(Request $request)
    {
        $article = Article::findOrFail($request->id);

        // Delete thumbnail
        if ($article->thumbnail && file_exists(public_path($article->thumbnail))) {
            unlink(public_path($article->thumbnail));
        }

        $article->delete();

        return response()->json(['message' => 'Artikel berhasil dihapus']);
    }
}