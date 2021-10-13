<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\ContentData;
use Illuminate\Http\Request;
use App\Models\MediaCategory;
use Illuminate\Http\JsonResponse;

class MediaCategoryController extends Controller
{
    public function categories(Request $request)
    {
        $categories = MediaCategory::query();
        $categories->orderBy('id', 'desc');

        // $categories->with('files');
        // $categories->with('content');
        // $categories->with('connection');

        return $categories->get();
    }

    public function store(Request $request)
    {


        $request->merge(["page_title"=> ucwords($request->name).' | Media']);
        $request->merge(["path"=> '/media/'.$request->folio]);
        $request->merge(["folio"=> $request->folio]);

        $request->validate([
            'name' => 'required|unique:media_categories|max:255|min:3',
            'page_title' => 'required|min:3',
            'path' => 'required|unique:contents',
            'folio' => 'required|unique:contents',
        ]);

        $newCategory = MediaCategory::insertGetId([
            'name' => $request->name,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $newContent = Content::create([
            'media_category_id' => $newCategory,
            'folio' => $request->folio,
            'name' => $request->name,
            'path' => $request->path,
            'created_at' => now(),
            'updated_at' => now(),
        ])->id;

        $newContentData = ContentData::insert([
            'content_id' => $newContent,
            'page_title' => $request->page_title,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($newCategory && $newContent && $newContentData) {
            return new JsonResponse(['messages' => ['New Album has been created.'], 'created' => $newCategory], 201);
        } else {
            return new JsonResponse(['message' => ['Error']], 418);
        }

    }

    public function destroy(Request $request)
    {
        $id = $request->id;

        $mediaQuery = MediaCategory::query();
        $mediaQuery->where('id', $id);
        $mediaQuery->with('files');
        $media = $mediaQuery->first();

        if(!$media){
            return new JsonResponse(['errors' => ['Item not Found']], 404);
        }

        $files = count($media->files);
        if($files){
            return new JsonResponse(['errors' => ['Delete Fail','This album contain images in it.','Delete all the images before trying to remove this album.']], 405);
        }

        if($media->delete()){
                return new JsonResponse(['messages' => ['Album Successfully Deleted']], 200);
        }
    }
}
