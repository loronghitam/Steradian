<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarRequestCreate;
use App\Http\Resources\CarCollection;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use function Laravel\Prompts\error;

class CarController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/cars",
     *     tags={"Cars"},
     *     summary="Create a new car",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"car_name","day_rate","month_rate","image"},
     *                 @OA\Property(property="car_name", type="string", example="Toyota Camry"),
     *                 @OA\Property(property="day_rate", type="string", example="50"),
     *                 @OA\Property(property="month_rate", type="string", example="1000"),
     *                 @OA\Property(property="image", type="string", format="binary", description="Car image file"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Car created successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function create(CarRequestCreate $request)
    {
        try {
            $imagePath = uploadFile($request->file('image'), 'cars');
            $dataCar = Car::create([
                'car_name' => $request->car_name,
                'day_rate' => $request->day_rate,
                'month_rate' => $request->month_rate,
                'image' => $imagePath
            ]);
        } catch (\Exception $exception) {
            return ResponseError(500, 'Error', 'Server Error');
        }
        return ResponseSuccess(201, 'Success', 'Success create car', $dataCar);
    }

    /**
     * @OA\Patch(
     *     path="/api/cars/{id}",
     *     tags={"Cars"},
     *     summary="Update a car",
     *     @OA\Parameter(
     *          name="id",
     *          in="query",
     *          description="Id car's",
     *          required=true,
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"car_name","day_rate","month_rate","image"},
     *                 @OA\Property(property="car_name", type="string", example="Toyota Camry"),
     *                 @OA\Property(property="day_rate", type="string", example="50"),
     *                 @OA\Property(property="month_rate", type="string", example="1000"),
     *                 @OA\Property(property="image", type="string", format="binary", description="Car image file"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ok."
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="Data not found."
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error."
     *     )
     * )
     */
    public function update($id, Request $request)
    {
        try {
            if (!Str::isUuid($id)) {
                return ResponseError(404, 'Error', 'Data not found');
            }
            $data = Car::find($id);
            $imagePath = $data->image;
            if ($request->file('image')) {
                $imagePath = uploadFile($request->file('image'), 'cars');
            }
            $data->update([
                'car_name' => $request->car_name,
                'day_rate' => $request->day_rate,
                'month_rate' => $request->month_rate,
                'image' => $imagePath
            ]);
        } catch (\Exception $exception) {
            return ResponseSuccess(500, 'Error', 'Internal server error.');
        }
        return ResponseSuccess(200, 'Success', 'Success update car', $data);
    }

    /**
     * @OA\Get(
     *     path="/api/cars",
     *     tags={"Cars"},
     *     summary="Update a car",
     *     @OA\Response(
     *         response=200,
     *         description="List car"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function get()
    {
        try {
            $data = Car::latest('created_at')->paginate();
        } catch (\Exception $exception) {
            return ResponseError(401, 'Error', 'Error get users data');
        }
//        return ResponseSuccess(200, 'Success', 'Success Get Users Data', $data);
        return ResponseSuccess(200, 'Success', 'Success Get Users Data', new CarResource($data));
    }

    /**
     * @OA\Get(
     *     path="/api/cars/{id}",
     *     tags={"Cars"},
     *     summary="Update a car",
     *     @OA\Parameter(
     *            name="id",
     *            in="query",
     *            description="Id car's",
     *            required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List car"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function find($id)
    {
        try {
            if (!Str::isUuid($id)) {
                return ResponseError(404, 'Error', 'Data not found');
            }
            $data = Car::find($id);
        } catch (\Exception $exception) {
            return ResponseError(401, 'Error', 'Error find car');
        }
        return ResponseSuccess(200, 'Success', 'Success find car', $data);
    }

    /**
     * @OA\Delete(
     *     path="/api/cars/{id}",
     *     tags={"Cars"},
     *     summary="Update a car",
     *     @OA\Parameter(
     *            name="id",
     *            in="query",
     *            description="Id car's",
     *            required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List car"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            if (!Str::isUuid($id)) {
                return ResponseError(404, 'Error', 'Data not found');
            }
            $data = Car::find($id);
            $data->delete();
        } catch (\Exception $exception) {
            return ResponseError(401, 'Error', 'Error delete car');
        }
        return ResponseSuccess(200, 'Success', 'Success delete car');
    }
}
