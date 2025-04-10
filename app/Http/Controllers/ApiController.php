<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiController extends Controller
{
    public function success($data = [], $message = 'Success', $code = Response::HTTP_OK)
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function error($message = 'Error', $code = Response::HTTP_BAD_REQUEST)
    {
        return response()->json([
            'status' => $code,
            'message' => $message,
        ], $code);
    }
}
