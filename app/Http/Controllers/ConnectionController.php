<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
            'contents.folio',
            'contents.name',
            'contents.subtitle',
            'contents.path',
            // Content Data
            'content_data.page_title',
            'content_data.seo_info',
            'content_data.cover',
        ];

        $connections = Connection::query();
        // Where
        $connections->where('connections.section_id', $request->section);
        // Selects
        $connections->select($data_select);
        // With
        $connections->with('cover_image');
        // Join
        $connections->join('contents', 'connections.content_id', '=', 'contents.id');
        $connections->join('content_data', 'connections.content_id', '=', 'content_data.content_id');
        // OrderBy
        $connections->orderBy('oby');
        return $connections->paginate($records);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $rules = [
            'section_id' => [
                'required',
                Rule::unique('connections')->ignore($request->id)->where(function ($query) use ($request) {
                    return $query->where('section_id', $request->section_id)->where('content_id', $request->content_id);
                })
            ],
            'content_id' => [
                'required',
            ]
        ];
        $messages = [
            'section_id.unique' => 'This Section already has an instance of this content',
        ];

        $validator = Validator::make($data,$rules,$messages);
        if ($validator->fails()) {
            return new JsonResponse(['errors' => $validator->errors()], 405);
        }

        $newContent = Connection::create([
            'section_id' => $request->section_id,
            'content_id' => $request->content_id
            ])->id;

        if ($newContent) {
            return new JsonResponse(['message' => 'New Connection has been created.'], 201);
        } else {
            return new JsonResponse(['errors' => 'Error'], 418);
        }
    }

    public function update(Request $request)
    {

        // Validation
        $data = $request->all();
        $rules = [
            'section_id' => [
                'required',
                Rule::unique('connections')->ignore($request->id)->where(function ($query) use ($request) {
                    return $query->where('section_id', $request->section_id)->where('content_id', $request->content_id);
                })
            ],
            'content_id' => [
                'required',
            ],
            'public' => [
                'required',
            ]
        ];
        $messages = [
            'section_id.unique' => 'This Section already has an instance of this content',
        ];

        $validator = Validator::make($data,$rules,$messages);
        if ($validator->fails()) {
            return new JsonResponse(['errors' => $validator->errors()], 405);
        }

        // Update
        $update = [
            'section_id' => $request->section_id,
            'public' => $request->public
        ];
        $connection = Connection::where('id', $request->id)->update($update);
        if($connection){
            return new JsonResponse(['message' => 'connection/update'], 200);
        }
        return new JsonResponse(['error' => ['Something Happened!']], 405);
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
