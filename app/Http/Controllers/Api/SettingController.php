<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\SettingsResource;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
//        need to add administration edit method later
        $setting = Setting::find(1);
        if ($setting) {
            return ApiResponse::sendResponse(200,'Setting Retrieved Successfully',new SettingsResource($setting));
        }
        return ApiResponse::sendResponse(200,'Setting NOT Found',[]);
    }
}
