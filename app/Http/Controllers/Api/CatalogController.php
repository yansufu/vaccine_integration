<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalogs;
use App\Http\Resources\CatalogResource;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Catalog::with(['organization', 'category']); // Include relationships

        if ($request->filled('vaccine_type')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->vaccine_type . '%');
            });
        }

        if ($request->filled('location')) {
            $query->whereHas('organization', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->location . '%');
            });
        }

        if ($request->filled('date_from')) {
            $query->whereDate('vaccination_date', $request->date_from);
        }

        $results = $query->get();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json($results);
        }

        return view('catalog.index', compact('results'));

        return view('catalog.index', compact('results'));
    }

    public function show(Catalogs $catalog){
        return new CatalogResource($catalog);
    }

    public function destroy(Catalogs $catalog){
        $catalog->delete();
        return response()->json(['message' => 'delete catalog'], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'org_id' => 'required|exists:organization,id',
            'catalog_categories' => 'required|array',
            'catalog_categories.*.cat_id' => 'required|exists:category,id',
            'catalog_categories.*.price' => 'required|numeric|min:0',
            'catalog_categories.*.vaccination_date' => 'required|date',
        ]);

        $createdCatalogs = [];

        foreach ($request->catalog_categories as $catalog) {
            $newCatalog = Catalogs::create([
                'org_id' => $request->org_id,
                'cat_id' => $catalog['cat_id'],
                'price' => $catalog['price'],
                'vaccination_date' => $catalog['vaccination_date'],
            ]);

            $createdCatalogs[] = new CatalogResource($newCatalog);
        }

        return response()->json([
            'message' => 'Data created successfully',
            'data' => $createdCatalogs
        ], 201);
    }


    public function update(Request $request, Catalogs $catalog)
    {
        $request->validate([
            'org_id' => 'required|exists:organization,id',
            'cat_id' => 'required|exists:category,id',
            'price' => 'required|numeric|min:0',
            'vaccination_date' => 'required|date',
        ]);

        $catalog->update([
            'org_id' => $request->org_id,
            'cat_id' => $request->cat_id,
            'price' => $request->price,
            'vaccination_date' => $request->vaccination_date,
        ]);

        return response()->json(['message' => 'Catalog updated successfully', 'catalog' => $catalog], 200);
    }

}
