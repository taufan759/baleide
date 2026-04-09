@extends('layouts.guest')

@section('title', $article->title)

@section('content')
<div class="container my-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('article.index') }}">Artikel</a></li>
            <li class="breadcrumb-item active">{{ Str::limit($article->title, 30) }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Article Content -->
        <div class="col-lg-8">
            <article class="card shadow">
                @if($article->thumbnail)
                <img src="{{ asset('storage/' . $article->thumbnail) }}" 
                     class="card-img-top" alt="{{ $article->title }}"
                     style="max-height: 400px; object-fit: cover;">
                @endif
                
                <div class="card-body">
                    <!-- Title -->
                    <h1 class="card-title mb-3">{{ $article->title }}</h1>
                    
                    <!-- Meta Info -->
                    <div class="d-flex align-items-center text-muted mb-4 pb-3 border-bottom">
                        <i class="fas fa-user me-2"></i>
                        <span class="me-4">{{ $article->author }}</span>
                        <i class="fas fa-calendar me-2"></i>
                        <span>{{ $article->created_at->format('d F Y') }}</span>
                    </div>
                    
                    <!-- Categories & Tags -->
                    <div class="mb-4">
                        @foreach($article->categories as $cat)
                        <a href="{{ route('article.category', $cat->slug) }}" 
                           class="badge bg-info text-decoration-none me-1">
                            {{ $cat->name }}
                        </a>
                        @endforeach
                        
                        @foreach($article->tags as $tag)
                        <a href="{{ route('article.tag', $tag->slug) }}" 
                           class="badge bg-secondary text-decoration-none me-1">
                            #{{ $tag->name }}
                        </a>
                        @endforeach
                    </div>
                    
                    <!-- Content -->
                    <div class="article-content">
                        {!! $article->content !!}
                    </div>
                </div>
            </article>

            <!-- Related Articles -->
            @if($relatedArticles->count() > 0)
            <div class="mt-5">
                <h3 class="mb-4">Artikel Terkait</h3>
                <div class="row">
                    @foreach($relatedArticles as $related)
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            @if($related->thumbnail)
                            <img src="{{ asset('storage/' . $related->thumbnail) }}" 
                                 class="card-img-top" alt="{{ $related->title }}"
                                 style="height: 150px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <h6 class="card-title">
                                    <a href="{{ route('article.show', $related->slug) }}" 
                                       class="text-decoration-none">
                                        {{ Str::limit($related->title, 50) }}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    {{ $related->created_at->format('d M Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Share Buttons -->
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Bagikan Artikel</h5>
                    <div class="d-flex gap-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" 
                           target="_blank" class="btn btn-primary btn-sm">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $article->title }}" 
                           target="_blank" class="btn btn-info btn-sm text-white">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://wa.me/?text={{ $article->title }} {{ url()->current() }}" 
                           target="_blank" class="btn btn-success btn-sm">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Categories Widget -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Kategori</h5>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($article->categories as $cat)
                    <a href="{{ route('article.category', $cat->slug) }}" 
                       class="list-group-item list-group-item-action">
                        {{ $cat->name }}
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- CTA Widget -->
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h5 class="card-title">Suka dengan artikelnya?</h5>
                    <p class="card-text">Jelajahi koleksi e-book kami!</p>
                    <a href="{{ route('allBooks') }}" class="btn btn-light">
                        Lihat E-Book <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.article-content {
    font-size: 1.1rem;
    line-height: 1.8;
}
.article-content img {
    max-width: 100%;
    height: auto;
    margin: 20px 0;
}
.article-content h2, .article-content h3 {
    margin-top: 30px;
    margin-bottom: 15px;
}
.article-content p {
    margin-bottom: 15px;
}
</style>
@endsection