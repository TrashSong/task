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
    
    public function show($id): JsonResponse
    {
        $article = Article::findOrFail($id);
        return response()->json($article);
    }
}
