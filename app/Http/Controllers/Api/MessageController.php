<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewMessageRequest;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(NewMessageRequest $request)
    {
        $data = $request->validated();
        $record = Message::create($data);
        if ($record) {
            return ApiResponse::sendResponse(201, 'Record created successfully.', []);
        }
        return ApiResponse::sendResponse(400, 'Unable to create record.', []);
    }
}
