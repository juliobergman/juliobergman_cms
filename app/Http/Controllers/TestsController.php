<?php

namespace App\Http\Controllers;

use Illuminate\Http\File;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class TestsController extends Controller
{
    public function index()
    {
        return 'Test Controller';
    }
}
