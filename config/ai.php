<?php

return [
    /*
    |--------------------------------------------------------------------------
    | AI Provider Configuration
    |--------------------------------------------------------------------------
    |
    | Konfigurasi untuk AI provider (OpenAI, DeepSeek, dll)
    |
    */

    'default_provider' => env('AI_DEFAULT_PROVIDER', 'deepseek'),
    'premium_provider' => env('AI_PREMIUM_PROVIDER', 'openai'),

    // OpenAI Configuration
    'openai_api_key' => env('OPENAI_API_KEY'),
    'openai_model' => env('OPENAI_MODEL', 'gpt-4o-mini'),

    // DeepSeek Configuration
    'deepseek_api_key' => env('DEEPSEEK_API_KEY'),
    'deepseek_model' => env('DEEPSEEK_MODEL', 'deepseek-chat'),
    'deepseek_base_url' => env('DEEPSEEK_BASE_URL', 'https://api.deepseek.com'),
];
