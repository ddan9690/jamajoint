<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::latest()->get();

        return view('backend.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required',

        ]);

        $slug = Str::slug($validatedData['title'], '-');

        $originalSlug = $slug;
        $count = 1;
        while (News::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }


        $user = auth()->user();


        $news = new News();
        $news->title = $validatedData['title'];
        $news->slug = $slug;
        $news->description = $validatedData['description'];
        $news->user_id = $user->id;
        $news->save();


        return redirect()->route('news.index')->with('success', 'News article created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($news, $slug)
    {
        $news = News::findOrFail($news); // Fetch the news item using the ID
        if ($news->slug !== $slug) {
            // Redirect to the correct URL if the slug doesn't match
            return redirect()->route('news.show', ['news' => $news->id, 'slug' => $news->slug], 301);
        }

        return view('backend.news.show', compact('news'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        return view('backend.news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required',
        ]);

        // Check if the title has changed
        if ($validatedData['title'] !== $news->title) {
            // If the title has changed, update the slug
            $slug = Str::slug($validatedData['title'], '-');
            $originalSlug = $slug;
            $count = 1;
            while (News::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
            $news->slug = $slug;
        }

        // Update other fields
        $news->title = $validatedData['title'];
        $news->description = $validatedData['description'];
        $news->save();

        return redirect()->route('news.index')->with('success', 'News article updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {

        $news->delete();

        return redirect()->route('news.index')->with('success', 'News article deleted successfully.');
    }
}
