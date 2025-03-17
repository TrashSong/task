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

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'content' => 'required|string|min:200',
            'image_path' => 'nullable|string',
        ]);

        return Article::create($data);
    }

    public function show($id): JsonResponse
    {
        $article = Article::findOrFail($id);
        return response()->json($article);
    }

    public function update(Request $request, Article $article)
    {
        $data = $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'title' => 'sometimes|string|max:255',
            'short_description' => 'sometimes|string|max:500',
            'content' => 'sometimes|string|min:200',
            'image_path' => 'nullable|string',
        ]);

        $article->update($data);

        return $article;
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return response()->json(['message' => 'Article deleted']);
    }
}
