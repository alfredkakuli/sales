<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TransactionController extends Controller
{
    public function save_transaction(Request $request)
    {
        $route_id = $request->route_id;
        $total_amount = $request->total_amount;
        $check_route_exists = DB::table('routes')->where('id', $route_id)->first();
        if (!$check_route_exists) {
            $data = [
                "error" => 'The Provided Route Could not be found',
                "code" => '404',

            ];
        }

        if (!empty($route_id) && !empty($total_amount)) {

            DB::table('transactions')->insert([
                'route_id' => $route_id,
                'total_amount' => $total_amount,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            $data = [
                "message" => 'The Transaction added to the database successfully',
                "code" => '200',

            ];
        } else {
            $data = [
                "error" => 'Transaction  Route Number and Total Amount are required',
                "code" => '400',

            ];
        }
        return json_encode($data);
    }

    public function get_transaction(Request $request)
    {

        if (empty($request->route_id)) {

            $sales = DB::table('routes')
                ->join('profiles', 'routes.profile_id', '=', 'profiles.id')
                ->select('routes.id as route_id', 'routes.*', 'profiles.*')
                ->get()
                ->toArray();


            $sales = Route::with('salessummary')->get();

            if ($sales) {
                $sales_summary = 0;


                foreach ($sales as $sale) {
                    $transaction = DB::table('transactions')->where('route_id', $sale->route_id)
                        ->sum('total_amount');
                    $sales_summary = $sales_summary + $transaction;
                }

                $data=[
                    'data'=>[
                        'salesman'=>$sales,
                    ],
                ];
                return json_encode($data);
            };
        }

        $transaction = DB::table('transactions')->where('route_id', $request->route_id)->first();

        if ($transaction) {


            $sales = DB::table('routes')
                ->join('profiles', 'routes.profile_id', '=', 'profiles.id')
                ->select('routes.id as route_id', 'routes.*', 'profiles.*')
                ->first();

            $sales_summary = $transaction = DB::table('transactions')->where('route_id', $request->route_id)
                ->sum('total_amount');

            $data = [
                'salesman' => [
                    'route_id' => $sales->route_id,
                    'route_name' => $sales->first_name,
                    'route_no' => $sales->route_no,
                ],

                'sales_summary' => $sales_summary,
            ];




            // $route_data = [
            //     'route_id' => $sales->route_id,
            //     'route_name' => $sales->first_name,
            //     'route_no' => $sales->route_no,
            // ];

            // $sales_summary = [
            //     'total_amount' => $sales->total_amount,
            // ];

            // $salesman = [
            //     'route_id' => $sales->route_id,
            //     'route_name' => $sales->first_name,
            //     'route_no' => $sales->route_no,
            //     'sales_summary' => $sales_summary,
            // ];


            // $data = [
            //     'salesman' => $salesman,
            // ];

            return json_encode($data);
        }
    }
}
