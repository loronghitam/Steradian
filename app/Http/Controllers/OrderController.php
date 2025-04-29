<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderCreateRequest;
use App\Http\Requests\OrderRequesCreateRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/orders",
     *     tags={"Orders"},
     *     summary="List order.",
     *     @OA\Response(
     *         response=200,
     *         description="Ok."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error."
     *     )
     * )
     */
    public function get()
    {
        try {
            $data = Order::latest('created_at')->paginate();
            return ResponseSuccess(200, 'Success', 'Success get all Order.', $data);

        } catch (\Exception $exception) {
            return ResponseError(500, 'Error', 'Internal server error.');
        }
    }

    /**
     * @OA\Get(
     *     path="/api/orders/{id}",
     *     tags={"Orders"},
     *     summary="Show order",
     *     @OA\Parameter(
     *           name="id",
     *           in="query",
     *           description="Id order",
     *           required=true,
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Ok."
     *     ),
     *     @OA\Response(
     *          response=404,
     *          description="Not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function find($id)
    {
        try {
            if (!Str::isUuid($id)) {
                return ResponseError(404, 'Error', 'Data not found');
            }
            $data = Order::find($id);
        } catch (\Exception $exception) {
            return ResponseError(500, 'Error', 'Internal server error.');
        }
        return ResponseSuccess(200, 'Success', 'List Order.', $data);
    }

    /**
     * @OA\Post(
     *     path="/api/orders",
     *     tags={"Orders"},
     *     summary="Create a new Order",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"dropoff_location","dropoff_date","pickup_date","pickup_location", "car_id"},
     *                 @OA\Property(property="dropoff_location", type="string", example="1"),
     *                 @OA\Property(property="pickup_location", type="string", example="2"),
     *                 @OA\Property(property="dropoff_date", type="date", example="2025-12-12"),
     *                 @OA\Property(property="pickup_date", type="date", example="2025-12-12"),
     *                 @OA\Property(property="car_id", type="string"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Created"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request."
     *     ),
     *     @OA\Response(
     *            response=404,
     *            description="Data not found."
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error."
     *      ),
     * )
     */
    public function create(OrderCreateRequest $request)
    {
        try {
            $data = Order::create([
                'order_date' => now(),
                'dropoff_location' => $request->dropoff_location,
                'dropoff_date' => $request->dropoff_date,
                'pickup_date' => $request->pickup_date,
                'pickup_location' => $request->pickup_location,
                'car_id' => $request->car_id
            ]);
        } catch (\Exception $exception) {
            return ResponseError(401, 'Error', 'Internal server error.');
        }
        return ResponseSuccess(201, 'Success', 'Success create Order', $data);
    }

    /**
     * @OA\Patch(
     *     path="/api/orders/{id}",
     *     tags={"Orders"},
     *     summary="Update order",
     *     @OA\Parameter(
     *             name="id",
     *             in="query",
     *             description="ID order",
     *             required=true,
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"dropoff_location","dropoff_date","pickup_date","pickup_location", "car_id"},
     *                 @OA\Property(property="dropoff_location", type="string", example="Toyota Camry"),
     *                 @OA\Property(property="dropoff_date", type="string", example="50"),
     *                 @OA\Property(property="pickup_date", type="string", example="2"),
     *                 @OA\Property(property="pickup_location", type="string", example="1"),
     *                 @OA\Property(property="car_id", type="string", example="123"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Ok."
     *     ),
     *     @OA\Response(
     *           response=404,
     *           description="Data not fount."
     *     ),
     *     @OA\Response(
     *            response=400,
     *            description="Bad request."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error."
     *     )
     * )
     */
    public function update($id, OrderUpdateRequest $request)
    {
        try {
            if (!Str::isUuid($id)) {
                return ResponseError('404', 'Error', 'Data not found');
            }
            $data = Order::find($id);
            $data->update([
                'order_date' => now(),
                'dropoff_location' => $request->dropoff_location ?? $data->dropoff_location,
                'dropoff_date' => $request->dropoff_date ?? $data->dropoff_date,
                'pickup_date' => $request->pickup_date ?? $data->dropoff_date,
                'pickup_location' => $request->pickup_location ?? $data->pickup_location,
                'car_id' => $request->car_id
            ]);
        } catch (\Exception $exception) {
            return ResponseError(500, 'Error', 'Internal ');
        }
        return ResponseSuccess(200, 'Success', $data);
    }

    /**
     * @OA\Delete(
     *     path="/api/orders/{id}",
     *     tags={"Orders"},
     *     summary="Delete order",
     *     @OA\Parameter(
     *             name="id",
     *             in="query",
     *             description="Id Order",
     *             required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Ok."
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data not found."
     *     ),
     *     @OA\Response(
     *          response=500,
     *          description="Internal server error."
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            if (!Str::isUuid($id)) {
                return ResponseError(404, 'error', 'Data not found.');
            }
            $data = Order::where('id', $id)->delete();
            return ResponseSuccess(200, 'Success', 'Success delete Order.');

        } catch (\Exception $exception) {
            return ResponseError(500, 'Error', 'Internal server error.');
        }
    }
}
