<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use Illuminate\Http\Request;

class ConnectionController extends Controller
{
    public function connections(Request $request)
    {
        $data_select = [
            // Connection
            'connections.id as id',
            'connections.section as section_id',
            'connections.content as content_id',
            'connections.public',
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
        // $connections->where('connections.section', $request->section);
        // Selects
        $connections->select($data_select);
        // With
        $connections->with('og_image');
        $connections->with('cover_image');
        // Join
        $connections->join('contents', 'connections.content', '=', 'contents.id');
        $connections->join('content_data', 'connections.content', '=', 'content_data.content_id');
        return $connections->get();
    }
}
