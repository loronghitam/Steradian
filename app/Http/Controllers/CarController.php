<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarRequest;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CarController extends Controller
{
    public function create(CarRequest $request)
    {
        try {
            $imagePath = uploadFile($request->file('image'), 'cars');
            $dataCar = Car::create([
                'car_name' => $request->car_name,
                'day_rate' => $request->day_rate,
                'month_rate' => $request->month_rate,
                'image' => $imagePath
            ]);
        } catch (ValidationException $exception) {
            return ResponseError(400, 'Error', $exception->getMessage());
        }
        return ResponseSuccess(200, 'Success', 'Success create car', $dataCar);
    }

    public function update($id, Request $request)
    {
        $rules = [
            'car_name' => 'required|string',
            'day_rate' => 'required|numeric',
            'month_rate' => 'required|numeric',
            'image' => 'required|image',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return ResponseError(422, 'error', $validator->errors());
        }

        try {
            $data = Car::find($id);
            $imagePath = uploadFile($request->file('image'), 'cars');
            $data->update([
                'car_name' => $request->car_name,
                'day_rate' => $request->day_rate,
                'month_rate' => $request->month_rate,
                'image' => $imagePath
            ]);
        } catch (\Exception $exception) {
            return ResponseSuccess(200, 'Error', 'Error update car');
        }
        return ResponseSuccess(200, 'Success', 'Success update car', $data);
    }

    public function get()
    {
        try {
            $data = Car::latest('created_at')->paginate();
            return ResponseSuccess(200, 'Success', 'Success Get Users Data', $data);
        } catch (\Exception $exception) {
            return ResponseError(401, 'Error', 'Error get users data');
        }
    }

    public function find($id)
    {
        try {
            $data = Car::find($id);
            return ResponseSuccess(200, 'Success', 'Success find car', $data);
        } catch (\Exception $exception) {
            return ResponseError(401, 'Error', 'Error find car');
        }
    }

    public function destroy($id)
    {
        try {
            $data = Car::find($id);
            $data->delete();
            return ResponseSuccess(200, 'Success', 'Success delete car');
        } catch (\Exception $exception) {
//            return ResponseError(401, 'Error', 'Error delete car');
            return ResponseError(401, 'Error', 'Error delete car');
        }
    }
}
