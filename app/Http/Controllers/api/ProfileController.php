<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function get_single_user_profile(Request $request, $id)
    {
        $user_profile = DB::table('profiles')->where('id', $id)->first();

        if ($user_profile) {
            $data = [
                'id' => $user_profile->id,
                'name' => $user_profile->first_name,
                'full_name' => $user_profile->first_name . " " . $user_profile->last_name,
                'first_name' => $user_profile->first_name,
                'last_name' => $user_profile->last_name,
            ];
            return json_encode($data);
        } else {
            return json_encode('The User with the provided id could not dbe found');
        }
    }

    public function save_user_profile(Request $request)
    {
        $first_name = $request->first_name;
        $last_name = $request->last_name;

        if (!empty($first_name) && !empty($last_name)) {
            DB::table('profiles')->insert([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            $data = [
                "message" => 'User Profile Added successfuly to the database',
                "code" => '200',

            ];

        } else {
            $data = [
                "error" => 'First Name and Last Name Required',
                "code" => '400',

            ];
        }
        return json_encode($data);
    }
}
