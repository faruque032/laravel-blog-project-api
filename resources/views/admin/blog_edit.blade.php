@extends('layouts.admin')

@section('title', 'Edit Post: ' . $post->title . ' - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Edit Blog Post</h1>
    <div class="btn-group">
        @if($post->isPublished())
            <a href="{{ route('blog.show', $post->slug) }}" 
               class="btn btn-outline-info" 
               target="_blank">
                <i class="fas fa-eye"></i> View Post
            </a>
        @endif
        <a href="{{ route('admin.blog.list') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Posts
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Post Details</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.blog.update', $post->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $post->title) }}" 
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('slug') is-invalid @enderror" 
                               id="slug" 
                               name="slug" 
                               value="{{ old('slug', $post->slug) }}" 
                               required>
                        <div class="form-text">URL-friendly version of the title.</div>
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Excerpt -->
                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Excerpt</label>
                        <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                  id="excerpt" 
                                  name="excerpt" 
                                  rows="3">{{ old('excerpt', $post->excerpt) }}</textarea>
                        <div class="form-text">Brief description of the post (optional).</div>
                        @error('excerpt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div class="mb-3">
                        <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" 
                                  name="content" 
                                  rows="15" 
                                  required>{{ old('content', $post->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" name="status" value="published" class="btn btn-success">
                            <i class="fas fa-check"></i> Update & Publish
                        </button>
                        <button type="submit" name="status" value="draft" class="btn btn-secondary">
                            <i class="fas fa-save"></i> Save as Draft
                        </button>
                        <a href="{{ route('admin.blog.list') }}" class="btn btn-outline-danger">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Post Status -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Post Status</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <strong>Current Status:</strong>
                    </div>
                    <div class="col-6">
                        @if($post->status === 'published')
                            @if($post->published_at && $post->published_at->isPast())
                                <span class="badge bg-success">Published</span>
                            @else
                                <span class="badge bg-info">Scheduled</span>
                            @endif
                        @else
                            <span class="badge bg-warning text-dark">Draft</span>
                        @endif
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-6">
                        <strong>Created:</strong>
                    </div>
                    <div class="col-6">
                        <small>{{ $post->created_at->format('M d, Y H:i') }}</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <strong>Modified:</strong>
                    </div>
                    <div class="col-6">
                        <small>{{ $post->updated_at->format('M d, Y H:i') }}</small>
                    </div>
                </div>
                @if($post->published_at)
                    <div class="row">
                        <div class="col-6">
                            <strong>Published:</strong>
                        </div>
                        <div class="col-6">
                            <small>{{ $post->published_at->format('M d, Y H:i') }}</small>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Publishing Options -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Publishing Options</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.blog.update', $post->id) }}" id="publishForm">
                    @csrf
                    @method('PUT')
                    
                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>

                    <!-- Published Date -->
                    <div class="mb-3">
                        <label for="published_at" class="form-label">Publish Date</label>
                        <input type="datetime-local" 
                               class="form-control" 
                               id="published_at" 
                               name="published_at" 
                               value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}">
                        <div class="form-text">Leave empty to publish immediately.</div>
                    </div>
                </form>
            </div>
        </div>

        <!-- SEO Settings -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">SEO Settings</h5>
            </div>
            <div class="card-body">
                <!-- Meta Title -->
                <div class="mb-3">
                    <label for="meta_title" class="form-label">Meta Title</label>
                    <input type="text" 
                           class="form-control" 
                           id="meta_title" 
                           name="meta_title" 
                           form="publishForm"
                           value="{{ old('meta_title', $post->meta_title) }}" 
                           maxlength="60">
                    <div class="form-text">{{ strlen($post->meta_title ?: '') }}/60 characters</div>
                </div>

                <!-- Meta Description -->
                <div class="mb-3">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea class="form-control" 
                              id="meta_description" 
                              name="meta_description" 
                              form="publishForm"
                              rows="3" 
                              maxlength="160">{{ old('meta_description', $post->meta_description) }}</textarea>
                    <div class="form-text">{{ strlen($post->meta_description ?: '') }}/160 characters</div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Character count for meta fields
    $('#meta_title').on('input', function() {
        const length = $(this).val().length;
        const max = 60;
        $(this).next('.form-text').text(`${length}/${max} characters`);
        if (length > max) {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    $('#meta_description').on('input', function() {
        const length = $(this).val().length;
        const max = 160;
        $(this).next('.form-text').text(`${length}/${max} characters`);
        if (length > max) {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    // Sync form fields between main form and sidebar form
    $('input, textarea, select').on('change', function() {
        const name = $(this).attr('name');
        const value = $(this).val();
        $(`[name="${name}"]`).not(this).val(value);
    });

    // Confirm navigation away with unsaved changes
    let formChanged = false;
    $('input, textarea, select').on('change', function() {
        formChanged = true;
    });

    $('form').on('submit', function() {
        formChanged = false;
    });

    $(window).on('beforeunload', function() {
        if (formChanged) {
            return 'You have unsaved changes. Are you sure you want to leave?';
        }
    });
</script>
@endpush
@endsection
