<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AIService;
use App\Models\Ebook;

class ChatbotController extends Controller
{
    protected AIService $aiService;

    public function __construct()
    {
        $this->aiService = new AIService();
    }

    /**
     * Tampilkan halaman chatbot
     */
    public function index()
    {
        return view('chatbot.index')->with('sb', 'Chatbot');
    }

    /**
     * Proses chat request
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500'
        ]);

        $userMessage = $request->input('message');

        // Ambil semua ebook untuk konteks AI
        $ebooks = Ebook::with('category')
            ->where('stock', '>', 0)
            ->get()
            ->map(function ($ebook) {
                return [
                    'id' => $ebook->id,
                    'title' => $ebook->title,
                    'author' => $ebook->author,
                    'category' => $ebook->category->name ?? 'Umum',
                    'description' => $ebook->description,
                    'slug' => $ebook->slug,
                ];
            })
            ->toArray();

        // Generate AI response
        $aiResponse = $this->aiService->recommendEbooks($userMessage, $ebooks);

        // Parse book IDs dari response (cari pattern "ID: \d+")
        preg_match_all('/ID:\s*(\d+)/i', $aiResponse, $matches);
        $recommendedIds = $matches[1] ?? [];

        // Ambil detail buku yang direkomendasikan
        $recommendedBooks = [];
        if (!empty($recommendedIds)) {
            $recommendedBooks = Ebook::with('photos', 'category')
                ->whereIn('id', $recommendedIds)
                ->get()
                ->map(function ($book) {
                    $cover = $book->photos->first();
                    return [
                        'id' => $book->id,
                        'title' => $book->title,
                        'author' => $book->author,
                        'category' => $book->category->name ?? 'Umum',
                        'price' => $book->price,
                        'price_formatted' => 'Rp ' . number_format($book->price, 0, ',', '.'),
                        'slug' => $book->slug,
                        'cover' => $cover ? asset($cover->photo) : asset('assets/img/default-ebook.png'),
                        'url' => url('/ebook/' . $book->slug),
                    ];
                });
        }

        return response()->json([
            'success' => true,
            'message' => $aiResponse,
            'recommended_books' => $recommendedBooks,
            'timestamp' => now()->toIso8601String(),
        ]);
    }
}
