<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreICImageRequest;
use App\Http\Requests\StoreICRequest;
use App\Http\Requests\UpdateICRequest;
use App\Http\Resources\ICResource;
use App\Http\Resources\ImageResource;
use App\Models\IC;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ICController extends Controller
{
    public function index()
    {
        $ics = IC::with(['mainImage', 'blogDiagram'])->get();
        if (count($ics) > 0) {
            return ApiResponse::sendResponse(200, 'Setting Retrieved Successfully', ICResource::collection($ics));
        }
        return ApiResponse::sendResponse(200, 'No Ics Found', []);
    }

    public function store(StoreIcRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['commName']);
        IC::create($data);
        return ApiResponse::sendResponse(201, 'IC Record Created Successfully', []);
    }

                    public function show(IC $ic)
                    {

                    }

    public function searchIC2(Request $request)
    {
        $query = $request->input('query');

        $ics = IC::with(['mainImage', 'blogDiagram', 'store'])
            ->where('commName', 'like', '%' . $query . '%')
            ->orWhere('name', 'like', '%' . $query . '%')
            ->orWhere('slug', 'like', '%' . $query . '%')
            ->paginate(1);

        if (count($ics) > 0) {
            return ApiResponse::sendResponse(200, 'Setting Retrieved Successfully', ICResource::collection($ics));
        }
        return ApiResponse::sendResponse(200, 'No Ics Found', []);
    }
    public function searchIC(Request $request)
    {
        $query = $request->input('query');

        $ics = IC::with(['mainImage', 'blogDiagram', 'store'])
            ->where('commName', 'like', '%' . $query . '%')
            ->orWhere('name', 'like', '%' . $query . '%')
            ->orWhere('slug', 'like', '%' . $query . '%')
            ->get();

        if (count($ics) > 0) {
            return ApiResponse::sendResponse(200, 'Setting Retrieved Successfully', ICResource::collection($ics));
        }
        return ApiResponse::sendResponse(200, 'No Ics Found', null);
    }
    public function update(UpdateICRequest $request, IC $ic)
    {

    }
    public function storeImage(StoreIcImageRequest $request)
    {
        $request->validated();

        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalName();
        $image->storeAs('images', $imageName, 'public');

        $image=Image::create([
            'url' => $imageName,
        ]);
        return ApiResponse::sendResponse(201,'Image Uploaded Successfully',new ImageResource($image));
    }
}
