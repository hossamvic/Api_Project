<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Domain;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $domains = Domain::all();
        if(count($domains) > 0 ){
            return ApiResponse::sendResponse(200 , "ALL Domains" , $domains);
        }else{
            return ApiResponse::sendResponse(200 , "Not Found" , []);
        }
    }
}
