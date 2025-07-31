
@extends('layouts.admin')

@section('title', 'Blog Posts - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Blog Posts</h1>
    <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Create New Post
    </a>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Total Posts</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $statistics['total'] }}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon">
                            <i class="fas fa-file-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card card-stats success">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Published</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $statistics['published'] }}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card card-stats warning">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Drafts</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $statistics['drafts'] }}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon">
                            <i class="fas fa-edit fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card card-stats info">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Scheduled</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $statistics['scheduled'] }}</span>
                    </div>
                    <div class="col-auto">
                        <div class="icon">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.blog.list') }}" class="row g-3">
            <div class="col-md-6">
                <label for="search" class="form-label">Search Posts</label>
                <input type="text" 
                       class="form-control" 
                       id="search" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Search by title, content, or excerpt...">
            </div>
            <div class="col-md-3">
                <label for="per_page" class="form-label">Posts per page</label>
                <select class="form-select" id="per_page" name="per_page">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid gap-2 d-md-flex">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="fas fa-search"></i> Search
                    </button>
                    @if(request()->hasAny(['search', 'per_page']))
                        <a href="{{ route('admin.blog.list') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Blog Posts Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            All Blog Posts 
            @if(request('search'))
                <small class="text-muted">(filtered by "{{ request('search') }}")</small>
            @endif
        </h5>
    </div>
    <div class="card-body">
        @if($posts->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Published Date</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($posts as $post)
                        <tr>
                            <td>
                                <div>
                                    <h6 class="mb-0">{{ Str::limit($post->title, 50) }}</h6>
                                    @if($post->slug)
                                        <small class="text-muted">{{ $post->slug }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($post->status === 'published')
                                    @if($post->published_at && $post->published_at->isPast())
                                        <span class="badge bg-success status-badge">
                                            <i class="fas fa-check"></i> Published
                                        </span>
                                    @else
                                        <span class="badge bg-info status-badge">
                                            <i class="fas fa-clock"></i> Scheduled
                                        </span>
                                    @endif
                                @else
                                    <span class="badge bg-warning text-dark status-badge">
                                        <i class="fas fa-edit"></i> Draft
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($post->published_at)
                                    <div>{{ $post->published_at->format('M d, Y') }}</div>
                                    <small class="text-muted">{{ $post->published_at->format('H:i') }}</small>
                                @else
                                    <span class="text-muted">Not published</span>
                                @endif
                            </td>
                            <td>
                                <div>{{ $post->created_at->format('M d, Y') }}</div>
                                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                            </td>
                            <td class="table-actions">
                                <div class="btn-group" role="group">
                                    @if($post->isPublished())
                                        <a href="{{ route('blog.show', $post->slug) }}" 
                                           class="btn btn-sm btn-outline-info" 
                                           target="_blank" 
                                           title="View Post">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.blog.edit', $post->id) }}" 
                                       class="btn btn-sm btn-outline-primary" 
                                       title="Edit Post">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger btn-delete" 
                                            title="Delete Post">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <p class="text-muted mb-0">
                        Showing {{ $posts->firstItem() }} to {{ $posts->lastItem() }} of {{ $posts->total() }} posts
                    </p>
                </div>
                <div>
                    {{ $posts->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                <h4>No blog posts found</h4>
                <p class="text-muted">
                    @if(request('search'))
                        No posts match your search criteria. <a href="{{ route('admin.blog.list') }}">Clear search</a> to see all posts.
                    @else
                        Get started by creating your first blog post.
                    @endif
                </p>
                <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Create New Post
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
