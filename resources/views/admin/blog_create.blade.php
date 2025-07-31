@extends('layouts.admin')

@section('title', 'Create New Post - Admin Panel')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">Create New Blog Post</h1>
    <a href="{{ route('admin.blog.list') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Back to Posts
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Post Details</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.blog.store') }}">
                    @csrf
                    
                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title') }}" 
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
                               value="{{ old('slug') }}" 
                               required>
                        <div class="form-text">URL-friendly version of the title. Will be auto-generated if left empty.</div>
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
                                  rows="3">{{ old('excerpt') }}</textarea>
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
                                  required>{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" name="status" value="published" class="btn btn-success">
                            <i class="fas fa-check"></i> Publish Post
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
        <!-- Publishing Options -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Publishing Options</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.blog.store') }}" id="publishForm">
                    @csrf
                    
                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>

                    <!-- Published Date -->
                    <div class="mb-3">
                        <label for="published_at" class="form-label">Publish Date</label>
                        <input type="datetime-local" 
                               class="form-control" 
                               id="published_at" 
                               name="published_at" 
                               value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}">
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
                           value="{{ old('meta_title') }}" 
                           maxlength="60">
                    <div class="form-text">Recommended: 50-60 characters</div>
                </div>

                <!-- Meta Description -->
                <div class="mb-3">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea class="form-control" 
                              id="meta_description" 
                              name="meta_description" 
                              form="publishForm"
                              rows="3" 
                              maxlength="160">{{ old('meta_description') }}</textarea>
                    <div class="form-text">Recommended: 150-160 characters</div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-generate slug from title
    $('#title').on('input', function() {
        const title = $(this).val();
        const slug = title
            .toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        $('#slug').val(slug);
    });

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

    // Auto-populate meta title from title
    $('#title').on('input', function() {
        if (!$('#meta_title').val()) {
            $('#meta_title').val($(this).val());
        }
    });

    // Auto-populate meta description from excerpt
    $('#excerpt').on('input', function() {
        if (!$('#meta_description').val()) {
            $('#meta_description').val($(this).val());
        }
    });

    // Sync form fields between main form and sidebar form
    $('input, textarea, select').on('change', function() {
        const name = $(this).attr('name');
        const value = $(this).val();
        $(`[name="${name}"]`).not(this).val(value);
    });
</script>
@endpush
@endsection
