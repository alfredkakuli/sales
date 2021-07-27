<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RouteController extends Controller
{
    public function save_route(Request $request)
    {
        $route_name = $request->route_name;
        $route_number = $request->route_number;

        $profile_id = DB::table('profiles')->where('id', $request->profile_id)->first();
        if (!$profile_id) {
            $data = [
                "error" => 'The Employee Could not be found',
                "code" => '404',

            ];
        }
        if (!empty($route_name) && !empty($route_number) && !empty($profile_id)) {

            DB::table('routes')->insert([
                'route_name' => $route_name,
                'route_no' => $route_number,
                'profile_id' => $request->profile_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            $data = [
                "message" => 'The route added to the database successfully',
                "code" => '200',

            ];
        } else {
            $data = [
                "error" => 'Route Name and Number and Profile Number are required',
                "code" => '400',

            ];
        }
        return json_encode($data);
    }
}
