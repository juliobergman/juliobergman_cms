<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function all(Request $request)
    {

        $media = Media::query();
        if ($request->category) { $media->where('category_id', $request->category)->get(); }


        $media->orderBy('oby');


        return $media->get();


    }
}
