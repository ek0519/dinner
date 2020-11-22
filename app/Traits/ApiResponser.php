<?php

namespace App\Traits;


trait ApiResponser
{
    protected function successResponse($data, $code = 200, $message=null)
    {
        return response()->json([
            'status'=> $code,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function errorResponse($code, $message = null)
    {
        return response()->json([
            'status'=> $code,
            'message' => $message,
            'data' => null
        ], $code);
    }
}
