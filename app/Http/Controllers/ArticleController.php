<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->paginate(10);
        $allTags = Tag::all();
        $selectedTag = null;

        return view('dashboard', compact('articles', 'allTags', 'selectedTag'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'         => 'required',
            'image'         => 'nullable|mimes:jpeg,png,jpg,svg|max:2048',
            'content'       => 'required',
            'published_at'  => 'required|date',
            'tags'          => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['image_path'] = $request->hasFile('image')
            ? $request->file('image')->store('articles', 'public')
            : 'articles/default.jpg';

        $article = Article::create($validated);

        if (!empty($validated['tags'])) {
            $tagsArray = array_filter(array_map('trim', explode(',', $validated['tags'])));
            $tagIds = [];
            foreach ($tagsArray as $tagName) {
                $tagIds[] = Tag::firstOrCreate(['name' => $tagName])->id;
            }
            $article->tags()->attach($tagIds);
        }

        return redirect()->route('myarticle')->with('success', 'Maqola yaratildi.');
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);

        if ($article->user_id !== Auth::id()) {
            $ip = request()->ip();
            $userAgent = substr(request()->header('User-Agent'), 0, 255);
            $uniqueKey = 'article_viewed_' . $article->id . '_' . md5($ip . $userAgent);

            if (!Cache::has($uniqueKey)) {
                Cache::put($uniqueKey, true, now()->addHours(24));
                $article->increment('views');
            }
        }

        return view('user.article', compact('article'));
    }


    public function edit($id)
    {
        $article = Article::findOrFail($id);

        if ($article->user_id !== Auth::id()) {
            abort(403, 'Siz bu maqolani tahrirlay olmaysiz');
        }

        return view('user.edit', compact('article'));
    }

    public function update(Article $article, Request $request)
    {
        if ($article->user_id !== Auth::id()) {
            abort(403, 'Siz bu maqolani yangilay olmaysiz');
        }

        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'image'         => 'nullable|mimes:jpeg,png,jpg,svg|max:2048',
            'content'       => 'required|string',
            'published_at'  => 'required|date',
            'tags'          => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('articles', 'public');
        }

        $article->update($validated);

        if (!empty($validated['tags'])) {
            $tagsArray = array_filter(array_map('trim', explode(',', $validated['tags'])));
            $tagIds = [];
            foreach ($tagsArray as $tagName) {
                $tagIds[] = Tag::firstOrCreate(['name' => $tagName])->id;
            }
            $article->tags()->sync($tagIds);
        } else {
            $article->tags()->detach();
        }

        return redirect()->route('myarticle')->with('success', 'Maqola yangilandi.');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);

        if ($article->user_id !== Auth::id()) {
            abort(403, 'Siz bu maqolani o‘chira olmaysiz');
        }

        $article->delete();

        return redirect()->route('articles.index')->with('success', 'Maqola o‘chirildi');
    }

    public function myArticles()
    {
        $articles = Article::where('user_id', auth()->id())
            ->latest()
            ->paginate(6);

        $allTags = Tag::all();
        $selectedTag = null;

        return view('user.myarticle', compact('articles', 'allTags', 'selectedTag'));
    }

    public function byTag($tagId)
    {
        $selectedTag = Tag::findOrFail($tagId);

        $articles = Article::with('tags')
            ->whereHas('tags', fn($query) => $query->where('tags.id', $tagId))
            ->latest()
            ->paginate(9);

        $allTags = Tag::all();

        return view('user.myarticle', compact('articles', 'allTags', 'selectedTag'));
    }
}
