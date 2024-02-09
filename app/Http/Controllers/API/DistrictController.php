<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\DistrictResource;
use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request )
    {
       $districts = District::where('city_id' , $request->input('city'))->get();
       if (count($districts) > 0) {
        return ApiResponse::sendResponse(200, 'Districts retrieved successfully', DistrictResource::collection($districts));
    }
    return ApiResponse::sendResponse(200, 'districts for this city is empty', []);
}
}
