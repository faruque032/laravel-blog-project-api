<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class BlogApiController extends Controller
{
    /**
     * Get paginated list of published blog posts for public view
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');

        $posts = BlogPost::published()
            ->search($search)
            ->orderBy('published_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $posts->items(),
            'meta' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total(),
                'from' => $posts->firstItem(),
                'to' => $posts->lastItem(),
            ]
        ]);
    }

    /**
     * Get single blog post by ID
     */
    public function show($id): JsonResponse
    {
        $post = BlogPost::published()->find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Blog post not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $post
        ]);
    }

    /**
     * Get all blog posts for admin panel (including drafts)
     */
    public function adminIndex(Request $request): JsonResponse
    {
        $perPage = $request->get('per_page', 10);
        $search = $request->get('search');
        $status = $request->get('status');

        $query = BlogPost::query();

        if ($search) {
            $query->search($search);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $posts->items(),
            'meta' => [
                'current_page' => $posts->currentPage(),
                'last_page' => $posts->lastPage(),
                'per_page' => $posts->perPage(),
                'total' => $posts->total(),
                'from' => $posts->firstItem(),
                'to' => $posts->lastItem(),
            ]
        ]);
    }

    /**
     * Create new blog post
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'title' => 'required|max:255',
                'content' => 'required',
                'author' => 'required|max:100',
                'status' => 'required|in:draft,published',
                'published_at' => 'nullable|date'
            ]);

            if ($validated['status'] === 'published' && !isset($validated['published_at'])) {
                $validated['published_at'] = now();
            }

            $post = BlogPost::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Blog post created successfully',
                'data' => $post
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Update existing blog post
     */
    public function update(Request $request, $id): JsonResponse
    {
        $post = BlogPost::find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Blog post not found'
            ], 404);
        }

        try {
            $validated = $request->validate([
                'title' => 'sometimes|required|max:255',
                'content' => 'sometimes|required',
                'author' => 'sometimes|required|max:100',
                'status' => 'sometimes|required|in:draft,published',
                'published_at' => 'sometimes|nullable|date'
            ]);

            if (isset($validated['status']) && $validated['status'] === 'published' && !$post->published_at && !isset($validated['published_at'])) {
                $validated['published_at'] = now();
            }

            $post->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Blog post updated successfully',
                'data' => $post
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Delete blog post
     */
    public function destroy($id): JsonResponse
    {
        $post = BlogPost::find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Blog post not found'
            ], 404);
        }

        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Blog post deleted successfully'
        ]);
    }
}
