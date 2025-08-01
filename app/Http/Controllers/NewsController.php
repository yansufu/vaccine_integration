<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::all();
        return view('news.index', compact('news'));
    }

    public function create()
    {


        return view('news.create');
    }
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
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($validated['title']) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/news_images', $imageName);
            $news->image = $imageName;
        }

        $news->save();

        return redirect()->route('news.index')->with('success', 'Berita berhasil disimpan');
    }

    public function show($id)
    {
        $news = News::findOrFail($id);
        return view('news.show', compact('news'));
    }

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
            // Hapus gambar lama jika ada
            if ($news->image && \Storage::exists('public/news_images/' . $news->image)) {
                \Storage::delete('public/news_images/' . $news->image);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($validated['title']) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/news_images', $imageName);
            $news->image = $imageName;
        }

        $news->save();

        return redirect()->route('news.index')->with('success', 'Berita berhasil diperbarui');
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);

        // Delete image from storage
        if ($news->image && \Storage::exists('public/news_images/' . $news->image)) {
            \Storage::delete('public/news_images/' . $news->image);
        }

        $news->delete();

        return redirect()->route('news.index')->with('success', 'Berita berhasil dihapus');
    }

}
