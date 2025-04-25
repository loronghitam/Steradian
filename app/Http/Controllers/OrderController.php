<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function get(Request $request)
    {
        try {
            $data = Order::all();
            return ResponseSuccess(200, 'Success', 'Success get all Order', $data);

        } catch (\Exception $exception) {
            return ResponseError(401, 'Error', 'Error get all Order');
        }
    }

    public function find($id)
    {
        try {
            $data = Order::find($id);
            return ResponseSuccess(200, 'Success', 'Success create Order', $data);

        } catch (\Exception $exception) {
            return ResponseError(401, 'Error', 'Error create order');
        }
    }

    public function create(Request $request)
    {
        $rules = [
            'dropoff_location' => 'required',
            'dropoff_date' => "required",
            'pickup_date' => "required",
            'pickup_location' => "required",
            'car_id' => "required"
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return ResponseError(422, 'error', $validator->errors());
        }
        try {
            $data = Order::create([
                'order_date' => now(),
                'dropoff_location' => $request->dropoff_location,
                'dropoff_date' => $request->dropoff_date,
                'pickup_date' => $request->pickup_date,
                'pickup_location' => $request->pickup_location,
                'car' => $request->car_id
            ]);
            return ResponseSuccess(200, 'Success', 'Success create Order', $data);
        } catch (\Exception $exception) {
            return ResponseError(401, 'Error', 'Error create Order');

        }
    }

    public function update($id, Request $request)
    {
        $rules = [
            'dropoff_location' => 'required',
            'dropoff_date' => "required",
            'pickup_date' => "required",
            'pickup_location' => "required",
            'car_id' => "required"
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return ResponseError(422, 'error', $validator->errors());
        }

        try {
            $data = Order::find($id);
            $data->update([
                'order_date' => now(),
                'dropof_location' => $request->dropoff_location,
                'dropoff_date' => $request->dropoff_date,
                'pickup_date' => $request->pickup_date,
                'pickup_location' => $request->pickup_location,
                'car' => $request->car_id
            ]);
            return ResponseSuccess(200, 'Success', $data);
        } catch (\Exception $exception) {
            return ResponseError(401, 'Error', 'Error update Order');
        }
    }

    public function destroy($id)
    {
        try {
            $data = Order::where('id', $id)->delete();
            return ResponseSuccess(200, 'Success', 'Success create Order');

        } catch (\Exception $exception) {
            return ResponseError(401, 'Error', 'Error delete order');
        }
    }
}
