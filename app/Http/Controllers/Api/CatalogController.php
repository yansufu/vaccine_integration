<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalogs;
use App\Http\Resources\CatalogResource;

class CatalogController extends Controller
{
    public function index()
    {
        $catalog = Catalogs::get();
        if($catalog->count() > 0)
        {
            return CatalogResource::collection($catalog);
        }
        else
        {
            return response()->json(['message' => 'No Data'], 200);
        }
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
