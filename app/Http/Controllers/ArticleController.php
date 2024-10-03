<?php

namespace App\Http\Controllers;

use App\Http\Requests\Article\StoreArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource
     */
    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->limit(10)->with('user')->get();
        return inertia('Article/Index', ['articles' => $articles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Article::class);

        return inertia('Article/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        Gate::authorize('create', Article::class);

        $string = $request->get('title') . now()->format('Y-m-d-m-Y-H-i-s');
        $data = ($request->validated() + ['slug' => Str::slug($string)]);
        Auth::user()->articles()->create($data);

        return back()->with(['message' => 'Article Created Successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return inertia('Article/Show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        Gate::authorize('update', $article);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        Gate::authorize('update', $article);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        Gate::authorize('delete', $article);

        $article->delete();

        return back()->with(['message' => 'Article Deleted Successfully']);

    }
}
