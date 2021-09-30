<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SectionController extends Controller
{
    public function sections(Request $request)
    {
        return Section::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:sections|max:255|min:3',
        ]);

       $new = Section::insert([
            'name' => $request->name,
        ]);
        if ($new) {
            return new JsonResponse(['message' => 'New Section has been created.'], 201);
        } else {
            return new JsonResponse(['message' => 'Error'], 418);
        }


    }
}
