<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{

    protected $formats = [
        // 'full' => [],
        'xlarge' => ['2048','1536'],
        'large' => ['1024','768'],
        'medium' => ['640','480'],
        'thumbnail' => ['200','200'],
    ];

    public function test(Request $request)
    {
        return 'Upload Tester';
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'image' => 'required',
            'image.*' => 'mimes:png,jpg,jpeg'
        ]);

        if($request->hasfile('image')){
            foreach ($request->file('image') as $key => $file) {
                $original_filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $random_number = rand(1,5000);
                $hash = hash('md5', $original_filename.time().$random_number);

                $insert[$key]['public_path'] = '/public/media/'.$hash;
                $insert[$key]['storage_path'] = '/storage/media/'.$hash;

                $fullsize = Storage::putFileAs('public/media/'.$hash, new File($file), $hash.'.'.$file->extension());
                $insert[$key]['fullsize'] = Storage::url($fullsize);

                if ($fullsize) {
                    foreach ($this->formats as $size => $dim) {
                        $ext = 'jpg';
                        $img = Image::make(storage_path('app/'.$fullsize));
                        $name = $hash.'-'.$size.'.'.$ext;
                        $path = storage_path('app/public/media/'.$hash.'/'.$name);
                        $img->fit($dim[0], $dim[1], function ($constraint) {
                            $constraint->upsize();
                        });
                        $img->save($path, 85, $ext);
                        $insert[$key][$size] = '/storage/media/'.$hash.'/'.$name;
                    }
                }
            }

            Media::insert($insert);
        }

        return new JsonResponse(['message' => 'Success'], 200);
    }
}
