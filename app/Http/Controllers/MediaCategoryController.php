<?php

namespace App\Http\Controllers;

use App\Models\MediaCategory;
use Illuminate\Http\Request;

class MediaCategoryController extends Controller
{
    public function categories(Request $request)
    {
        return MediaCategory::all();
    }
}
