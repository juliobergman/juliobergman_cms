<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function all(Request $request)
    {
        if ($request->category) {
            return Media::where('category_id', $request->category)->get();
        } else {
            return Media::all();
        }
    }
}
