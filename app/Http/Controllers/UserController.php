<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function user(Request $request)
    {
        $data_select = [
            // Users
            'users.id',
            'users.name',
            'users.email',
            'users.email_verified_at',
            // UserData
            'user_data.profile_pic',
            'user_data.phone',
            'user_data.country',
            'user_data.city',
            'user_data.address',
            'user_data.gender',
            'user_data.site',
            // Country
            'countries.name as country_name',
        ];

        $user = User::query();
        // Where
        $user->where('users.id', $request->user()->id);
        // Selects
        $user->select($data_select);
        // Join
        $user->join('user_data', 'users.id', '=', 'user_data.user_id');
        $user->join('countries', 'user_data.country', '=', 'countries.iso2');
        return $user->first();
    }

    public function update(Request $request)
    {

        $updateUser = $request->only(
            'name',
            'email',
        );
        $updateData = $request->only(
            'phone',
            'country',
            'city',
            'address',
            'gender',
            'site',
        );

        $update = User::where('id', $request->id)->update($updateUser);

        if($update){
            $dataupdate = UserData::where('user_id', $request->id)->update($updateData);
            if ($dataupdate) {
                return new JsonResponse(['message' => 'User Successfully Updated'], 200);
            }
        }
        return new JsonResponse(['message' => 'Something went wrong'], 418);
    }
}
