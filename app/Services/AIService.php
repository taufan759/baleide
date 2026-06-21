<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIService
{
    protected string $provider;
    protected string $apiKey;
    protected string $model;
    protected ?string $baseUrl;

    public function __construct(string $provider = null)
    {
        $this->provider = $provider ?? config('ai.default_provider', 'deepseek');
        
        if ($this->provider === 'deepseek') {
            $this->apiKey = config('ai.deepseek_api_key');
            $this->model = config('ai.deepseek_model');
            $this->baseUrl = config('ai.deepseek_base_url');
        } else {
            $this->apiKey = config('ai.openai_api_key');
            $this->model = config('ai.openai_model');
            $this->baseUrl = 'https://api.openai.com';
        }
    }

    /**
     * Generate AI chat response
     */
    public function chat(array $messages, array $options = []): ?string
    {
        try {
            $url = $this->baseUrl . '/v1/chat/completions';
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post($url, [
                'model' => $this->model,
                'messages' => $messages,
                'temperature' => $options['temperature'] ?? 0.7,
                'max_tokens' => $options['max_tokens'] ?? 500,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['choices'][0]['message']['content'] ?? null;
            }

            Log::error('AI API Error', [
                'provider' => $this->provider,
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('AI Service Exception', [
                'provider' => $this->provider,
                'message' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Recommend ebooks based on user mood/preference
     */
    public function recommendEbooks(string $userInput, array $availableEbooks): string
    {
        $ebookList = collect($availableEbooks)->map(function ($ebook) {
            return sprintf(
                "- ID: %d | Judul: %s | Penulis: %s | Kategori: %s | Deskripsi: %s",
                $ebook['id'],
                $ebook['title'],
                $ebook['author'],
                $ebook['category'],
                $ebook['description'] ?? 'Tidak ada deskripsi'
            );
        })->implode("\n");

        $systemPrompt = <<<PROMPT
Kamu adalah asisten AI bernama "Baleide Assistant" yang ahli dalam merekomendasikan e-book.
Tugasmu adalah membantu user menemukan e-book yang sesuai berdasarkan mood, preferensi, atau kebutuhan mereka.

Gaya komunikasi:
- Ramah, antusias, dan personal
- Gunakan Bahasa Indonesia yang santai tapi profesional
- Berikan alasan kenapa merekomendasikan buku tertentu
- Sebutkan ID dan judul buku yang direkomendasikan
- Maksimal rekomendasikan 3-5 buku per respons

Daftar e-book yang tersedia:
$ebookList

Jika user bertanya di luar topik buku, arahkan kembali dengan sopan ke topik rekomendasi e-book.
PROMPT;

        $messages = [
            ['role' => 'system', 'content' => $systemPrompt],
            ['role' => 'user', 'content' => $userInput]
        ];

        $response = $this->chat($messages, ['temperature' => 0.8, 'max_tokens' => 600]);

        return $response ?? 'Maaf, saya sedang kesulitan memberikan rekomendasi. Silakan coba lagi.';
    }
}
