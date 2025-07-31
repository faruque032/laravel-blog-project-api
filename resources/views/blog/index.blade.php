@extends('layouts.app')

@section('title', 'Laravel Blog - Latest Posts')

@push('meta')
    <meta name="description" content="Read the latest blog posts on our Laravel blog. Stay updated with fresh content and insights.">
    <meta name="keywords" content="blog, laravel, posts, articles, latest">
@endpush

@section('content')
<div class="container">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Hero Section -->
            <div class="jumbotron bg-primary text-white rounded p-4 mb-4">
                <h1 class="display-4">Welcome to Our Blog</h1>
                <p class="lead">Discover amazing content, insights, and stories from our community.</p>
            </div>

            <!-- Search Form -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('blog.index') }}" class="row g-3">
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="text" 
                                       class="form-control" 
                                       name="search" 
                                       value="{{ request('search') }}" 
                                       placeholder="Search blog posts...">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" name="per_page" onchange="this.form.submit()">
                                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 per page</option>
                                <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15 per page</option>
                                <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20 per page</option>
                            </select>
                        </div>
                    </form>
                    
                    @if(request('search'))
                        <div class="mt-3">
                            <span class="badge bg-info">
                                Searching for: "{{ request('search') }}"
                            </span>
                            <a href="{{ route('blog.index') }}" class="btn btn-sm btn-outline-secondary ms-2">
                                <i class="fas fa-times"></i> Clear
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Blog Posts -->
            @if($posts->count() > 0)
                <div class="row">
                    @foreach($posts as $post)
                        <div class="col-md-6 mb-4">
                            <div class="card blog-card h-100">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">
                                        <a href="{{ route('blog.show', $post->slug) }}" 
                                           class="text-decoration-none text-dark">
                                            {{ $post->title }}
                                        </a>
                                    </h5>
                                    
                                    <div class="blog-meta mb-2">
                                        <i class="fas fa-calendar"></i> {{ $post->formatted_date }}
                                        @if($post->status === 'published')
                                            <span class="badge bg-success ms-2">Published</span>
                                        @endif
                                    </div>
                                    
                                    <p class="card-text flex-grow-1">{{ $post->excerpt }}</p>
                                    
                                    <div class="mt-auto">
                                        <a href="{{ route('blog.show', $post->slug) }}" 
                                           class="btn btn-primary btn-sm">
                                            Read More <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $posts->links() }}
                </div>

                <!-- Results Info -->
                <div class="text-center mt-3">
                    <small class="text-muted">
                        Showing {{ $posts->firstItem() }} to {{ $posts->lastItem() }} of {{ $posts->total() }} posts
                    </small>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h4>No posts found</h4>
                    <p class="text-muted">
                        @if(request('search'))
                            No posts match your search for "{{ request('search') }}". 
                            <a href="{{ route('blog.index') }}">View all posts</a>
                        @else
                            There are no published posts yet. Check back later!
                        @endif
                    </p>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="sidebar">
                <!-- Recent Posts -->
                @if($recentPosts->count() > 0)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-clock"></i> Recent Posts
                            </h5>
                        </div>
                        <div class="card-body">
                            @foreach($recentPosts as $recentPost)
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
                        </div>
                    </div>
                @endif

                <!-- Blog Stats -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-bar"></i> Blog Stats
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Total Posts:</span>
                            <span class="badge bg-primary">{{ $posts->total() }}</span>
                        </div>
                        @if(request('search'))
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Search Results:</span>
                                <span class="badge bg-info">{{ $posts->count() }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Loading spinner for search
    $('.search-form').on('submit', function() {
        $(this).find('button[type="submit"]').html('<i class="fas fa-spinner fa-spin"></i> Searching...');
    });
    
    // Auto-submit search after typing delay
    let searchTimeout;
    $('input[name="search"]').on('input', function() {
        clearTimeout(searchTimeout);
        const form = $(this).closest('form');
        searchTimeout = setTimeout(function() {
            // Uncomment the line below to enable auto-search
            // form.submit();
        }, 1000);
    });
</script>
@endpush
@endsection
