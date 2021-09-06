<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class MediaController extends Controller
{
    public function index()
    {
        return 'index';
    }
    public function all(Request $request)
    {
        $media = Media::query();
        if ($request->category) {
            $media->where('category_id', $request->category)->get();
            $media->orderBy('oby');
        }
        return $media->get();
    }
    public function bulkUpsert(Request $request)
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

        return DB::table('media')->upsert($update, ['id'], $columns);
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
}
