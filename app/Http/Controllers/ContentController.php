<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\Models\Content;
use App\Models\ContentData;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function content(Request $request)
    {
        return ContentData::all();
    }

    public function update(Request $request)
    {

        $id['connection'] = $request->id;
        $id['content'] = $request->content_id;
        $id['content_data'] = $request->content_id;

        $update['connection'] = $request->only(
            'id',
            'public',
        );
        $update['connection']['section'] = $request->section_id;
        $update['connection']['content'] = $request->content_id;
        $update['content'] = $request->only('name');
        $update['content_data'] = $request->only(
            'path',
            'page_title',
            'seo_info',
            'og_img',
            'cover',
        );

        Connection::where('id', $id['connection'])->update($update['connection']);
        Content::where('id', $id['content'])->update($update['content']);
        ContentData::where('id', $id['content_data'])->update($update['content_data']);

        return new JsonResponse([],200);
    }
}
