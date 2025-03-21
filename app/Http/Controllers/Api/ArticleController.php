<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $categoryId = $request->query('category_id');
        $articles = Article::when($categoryId, function ($query) use ($categoryId) {
            return $query->where('category_id', $categoryId);
        })->select(['id', 'image_path', 'title', 'published_at', 'short_description', 'likes', 'created_at'])
          ->orderByDesc('created_at')
          ->paginate(10);
        return response()->json($articles);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'content' => 'required|string|min:200',
            'image_path' => 'nullable|string',
        ]);

        $article = Article::create($data);

        return response()->json([
            'status' => 'success',
            'article' => $article
        ], 201);
    }

    public function show($id): JsonResponse
    {
        if (!is_numeric($id)) {
            return response()->json(['error' => 'Invalid article ID'], 400);
        }

        $article = Article::find($id);
        if (!$article) {
            return response()->json(['error' => 'Article not found'], 404);
        }

        return response()->json($article);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $article = Article::find($id);
        if (!$article) {
            return response()->json(['error' => 'Article not found'], 404);
        }

        $data = $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'title' => 'sometimes|string|max:255',
            'short_description' => 'sometimes|string|max:500',
            'content' => 'sometimes|string|min:200',
            'image_path' => 'nullable|string',
        ]);

        $article->update($data);

        return response()->json([
            'status' => 'success',
            'article' => $article
        ]);
    }

    public function destroy($id): JsonResponse
    {
        if (!is_numeric($id)) {
            return response()->json(['error' => 'Invalid article ID'], 400);
        }
        
        $article = Article::find($id);
        if (!$article) {
            return response()->json(['error' => 'Article not found'], 404);
        }

        $article->delete();
        return response()->json(['message' => 'Article deleted']);
    }
}
