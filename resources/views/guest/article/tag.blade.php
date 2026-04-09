@extends('guest')

@section('title', 'Tag: ' . $tag->name)

@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb-wrapper">
    <div class="container">
        <div class="page-heading">
            <h1>Tag: {{ $tag->name }}</h1>
            <div class="page-header">
                <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".3s">
                    <li>
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li>
                        <i class="fa-solid fa-chevron-right"></i>
                    </li>
                    <li>
                        <a href="{{ url('/artikel') }}">Artikel</a>
                    </li>
                    <li>
                        <i class="fa-solid fa-chevron-right"></i>
                    </li>
                    <li>Tag: {{ $tag->name }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Articles Section -->
<section class="news-section section-padding">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="mb-4">
                    <h4>Artikel dengan tag: <strong>#{{ $tag->name }}</strong></h4>
                    <p class="text-muted">Ditemukan {{ $articles->total() }} artikel</p>
                </div>

                <div class="row">
                    @forelse($articles as $article)
                    <div class="col-md-6 mb-4">
                        <div class="news-card-items">
                            <div class="news-image">
                                <a href="{{ url('artikel/' . $article->slug) }}">
                                    @if($article->thumbnail)
                                    <img src="{{ asset($article->thumbnail) }}" 
                                         alt="{{ $article->title }}" 
                                         style="height: 250px; object-fit: cover; width: 100%;">
                                    @else
                                    <img src="{{ asset('assets/img/default-article.png') }}" 
                                         alt="{{ $article->title }}" 
                                         style="height: 250px; object-fit: cover; width: 100%;">
                                    @endif
                                </a>
                            </div>
                            <div class="news-content">
                                <ul class="post-meta">
                                    <li>
                                        <i class="fa-solid fa-user"></i>
                                        {{ $article->author }}
                                    </li>
                                    <li>
                                        <i class="fa-solid fa-calendar-days"></i>
                                        {{ $article->created_at->format('d M Y') }}
                                    </li>
                                </ul>
                                
                                @if($article->categories->count() > 0)
                                <div class="mb-2">
                                    @foreach($article->categories as $cat)
                                    <a href="{{ url('artikel/kategori/' . $cat->slug) }}" 
                                       class="badge badge-primary mr-1">
                                        {{ $cat->name }}
                                    </a>
                                    @endforeach
                                </div>
                                @endif

                                <h3>
                                    <a href="{{ url('artikel/' . $article->slug) }}">
                                        {{ Str::limit($article->title, 60) }}
                                    </a>
                                </h3>
                                <p>
                                    {{ Str::limit($article->excerpt ?? strip_tags($article->content), 120) }}
                                </p>
                                
                                @if($article->tags->count() > 0)
                                <div class="mb-2">
                                    @foreach($article->tags->take(3) as $t)
                                    <a href="{{ url('artikel/tag/' . $t->slug) }}" 
                                       class="badge badge-light mr-1" 
                                       style="font-size: 11px;">
                                        #{{ $t->name }}
                                    </a>
                                    @endforeach
                                </div>
                                @endif
                                
                                <a href="{{ url('artikel/' . $article->slug) }}" class="link-btn">
                                    Baca Selengkapnya <i class="fa-solid fa-arrow-right-long"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-circle"></i> 
                            Belum ada artikel dengan tag ini.
                        </div>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($articles->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $articles->links() }}
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Back Button -->
                <div class="card mb-4">
                    <div class="card-body">
                        <a href="{{ url('/artikel') }}" class="btn btn-secondary btn-block">
                            <i class="fas fa-arrow-left"></i> Semua Artikel
                        </a>
                    </div>
                </div>

                <!-- Categories -->
                @if($categories->count() > 0)
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Kategori</h5>
                        <ul class="list-unstyled">
                            @foreach($categories->take(10) as $cat)
                            <li class="mb-2">
                                <a href="{{ url('artikel/kategori/' . $cat->slug) }}" 
                                   class="d-flex justify-content-between">
                                    <span>{{ $cat->name }}</span>
                                    <span class="badge badge-secondary">{{ $cat->articles_count }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif

                <!-- Other Tags -->
                @if($allTags->count() > 1)
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Tag Lainnya</h5>
                        <div>
                            @foreach($allTags as $t)
                                @if($t->id != $tag->id)
                                <a href="{{ url('artikel/tag/' . $t->slug) }}" 
                                   class="badge badge-light mb-2 mr-1" 
                                   style="font-size: 13px; padding: 8px 12px;">
                                    {{ $t->name }} ({{ $t->articles_count }})
                                </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection