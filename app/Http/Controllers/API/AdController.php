<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdResource;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdController extends Controller
{
    public function index(){
        $ads = Ad::latest()->paginate(10);
        if (count($ads) > 0 ){
            return ApiResponse::sendResponse(200 , "ALL Ads Here" , AdResource::collection($ads));
        }else{
            return ApiResponse::sendResponse(200 , "No Ads Found" , []);
        }
    }
    public function latest(){
        $ads = Ad::latest()->take(2)->get();
        if(count($ads) > 0){
            return ApiResponse::sendResponse(200 , 'Latest Ads' , AdResource::collection($ads));
        }else{
            return ApiResponse::sendResponse(200 , 'No Ads' , []);
        }
    }
    public function domain($domain_id){
        $ads = Ad::where('domain_id' , $domain_id)->latest()->get();
        if(count($ads) > 0){
            return ApiResponse::sendResponse(200 , 'Latest Ads in This Domain' , AdResource::collection($ads));
        }else{
            return ApiResponse::sendResponse(200 , 'No Ads' , []);
        }
    }
    public function search(Request $request){
        $query = $request->input('search');
        $ads = Ad::where('title' , 'like' , '%' . $query . '%')->get();
        if(count($ads) > 0){
            return ApiResponse::sendResponse(200 , 'Search Completed' , AdResource::collection($ads));
        }else{
            return ApiResponse::sendResponse(200 , 'No Ads' , []);
        }
    }
    public function create(Request $request){
     $data = $request->validate([
        'title' => 'required',
        'text' => 'required',
        'phone' => 'required',
        'domain_id' => 'required',
     ]);
     $data['user_id'] = $request->user()->id;
     $record = Ad::create($data);
     if($record){
        return ApiResponse::sendResponse(201 , 'Ad Uploaded Successfully' , $record);
     }else{
        return ApiResponse::sendResponse(200 , 'No Ads' , []);
     }
    }
    public function update(Request $request, $ad_id){
        $validatedData = $request->validate([
            'title' => 'required',
            'text' => 'required',
            'phone' => 'required',
            'domain_id' => 'required',
        ]);
        $ad = Ad::findOrFail($ad_id);
        if($ad->user_id != $request->user()->id){
            return ApiResponse::sendResponse(403 , 'Not Qulified' , []);
        }
        $ad->update($validatedData);
            return ApiResponse::sendResponse(201 , 'Ad Updated Successfully' , $ad);
    }
    public function delete(Request $request , $ad_id){
        $ad = AD::find($ad_id);
        if ($ad->user_id != $request->user()->id) {
            return ApiResponse::sendResponse(403, 'Not Qualified', []);
        }
        $ad->delete();
        return ApiResponse::sendResponse(200 , 'Data Deleted Successfully' , []);

    }
    public function myads(Request $request){
        $ad = Ad::where('user_id' , $request->user()->id)->get();
        if (count($ad) > 0){
            return ApiResponse::sendResponse(200 , 'ALL User Ads' , $ad);
        }else{
            return ApiResponse::sendResponse(200 , ' No Ads' , []);
        }
    }
}

