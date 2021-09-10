<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ConnectionController extends Controller
{
    public function connections(Request $request)
    {

        $records = $request->records;
        if(!$records){ $records = 12; }

        $data_select = [
            // Connection
            'connections.id as id',
            'connections.section_id',
            'connections.content_id',
            'connections.public',
            'connections.oby',
            'connections.updated_at',
            // Content
            'contents.name',
            // Content Data
            'content_data.path',
            'content_data.page_title',
            'content_data.seo_info',
            'content_data.og_img',
            'content_data.cover',
        ];

        $connections = Connection::query();
        // Where
        $connections->where('connections.section_id', $request->section);
        // Selects
        $connections->select($data_select);
        // With
        $connections->with('og_image');
        $connections->with('cover_image');
        // Join
        $connections->join('contents', 'connections.content_id', '=', 'contents.id');
        $connections->join('content_data', 'connections.content_id', '=', 'content_data.content_id');
        // OrderBy
        $connections->orderBy('oby');
        return $connections->paginate($records);
    }

    public function bulkUpsert(Request $request)
    {
        // Columns to Update
        $columns = [
            'id',
            'section_id',
            'content_id',
            'public',
            'oby',
            'updated_at',
        ];

        $items = $request->toArray();

        foreach ($items as $key => $conn) {
            $update[$key]['id'] = $conn['id'];
            foreach ($columns as $column) {
                $update[$key][$column] = $conn[$column];
            }
            $update[$key]['oby'] = $key;
            $update[$key]['updated_at'] = date(now());
        }

        $records = DB::table('connections')->upsert($update, ['id'], $columns);
        return new JsonResponse(['message' => 'Records Updated', 'data' => $update, 'count' => $records], 200);
    }
}
