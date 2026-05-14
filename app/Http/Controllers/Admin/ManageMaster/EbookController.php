<?php

namespace App\Http\Controllers\Admin\ManageMaster;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ebook; // Pastikan model sudah dibuat
use App\Models\EbookPhoto; // Pastikan model sudah dibuat
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class EbookController extends Controller
{
    public function index()
    {
        $categories = Category::select('id', 'name')->orderBy('name', 'ASC')->get();
        return view('admin.manage_master.ebook.index')->with([
            'sb' => 'Ebook',
            'categories' => $categories
        ]);
    }

    public function getall()
    {
        $query = Ebook::with(['category', 'photos'])->orderBy('id', 'desc')->get();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('category_name', function (Ebook $ebook) {
                return $ebook->category ? $ebook->category->name : '<span class="text-muted">No Category</span>';
            })
            ->addColumn('photos_preview', function (Ebook $ebook) {
                $firstPhoto = $ebook->photos->first();
                if ($firstPhoto) {
                    return '<img src="' . asset($firstPhoto->photo) . '" width="50" class="img-thumbnail">';
                }
                return '<span class="text-muted">No Photo</span>';
            })
            ->addColumn('file_preview', function (Ebook $ebook) {
                if ($ebook->file && file_exists(public_path($ebook->file))) {
                    return '<a href="' . asset($ebook->file) . '" target="_blank" class="btn btn-info btn-sm">
                                <i class="fas fa-file-pdf"></i> Lihat File
                            </a>';
                }
                return '<span class="badge badge-warning">File Missing</span>';
            })
            ->addColumn('price_display', function (Ebook $ebook) {
                return '<strong>Rp ' . number_format($ebook->price, 0, ',', '.') . '</strong>';
            })
            ->addColumn('action', function (Ebook $ebook) {
                return '
                <div class="dropdown d-inline dropleft">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
                        Aksi
                    </button>
                    <ul class="dropdown-menu">
                        <li><a data-id="' . $ebook->id . '" class="dropdown-item edit" style="cursor:pointer">Edit</a></li>
                        <li><a data-id="' . $ebook->id . '" class="dropdown-item hapus text-danger" style="cursor:pointer">Hapus</a></li>
                    </ul>
                </div>';
            })
            ->rawColumns(['category_name', 'photos_preview', 'file_preview', 'price_display', 'action'])
            ->make(true);
    }

    public function get(Request $request)
    {
        $ebook = Ebook::with('photos')->findOrFail($request->id);
        return response()->json($ebook);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'author' => 'required|string|max:100',
            'isbn' => 'nullable|string|max:20|unique:ebooks,isbn',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'total_pages' => 'nullable|integer',
            'file_format' => 'required|string',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,epub,mobi|max:20480',
            'photos.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        $slug = Str::slug($request->title);
        $count = Ebook::where('slug', 'LIKE', "$slug%")->count();
        $finalSlug = $count > 0 ? $slug . '-' . ($count + 1) : $slug;

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_file_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            // Pastikan folder ada
            if (!file_exists(public_path('assets/ebook_files'))) {
                mkdir(public_path('assets/ebook_files'), 0755, true);
            }
            $file->move(public_path('assets/ebook_files'), $filename);
            $filePath = 'assets/ebook_files/' . $filename;
        }

        $ebook = Ebook::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => $finalSlug,
            'author' => $request->author,
            'isbn' => $request->isbn,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'total_pages' => $request->total_pages,
            'file_format' => $request->file_format,
            'file' => $filePath,
        ]);

        if ($request->hasFile('photos')) {
            // Pastikan folder ada
            if (!file_exists(public_path('assets/ebook'))) {
                mkdir(public_path('assets/ebook'), 0755, true);
            }
            foreach ($request->file('photos') as $file) {
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $path = 'assets/ebook/' . $filename;
                $file->move(public_path('assets/ebook'), $filename);

                EbookPhoto::create([
                    'ebook_id' => $ebook->id,
                    'photo' => $path,
                ]);
            }
        }

        return response()->json(['message' => 'Ebook berhasil ditambahkan'], 200);
    }

    public function update(Request $request)
    {
        $ebook = Ebook::findOrFail($request->id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'author' => 'required|string|max:100',
            'isbn' => 'nullable|string|max:20|unique:ebooks,isbn,' . $ebook->id,
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'total_pages' => 'nullable|integer',
            'file_format' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,epub,mobi|max:20480', 
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal.',
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->hasFile('file')) {
            if ($ebook->file && file_exists(public_path($ebook->file))) {
                unlink(public_path($ebook->file));
            }
            
            $file = $request->file('file');
            $filename = time() . '_file_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/ebook_files'), $filename);
            $ebook->file = 'assets/ebook_files/' . $filename;
        }

        if ($ebook->title !== $request->title) {
            $slug = Str::slug($request->title);
            $count = Ebook::where('slug', 'LIKE', "$slug%")->where('id', '!=', $ebook->id)->count();
            $ebook->slug = $count > 0 ? $slug . '-' . ($count + 1) : $slug;
        }

        $ebook->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'author' => $request->author,
            'isbn' => $request->isbn,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'total_pages' => $request->total_pages,
            'file_format' => $request->file_format,
            'file' => $ebook->file,
        ]);

        if ($request->filled('deleted_photos')) {
            $deletedIds = explode(',', $request->deleted_photos);
            $photos = EbookPhoto::whereIn('id', $deletedIds)->where('ebook_id', $ebook->id)->get();
            foreach ($photos as $photo) {
                if (file_exists(public_path($photo->photo))) {
                    unlink(public_path($photo->photo));
                }
                $photo->delete();
            }
        }

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $path = 'assets/ebook/' . $filename;
                $file->move(public_path('assets/ebook'), $filename);

                EbookPhoto::create([
                    'ebook_id' => $ebook->id,
                    'photo' => $path,
                ]);
            }
        }

        return response()->json(['message' => 'Ebook berhasil diperbarui'], 200);
    }

    public function delete(Request $request)
    {
        $ebook = Ebook::with('photos')->findOrFail($request->id);

        if ($ebook->file && file_exists(public_path($ebook->file))) {
            unlink(public_path($ebook->file));
        }

        foreach ($ebook->photos as $photo) {
            if (file_exists(public_path($photo->photo))) {
                unlink(public_path($photo->photo));
            }
        }

        $ebook->delete();

        return response()->json(['message' => 'Ebook berhasil dihapus']);
    }
}