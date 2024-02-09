<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $cities = City::all() ;
        if($cities){
            return ApiResponse::sendResponse(200 , 'This ALL Cities' , $cities);
        }
        return ApiResponse::sendResponse(200 , 'Not Fonud This Id In The DataBase' ,[]);
    }
}
