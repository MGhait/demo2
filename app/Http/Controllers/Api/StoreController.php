<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\StoreResource;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $stores = Store::all();
        if (count($stores) > 0) {
            return ApiResponse::sendResponse(200, 'Stores Retrieved Successfully', StoreResource::collection($stores));
        }
        return ApiResponse::sendResponse(200, 'No stores were found',[]);
    }
}
