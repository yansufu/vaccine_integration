<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\NewsResource;

class NewsController extends Controller
{
    /**
     * Display a listing of all news.
     */
    public function index()
    {
        $news = News::all();
        if($news->count() > 0)
        {
            return NewsResource::collection($news);
        }
        else
        {
            return response()->json(['message' => 'No Data'], 200);
        }
    }

    /**
     * Show the form for creating a new news item.
     */
    public function create()
    {
        return view('news.create');
    }

    /**
     * Store a newly created news item in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $news = new News();
        $news->title = $validated['title'];
        $news->content = $validated['content'];

        if ($request->hasFile('image')) {
            \Log::info('Image received');
            $image = $request->file('image');
            \Log::info('Original name: ' . $image->getClientOriginalName());
            \Log::info('Extension: ' . $image->getClientOriginalExtension());
            $imageName = time() . '_' . Str::slug($validated['title']) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/news_images', $imageName);
            \Log::info('Stored path: ' . $image);

            $news->image = $imageName;
        }
      

        $news->save();

        

        return response()->json(
            ['message' => 'data created successfully',
            'Data' => new NewsResource($news)], 200);
    }

    /**
     * Display the specified news item.
     */
    public function show($id)
    {
        $news = News::findOrFail($id);
        return view('news.show', compact('news'));
    }

    /**
     * Update the specified news item in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $news = News::findOrFail($id);
        $news->title = $validated['title'];
        $news->content = $validated['content'];

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($news->image && Storage::exists('public/news_images/' . $news->image)) {
                Storage::delete('public/news_images/' . $news->image);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($validated['title']) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/news_images', $imageName);
            $news->image = $imageName;
        }

        $news->save();

        return redirect()->route('news.index')->with('success', 'News has been updated successfully.');
    }

    /**
     * Remove the specified news item from storage.
     */
    public function destroy($id)
    {
        $news = News::findOrFail($id);

        // Delete the image from storage if it exists
        if ($news->image && Storage::exists('public/news_images/' . $news->image)) {
            Storage::delete('public/news_images/' . $news->image);
        }

        $news->delete();

        return redirect()->route('news.index')->with('success', 'News has been deleted successfully.');
    }
}
