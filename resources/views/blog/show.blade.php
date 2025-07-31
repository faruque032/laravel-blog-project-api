@extends('layouts.app')

@section('title', $post->meta_title ?: $post->title . ' - Laravel Blog')

@push('meta')
    <meta name="description" content="{{ $post->meta_description ?: $post->excerpt }}">
    <meta name="keywords" content="blog, article, {{ $post->title }}">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ $post->title }}">
    <meta property="og:description" content="{{ $post->excerpt }}">
    <meta property="og:type" content="article">
    <meta property="og:url" content="{{ url()->current() }}">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $post->title }}">
    <meta name="twitter:description" content="{{ $post->excerpt }}">
@endpush

@section('content')
<div class="container">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <article class="card">
                <div class="card-body">
                    <!-- Back to Blog -->
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('blog.index') }}">
                                    <i class="fas fa-home"></i> Blog
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ Str::limit($post->title, 50) }}
                            </li>
                        </ol>
                    </nav>

                    <!-- Post Header -->
                    <header class="mb-4">
                        <h1 class="display-5 mb-3">{{ $post->title }}</h1>
                        
                        <div class="blog-meta text-muted mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <i class="fas fa-calendar"></i> 
                                    Published on {{ $post->formatted_date }}
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <i class="fas fa-clock"></i> 
                                    {{ $post->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>

                        @if($post->status === 'published')
                            <span class="badge bg-success mb-3">
                                <i class="fas fa-check"></i> Published
                            </span>
                        @endif
                    </header>

                    <!-- Post Content -->
                    <div class="post-content">
                        {!! nl2br(e($post->content)) !!}
                    </div>

                    <!-- Post Footer -->
                    <footer class="mt-5 pt-4 border-top">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-tags text-muted me-2"></i>
                                    <small class="text-muted">
                                        Article • {{ $post->created_at->format('M d, Y') }}
                                    </small>
                                </div>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <!-- Social Share Buttons -->
                                <div class="social-share">
                                    <span class="me-2">Share:</span>
                                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(url()->current()) }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-outline-info me-1"
                                       title="Share on Twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-outline-primary me-1"
                                       title="Share on Facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-outline-dark"
                                       title="Share on LinkedIn">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
            </article>

            <!-- Navigation -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <a href="{{ route('blog.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i> Back to Blog
                    </a>
                </div>
                <div class="col-md-6 text-md-end">
                    <button class="btn btn-outline-secondary" onclick="window.print()">
                        <i class="fas fa-print"></i> Print Article
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="sidebar">
                <!-- Recent Posts -->
                @if($recentPosts->count() > 0)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-list"></i> More Articles
                            </h5>
                        </div>
                        <div class="card-body">
                            @foreach($recentPosts->where('id', '!=', $post->id) as $recentPost)
                                <div class="d-flex align-items-start mb-3">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">
                                            <a href="{{ route('blog.show', $recentPost->slug) }}" 
                                               class="text-decoration-none">
                                                {{ Str::limit($recentPost->title, 40) }}
                                            </a>
                                        </h6>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar"></i> {{ $recentPost->formatted_date }}
                                        </small>
                                    </div>
                                </div>
                                @if(!$loop->last)
                                    <hr class="my-2">
                                @endif
                            @endforeach
                            
                            <div class="text-center mt-3">
                                <a href="{{ route('blog.index') }}" class="btn btn-sm btn-primary">
                                    View All Posts <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Article Info -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle"></i> Article Info
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Published:</span>
                            <span class="badge bg-success">{{ $post->formatted_date }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Word Count:</span>
                            <span class="badge bg-info">{{ str_word_count(strip_tags($post->content)) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Reading Time:</span>
                            <span class="badge bg-secondary">
                                {{ ceil(str_word_count(strip_tags($post->content)) / 200) }} min
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .post-content {
        font-size: 1.1rem;
        line-height: 1.8;
    }
    
    .post-content p {
        margin-bottom: 1.5rem;
    }
    
    .social-share a {
        transition: all 0.2s ease;
    }
    
    .social-share a:hover {
        transform: translateY(-2px);
    }
    
    @media print {
        .sidebar, .navigation, nav, footer {
            display: none !important;
        }
        
        .col-lg-8 {
            width: 100% !important;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Smooth scroll to top when navigating back
    $('.btn[href*="blog.index"]').on('click', function(e) {
        if (document.referrer.includes('{{ route("blog.index") }}')) {
            e.preventDefault();
            window.history.back();
        }
    });
    
    // Copy article URL to clipboard
    function copyToClipboard() {
        navigator.clipboard.writeText(window.location.href).then(function() {
            alert('Article URL copied to clipboard!');
        });
    }
</script>
@endpush
@endsection
