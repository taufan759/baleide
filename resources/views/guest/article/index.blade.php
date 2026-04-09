@extends('layouts.guest')

@section('title', 'Artikel')

@section('content')
<div class="container my-5">
    <!-- Header -->
    <div class="text-center mb-5">
        <h1 class="display-4">Artikel</h1>
        <p class="text-muted">Baca artikel menarik seputar e-book dan literasi</p>
    </div>

    <!-- Search Bar -->
    <div class="row mb-4">
        <div class="col-md-8 mx-auto">
            <form action="{{ route('article.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" 
                           placeholder="Cari artikel..." value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Kategori</h5>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($categories as $cat)
                    <a href="{{ route('article.category', $cat->slug) }}" 
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        {{ $cat->name }}
                        <span class="badge bg-primary rounded-pill">{{ $cat->articles_count }}</span>
                    </a>
                    @endforeach
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Tags</h5>
                </div>
                <div class="card-body">
                    @foreach($tags as $tag)
                    <a href="{{ route('article.tag', $tag->slug) }}" class="badge bg-secondary m-1">
                        {{ $tag->name }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Articles List -->
        <div class="col-lg-9">
            @if($articles->count() > 0)
                <div class="row">
                    @foreach($articles as $article)
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            @if($article->thumbnail)
                            <img src="{{ asset('storage/' . $article->thumbnail) }}" 
                                 class="card-img-top" alt="{{ $article->title }}" 
                                 style="height: 200px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('article.show', $article->slug) }}" 
                                       class="text-decoration-none text-dark">
                                        {{ $article->title }}
                                    </a>
                                </h5>
                                
                                <div class="mb-2">
                                    @foreach($article->categories as $cat)
                                    <span class="badge bg-info">{{ $cat->name }}</span>
                                    @endforeach
                                </div>
                                
                                <p class="card-text text-muted small">
                                    {{ Str::limit($article->excerpt ?? strip_tags($article->content), 120) }}
                                </p>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-user"></i> {{ $article->author }}
                                    </small>
                                    <small class="text-muted">
                                        {{ $article->created_at->format('d M Y') }}
                                    </small>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <a href="{{ route('article.show', $article->slug) }}" 
                                   class="btn btn-sm btn-outline-primary w-100">
                                    Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $articles->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Tidak ada artikel yang ditemukan.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection