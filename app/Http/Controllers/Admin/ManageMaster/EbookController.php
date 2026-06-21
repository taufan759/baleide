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
                if ($ebook->file) {
                    return '<a href="' . asset($ebook->file) . '" target="_blank" class="btn btn-info btn-sm">
                                <i class="fas fa-file-pdf"></i> Lihat File
                            </a>';
                }
                return '<span class="badge badge-warning">Belum Ada File</span>';
            })
            ->addColumn('price_display', function (Ebook $ebook) {
                return '<strong>Rp ' . number_format($ebook->price, 0, ',', '.') . '</strong>';
            })
            ->addColumn('action', function (Ebook $ebook) {
                return '
                <div class="d-flex gap-1">
                    <button type="button" class="btn btn-warning btn-sm edit" data-id="' . $ebook->id . '">
                        <i class="fas fa-edit"></i> Ubah
                    </button>
                    <button type="button" class="btn btn-danger btn-sm hapus" data-id="' . $ebook->id . '">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
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

    /**
     * Helper untuk hapus file di public path dengan aman
     * (kompatibel local dan shared hosting)
     */
    private function deletePublicFile(?string $relativePath): void
    {
        if (!$relativePath) return;
        $fullPath = public_path($relativePath);
        if (file_exists($fullPath) && is_file($fullPath)) {
            @unlink($fullPath);
        }
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
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $newFilePath = $ebook->file; // default: tetap pakai file lama
        if ($request->hasFile('file')) {
            $this->deletePublicFile($ebook->file);
            $file = $request->file('file');
            $filename = time() . '_file_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $destDir = public_path('assets/ebook_files');
            if (!file_exists($destDir)) {
                mkdir($destDir, 0755, true);
            }
            $file->move($destDir, $filename);
            $newFilePath = 'assets/ebook_files/' . $filename;
        }

        if ($ebook->title !== $request->title) {
            $slug = Str::slug($request->title);
            $count = Ebook::where('slug', 'LIKE', "$slug%")->where('id', '!=', $ebook->id)->count();
            $ebook->slug = $count > 0 ? $slug . '-' . ($count + 1) : $slug;
        }

        $ebook->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => $ebook->slug,
            'author' => $request->author,
            'isbn' => $request->isbn,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'total_pages' => $request->total_pages,
            'file_format' => $request->file_format,
            'file' => $newFilePath,
        ]);

        if ($request->filled('deleted_photos')) {
            $deletedIds = explode(',', $request->deleted_photos);
            $photos = EbookPhoto::whereIn('id', $deletedIds)->where('ebook_id', $ebook->id)->get();
            foreach ($photos as $photo) {
                $this->deletePublicFile($photo->photo);
                $photo->delete();
            }
        }

        if ($request->hasFile('photos')) {
            $destDir = public_path('assets/ebook');
            if (!file_exists($destDir)) {
                mkdir($destDir, 0755, true);
            }
            foreach ($request->file('photos') as $file) {
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $path = 'assets/ebook/' . $filename;
                $file->move($destDir, $filename);

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

        $this->deletePublicFile($ebook->file);

        foreach ($ebook->photos as $photo) {
            $this->deletePublicFile($photo->photo);
        }

        $ebook->delete();

        return response()->json(['message' => 'Ebook berhasil dihapus']);
    }
}