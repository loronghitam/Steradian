<?php

use Illuminate\Support\Facades\Response;

function ResponseSuccess($code, $status, $message, $data = []): \Illuminate\Http\JsonResponse
{
    $data = [
        'meta' =>
            [
                'code' => $code,
                'status' => $status,
                'message' => $message
            ],
        'data' => $data

    ];
    return Response::json($data, $code);
}

function ResponseError($code, $status, $message): \Illuminate\Http\JsonResponse
{
    $data = [
        'meta' =>
            [
                'code' => $code,
                'status' => $status,
                'message' => $message
            ],
    ];
    return Response::json($data, $code);
}

function uploadFile($file, $store)
{
    if ($file) {
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($store, $fileName, 'public');
    } else {
        $path = null;
    }
    return $path;
}

