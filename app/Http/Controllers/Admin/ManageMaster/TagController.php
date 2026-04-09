<?php

namespace App\Http\Controllers\Admin\ManageMaster;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    // Tampilkan halaman index
    public function index()
    {
        return view('admin.manage-master.tag.index');
    }

    // Get all tags
    public function getall()
    {
        $tags = Tag::withCount('articles')
            ->orderBy('name', 'asc')
            ->get();
        
        return response()->json(['data' => $tags]);
    }

    // Get single tag
    public function get(Request $request)
    {
        $tag = Tag::findOrFail($request->id);
        return response()->json($tag);
    }

    // Create new tag
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        // Generate slug
        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $counter = 1;
        while (Tag::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        Tag::create([
            'name' => $request->name,
            'slug' => $slug,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tag berhasil ditambahkan',
        ]);
    }

    // Update tag
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:tags,id',
            'name' => 'required|string|max:100',
        ]);

        $tag = Tag::findOrFail($request->id);

        // Generate new slug if name changed
        if ($tag->name != $request->name) {
            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $counter = 1;
            while (Tag::where('slug', $slug)->where('id', '!=', $tag->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            $tag->slug = $slug;
        }

        $tag->name = $request->name;
        $tag->save();

        return response()->json([
            'success' => true,
            'message' => 'Tag berhasil diupdate',
        ]);
    }

    // Delete tag
    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:tags,id',
        ]);

        $tag = Tag::findOrFail($request->id);
        
        $tag->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tag berhasil dihapus',
        ]);
    }
}