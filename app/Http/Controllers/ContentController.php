<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Connection;
use App\Models\ContentData;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ContentController extends Controller
{
    public function content(Request $request)
    {
        return ContentData::all();
    }

    public function guest_content(Request $request)
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
            'contents.folio',
            'contents.name',
            'contents.subtitle',
            'contents.path',
            // Content Data
            'content_data.page_title',
            'content_data.seo_info',
            'content_data.og_img',
            'content_data.cover',
        ];

        $connections = Connection::query();
        // Where
        $connections->where('connections.section_id', $request->section);
        // $connections->where('connections.public', 'yes');
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

    public function show(Request $request)
    {

        $path = $request->path;
        if(!$path){
            $path = '/';
        }

        $data_select = [
            // Content
            'contents.id',
            'contents.folio',
            'contents.name',
            'contents.subtitle',
            'contents.path',
            // Content Data
            'content_data.page_title',
            'content_data.seo_info',
            'content_data.og_img',
            'content_data.cover',
        ];

        $content = Content::query();
        // Where
        $content->where('contents.path', $path);
        // Selects
        $content->select($data_select);
        // With
        $content->with('og_image');
        $content->with('cover_image');
        // Join
        $content->join('content_data', 'contents.id', '=', 'content_data.content_id');
        // OrderBy
        // $content->orderBy('oby');
        return $content->first();
    }

    public function store(Request $request)
    {

        // Fix Path
        $path = $request->path;
        $path = rtrim($path, '/');
        $path = ltrim($path, '/');
        $request->path = '/'.$path;
        $request->merge(["path"=> $path]);

        $request->validate([
            'section' => 'required',
            'name' => 'required|unique:sections|max:255|min:3',
            'page_title' => 'required|min:3',
            'path' => 'required|unique:contents',
            'folio' => 'required|unique:contents',
            'seo_info' => 'min:3',
        ]);

        $newContent = Content::create([
            'folio' => $request->folio,
            'name' => $request->name,
            'path' => $path,
        ])->id;

        $newContentData = ContentData::insert([
            'content_id' => $newContent,
            'page_title' => $request->page_title,
            'seo_info' => $request->seo_info,
        ]);
        $newConnection = Connection::insert([
            'section_id' => $request->section,
            'content_id' => $newContent,
        ]);

        if ($newContent && $newContentData && $newConnection) {
            return new JsonResponse(['message' => 'New Content has been created.'], 201);
        } else {
            return new JsonResponse(['message' => 'Error'], 400);
        }



    }

    public function update(Request $request)
    {

        // Fix Path
        $path = $request->path;
        $path = rtrim($path, '/');
        $path = ltrim($path, '/');
        $request->merge(["path"=> $path]);

        $id['connection'] = $request->id;
        $id['content'] = $request->content_id;

        $update['connection'] = $request->only(
            'section_id',
            'content_id',
            'public',
        );
        $update['content'] = [
            'folio' => $request->folio,
            'name' => $request->name,
            'path' => '/'.$path,
        ];
        $update['content_data'] = $request->only(
            'page_title',
            'seo_info',
            'og_img',
            'cover',
        );

        $connection = Connection::where('id', $id['connection'])->update($update['connection']);
        $content = Content::where('id', $id['content'])->update($update['content']);
        $contentData = ContentData::where('content_id', $id['content'])->update($update['content_data']);

        if ($content && $contentData && $connection) {
            return new JsonResponse(['message' => 'Content has been Updated.'], 200);
        } else {
            return new JsonResponse(['message' => 'Error'], 400);
        }
    }

}
