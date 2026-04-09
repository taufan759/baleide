@extends('guest')

@section('title', $article->title)

@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb-wrapper">
    <div class="container">
        <div class="page-heading">
            <h1>{{ Str::limit($article->title, 60) }}</h1>
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
                    <li>{{ Str::limit($article->title, 30) }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Article Detail Section -->
<section class="news-details-section section-padding">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="news-details-wrapper">
                    <!-- Thumbnail -->
                    @if($article->thumbnail)
                    <div class="news-details-image mb-4">
                        <img src="{{ asset($article->thumbnail) }}" 
                             alt="{{ $article->title }}" 
                             class="w-100" 
                             style="border-radius: 10px; max-height: 500px; object-fit: cover;">
                    </div>
                    @endif

                    <!-- Meta Info -->
                    <ul class="post-meta mb-3">
                        <li>
                            <i class="fa-solid fa-user"></i>
                            {{ $article->author }}
                        </li>
                        <li>
                            <i class="fa-solid fa-calendar-days"></i>
                            {{ $article->created_at->format('d F Y') }}
                        </li>
                        <li>
                            <i class="fa-solid fa-clock"></i>
                            {{ $article->created_at->diffForHumans() }}
                        </li>
                    </ul>

                    <!-- Categories -->
                    @if($article->categories->count() > 0)
                    <div class="mb-3">
                        <strong>Kategori:</strong>
                        @foreach($article->categories as $cat)
                        <a href="{{ url('artikel/kategori/' . $cat->slug) }}" 
                           class="badge badge-primary mr-1">
                            {{ $cat->name }}
                        </a>
                        @endforeach
                    </div>
                    @endif

                    <!-- Title -->
                    <h2 class="mb-4">{{ $article->title }}</h2>

                    <!-- Excerpt -->
                    @if($article->excerpt)
                    <div class="alert alert-light mb-4">
                        <p class="mb-0"><em>{{ $article->excerpt }}</em></p>
                    </div>
                    @endif

                    <!-- Content -->
                    <div class="news-content">
                        {!! $article->content !!}
                    </div>

                    <!-- Tags -->
                    @if($article->tags->count() > 0)
                    <div class="mt-4 pt-4 border-top">
                        <strong>Tags:</strong>
                        <div class="mt-2">
                            @foreach($article->tags as $tag)
                            <a href="{{ url('artikel/tag/' . $tag->slug) }}" 
                               class="badge badge-light mr-2 mb-2" 
                               style="font-size: 14px; padding: 8px 15px;">
                                #{{ $tag->name }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Share Buttons -->
                    <div class="mt-4 pt-4 border-top">
                        <strong>Bagikan Artikel:</strong>
                        <div class="mt-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                               target="_blank" 
                               class="btn btn-sm btn-primary mr-2">
                                <i class="fab fa-facebook-f"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->title) }}" 
                               target="_blank" 
                               class="btn btn-sm btn-info mr-2">
                                <i class="fab fa-twitter"></i> Twitter
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . url()->current()) }}" 
                               target="_blank" 
                               class="btn btn-sm btn-success">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Related Articles -->
                @if($relatedArticles->count() > 0)
                <div class="mt-5">
                    <h4 class="mb-4">Artikel Terkait</h4>
                    <div class="row">
                        @foreach($relatedArticles as $related)
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                @if($related->thumbnail)
                                <img src="{{ asset($related->thumbnail) }}" 
                                     class="card-img-top" 
                                     alt="{{ $related->title }}"
                                     style="height: 200px; object-fit: cover;">
                                @endif
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <a href="{{ url('artikel/' . $related->slug) }}">
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
                <!-- Back to Articles -->
                <div class="card mb-4">
                    <div class="card-body">
                        <a href="{{ url('/artikel') }}" class="btn btn-secondary btn-block">
                            <i class="fas fa-arrow-left"></i> Kembali ke Artikel
                        </a>
                    </div>
                </div>

                <!-- Author Info -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Tentang Penulis</h5>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('assets/img/avatar.png') }}" 
                                 alt="{{ $article->author }}" 
                                 class="rounded-circle mr-3" 
                                 style="width: 60px; height: 60px;">
                            <div>
                                <h6 class="mb-0">{{ $article->author }}</h6>
                                <small class="text-muted">Penulis</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Categories -->
                @if($categories->count() > 0)
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Kategori</h5>
                        <ul class="list-unstyled">
                            @foreach($categories->take(8) as $cat)
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
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Tag Populer</h5>
                        <div>
                            @foreach($tags->take(15) as $tag)
                            <a href="{{ url('artikel/tag/' . $tag->slug) }}" 
                               class="badge badge-light mb-2 mr-1" 
                               style="font-size: 13px; padding: 8px 12px;">
                                {{ $tag->name }} ({{ $tag->articles_count }})
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<style>
.news-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 20px 0;
}

.news-content h1,
.news-content h2,
.news-content h3,
.news-content h4 {
    margin-top: 30px;
    margin-bottom: 15px;
}

.news-content p {
    margin-bottom: 15px;
    line-height: 1.8;
}

.news-content ul,
.news-content ol {
    margin-bottom: 20px;
    padding-left: 30px;
}

.news-content blockquote {
    border-left: 4px solid #036280;
    padding-left: 20px;
    margin: 20px 0;
    font-style: italic;
    color: #666;
}
</style>
@endsection