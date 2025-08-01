<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Hash;

class CategoryController extends Controller
{
     public function index(){
        $category = Categories::get();
        if($category->count() > 0)
        {
            return CategoryResource::collection($category);
        }
        else
        {
            return response()->json(['message' => 'No Data'], 200);
        }
    }
}