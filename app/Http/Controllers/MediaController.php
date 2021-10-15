<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class MediaController extends Controller
{

    protected $image_defaults = [
        'name' => null,
        'fullsize' => '/storage/factory/stock/cover-placeholder/fullsize.jpg',
        'xlarge' => '/storage/factory/stock/cover-placeholder/xlarge.jpg',
        'large' => '/storage/factory/stock/cover-placeholder/large.jpg',
        'medium' => '/storage/factory/stock/cover-placeholder/medium.jpg',
        'thumbnail' => '/storage/factory/stock/cover-placeholder/thumbnail.jpg',
    ];

    public function index()
    {
        return 'index';
    }
    public function all(Request $request)
    {
        $records = $request->records;
        if(!$records){ $records = 18; }

        $media = Media::query();
        // return Media::simplePaginate(6);
        if ($request->category) {
            $media->where('category_id', $request->category);
        }
        $media->orderBy('oby');
        return $media->paginate($records);
        // return $media->get();
    }

    public function show(Request $request)
    {
        if(!$request->id){
            return $this->image_defaults;
        }
        return Media::where('id', $request->id)->first();
    }

    public function store(Request $request)
    {
        // Columns to Update
        $columns = [
            'name',
            'alt',
            'info',
            'category_id',
            'public',
        ];
        $update = $request->only($columns);
        // return $update;
        $updated = Media::where('id', $request->id)->update($update);
        if ($updated) {
            return new JsonResponse(['message' => 'Success'], 200);
        } else {
            return new JsonResponse([], 204);
        }
    }


    public function order(Request $request)
    {
        // Columns to Update
        $columns = [
            'name',
            'alt',
            'info',
            'category_id',
            'public_path',
            'storage_path',
            'fullsize',
            'xlarge',
            'large',
            'medium',
            'thumbnail',
            'oby',
            'public',
            'updated_at',
        ];

        $items = $request->toArray();

        foreach ($items as $key => $media) {
            $update[$key]['id'] = $media['id'];
            foreach ($columns as $column) {
                $update[$key][$column] = $media[$column];
            }
            $update[$key]['oby'] = $key;
            $update[$key]['updated_at'] = date(now());
        }

        $records = DB::table('media')->upsert($update, ['id'], $columns);
        return new JsonResponse(['message' => 'Records Updated', 'data' => $update, 'count' => $records], 200);
    }

    public function update_bulk(Request $request)
    {
        $media = Media::whereIn('id', $request->items)->update([
            'public' => $request->public,
            'category_id' => $request->category,
        ]);

        return $media;
    }

}
