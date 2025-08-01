<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organizations;
use App\Models\Children;
use App\Models\News;
use App\Http\Controllers\Api\OrganizationController;
use Illuminate\Support\Facades\Auth;



class UserController extends Controller
{
    public function index()
    {
          $news = News::all();
        return view('home', compact('news'));
    }

    public function new()
    {

                  $news = News::all();
        return view('news', compact('news'));
    }

 public function showNews($id)
{
    $news = News::findOrFail($id); 
    return view('showNews', compact('news')); 
}



public function catalog(Request $request)
{
    $query = Organizations::with(['catalogs.category']);

    if ($request->filled('vaccine_type')) {
        $query->whereHas('catalogs.category', function ($q) use ($request) {
            $q->where('category', 'like', '%' . $request->vaccine_type . '%');
        });
    }

    if ($request->filled('location')) {
        $query->where('alamat', 'like', '%' . $request->location . '%');
    }

    if ($request->filled('date_from') && $request->filled('date_to')) {
        $query->whereHas('catalogs', function ($q) use ($request) {
            $q->whereBetween('vaccination_date', [$request->date_from, $request->date_to]);
        });
    } elseif ($request->filled('date_from')) {
        $query->whereHas('catalogs', function ($q) use ($request) {
            $q->whereDate('vaccination_date', $request->date_from);
        });
    }

    $results = $query->get();

    return view('catalog', compact('results'));
}



public function results(Request $request)
{
    $user = Auth::user();
    $child = null;

    if ($user && $user->NIK) {
        $child = Children::with(['vaccination.vaccine', 'organization'])
            ->where('NIK', $user->NIK)
            ->first();
    }

    return view('results', compact('child'));
}






}
