@extends('guest')

@section('title', 'Semua Artikel')

@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb-wrapper">
    <div class="container">
        <div class="page-heading">
            <h1>Artikel</h1>
            <div class="page-header">
                <ul class="breadcrumb-items wow fadeInUp" data-wow-delay=".3s">
                    <li>
                        <a href="{{ url('/') }}">Home</a>
                    </li>
                    <li>
                        <i class="fa-solid fa-chevron-right"></i>
                    </li>
                    <li>Artikel</li>
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
                    <h4>Semua Artikel</h4>
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
                            Belum ada artikel tersedia.
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
                <!-- Categories -->
                @if($categories->count() > 0)
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Kategori</h5>
                        <ul class="list-unstyled">
                            @foreach($categories as $cat)
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

                <!-- Tags -->
                @if($tags->count() > 0)
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Tag Populer</h5>
                        <div>
                            @foreach($tags->take(15) as $tag)
<a href="{{ url('artikel/tag/' . $tag->slug) }}" 
   class="tag-badge-item">
    {{ $tag->name }} ({{ $tag->articles_count }})
</a>
@endforeach

<style>
.tag-badge-item {
    display: inline-block;
    background-color: #007bff;
    color: #ffffff;
    padding: 6px 12px;
    margin: 0 6px 6px 0;
    border-radius: 15px;
    font-size: 13px;
    text-decoration: none;
    cursor: pointer;
    pointer-events: auto;
    z-index: 100;
    position: relative;
}

.tag-badge-item:hover {
    background-color: #0056b3;
    color: #ffffff;
    text-decoration: none;
    transform: translateY(-2px);
}
</style>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Recent Articles -->
                @if(isset($recentArticles) && $recentArticles->count() > 0)
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Artikel Terbaru</h5>
                        @foreach($recentArticles as $recent)
                        <div class="mb-3 pb-3 border-bottom">
                            <h6>
                                <a href="{{ url('artikel/' . $recent->slug) }}">
                                    {{ Str::limit($recent->title, 50) }}
                                </a>
                            </h6>
                            <small class="text-muted">
                                <i class="fa-solid fa-calendar-days"></i>
                                {{ $recent->created_at->format('d M Y') }}
                            </small>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection