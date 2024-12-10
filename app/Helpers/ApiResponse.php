<?php

namespace App\Helpers;

class ApiResponse
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    static function sendResponse($code = 200, $message = null, $data= null)
    {
        $response = [
            'code' => $code,
            'message' => $message,
            'data' => $data
        ];
        return response()->json($response, $code);
    }
}
