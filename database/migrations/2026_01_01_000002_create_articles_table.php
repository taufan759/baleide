<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('slug', 255)->unique()->index();
            $table->text('content');
            $table->string('content_format', 255)->nullable()->default('wordpress');
            $table->string('thumbnail', 255)->nullable();
            $table->string('author', 255);
            $table->text('excerpt')->nullable();
            $table->string('post_type', 255)->default('post');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};