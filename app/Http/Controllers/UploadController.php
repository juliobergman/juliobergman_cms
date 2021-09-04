<?php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\UserData;
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

    public function avatar(Request $request)
    {

        // Validation
        $this->validate($request, [
            'image' => 'required',
            'image.*' => 'mimes:png,jpg,jpeg'
        ]);
        $user_id = $request->user()->id;
        // $user_id = 1;

        // Delete Old Avatar
        $oldpath = UserData::select('profile_pic')->where('user_id', $user_id)->first();
        $deletepath = str_replace('/storage/', '/public/', $oldpath->profile_pic);
        $factory = strstr($deletepath, '/factory/');
        if(!$factory){
            Storage::delete($deletepath);
        };
        // Upload New Avatar
        $file = $request->file('image');
        $original_filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $random_number = rand(1,5000);
        $hash = hash('md5', $original_filename.time().$random_number);

        $ext = 'jpg';
        $img = Image::make($file->getRealPath());
        $name = $hash.'.'.$ext;
        $path = storage_path('app/public/avatars/'.$user_id.'/'.$name);
        $img->fit(800, 800, function ($constraint) {
            $constraint->upsize();
        });
        $img->save($path, 60, $ext);
        $newpath = '/storage/avatars/'.$user_id.'/'.$name;
        $update = array('profile_pic' => $newpath);
        UserData::where('user_id', $user_id)->update($update);
        // Response
        return new JsonResponse(['message' => 'Success', 'path' => $newpath], 200);

    }
}
