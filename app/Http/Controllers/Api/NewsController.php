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
    // public function index()
    // {
    //     $news = News::all();
    //     if($news->count() > 0)
    //     {
    //         return NewsResource::collection($news);
    //     }
    //     else
    //     {
    //         return response()->json(['message' => 'No Data'], 200);
    //     }
    // }
    public function index()
    {
        $news = News::all();

        return $news->count()
            ? NewsResource::collection($news)
            : response()->json(['message' => 'No Data'], 200);
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

            $stored = Storage::disk('public')->putFileAs('news_images', $image, $imageName);
            \Log::info('Stored: ' . ($stored ? 'yes' : 'no'));

            if ($stored) {
                $news->image = $imageName;
            }
        }

        $news->save();

        return response()->json([
            'message' => 'Data created successfully',
            'Data' => new NewsResource($news)
        ], 200);
    }


    /**
     * Display the specified news item.
     */
    // public function show($id)
    // {
    //     $news = News::findOrFail($id);
    //     return view('news.show', compact('news'));
    // }
    public function show($id)
    {
        $news = News::find($id);
        return $news
            ? new NewsResource($news)
            : response()->json(['message' => 'News not found'], 404);
    }


    /**
     * Update the specified news item in storage.
     */
    // public function update(Request $request, $id)
    // {
    //     $validated = $request->validate([
    //         'title'   => 'required|string|max:255',
    //         'content' => 'required|string',
    //         'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //     ]);

    //     $news = News::findOrFail($id);
    //     $news->title = $validated['title'];
    //     $news->content = $validated['content'];

    //     if ($request->hasFile('image')) {
    //         \Log::info('Image received in update');

    //         if ($news->image && Storage::disk('public')->exists('news_images/' . $news->image)) {
    //             Storage::disk('public')->delete('news_images/' . $news->image);
    //             \Log::info('Old image deleted: ' . $news->image);
    //         }

    //         $image = $request->file('image');
    //         $imageName = time() . '_' . Str::slug($validated['title']) . '.' . $image->getClientOriginalExtension();

    //         $stored = Storage::disk('public')->putFileAs('news_images', $image, $imageName);
    //         \Log::info('Stored new image: ' . ($stored ? $imageName : 'failed'));

    //         if ($stored) {
    //             $news->image = $imageName;
    //         }

    //     }

    //     $news->save();

    //     return redirect()->route('news.index')->with('success', 'News has been updated successfully.');
    // }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'image'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $news = News::find($id);
        if (!$news) {
            return response()->json(['message' => 'News not found'], 404);
        }

        $news->title = $validated['title'];
        $news->content = $validated['content'];

        if ($request->hasFile('image')) {
            if ($news->image && Storage::disk('public')->exists('news_images/' . $news->image)) {
                Storage::disk('public')->delete('news_images/' . $news->image);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($validated['title']) . '.' . $image->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('news_images', $image, $imageName);
            $news->image = $imageName;
        }

        $news->save();

        return response()->json(['message' => 'News updated successfully', 'data' => new NewsResource($news)], 200);
    }



    /**
     * Remove the specified news item from storage.
     */
    // public function destroy($id)
    // {
    //     $news = News::findOrFail($id);

    //     // Delete the image from storage if it exists
    //     if ($news->image && Storage::exists('public/news_images/' . $news->image)) {
    //         Storage::delete('public/news_images/' . $news->image);
    //     }

    //     $news->delete();

    //     return redirect()->route('news.index')->with('success', 'News has been deleted successfully.');
    // }
    public function destroy($id)
    {
        $news = News::find($id);
        if (!$news) {
            return response()->json(['message' => 'News not found'], 404);
        }

        if ($news->image && Storage::exists('public/news_images/' . $news->image)) {
            Storage::delete('public/news_images/' . $news->image);
        }

        $news->delete();

        return response()->json(['message' => 'News deleted successfully'], 200);
    }

}
