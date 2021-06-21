<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;

class OtpController extends Controller
{
	public function userEmailVerify(Request $request){
		try{
			if(!empty($request->email)){
		        $user = User::where('email',$request->email)->first();
		        if(!empty($user)){
		        	$token =rand(10,100000);
		        	$user->otp_verified_token = $token;
		        	$user = User::where('email',$request->email)->update(['otp_verified_token'=>$token]);		        	
		        	return response()->json(array(
		                "status" => true,
		                "message" =>"Check Otp",
		                "otp"=>$token
		            ), 200);
		        }else{
		        	return response()->json(array(
		                "status" => false,
		                "errors" =>"User not exists"
		            ), 400);
		        }		           

			}else{
				return response()->json(array(
	                "status" => false,
	                "errors" =>"Email field is required"
	            ), 400);
			}

		} catch(Exception $e){
    		return response()->json(array(
                "status" => 400,
                "errors" => $e->getMessage(),
                "message"=>$e->getMessage(),
            ), 400);

    	}      
        
	}

	public function userOtpVerify(Request $request){
		try{
			if(!empty($request->email) && !empty($request->otp)){
		        $user = User::where('email',$request->email)->where('otp_verified_token',$request->otp)->first();
		        if(!empty($user)){		        	
		        	$user = User::where('email',$request->email)->update(['otp_verified_token'=>'']);		        	
		        	return response()->json(array(
		                "status" => true,
		                "message" =>"Succesfully verify otp"
		            ), 200);
		        }else{
		        	return response()->json(array(
		                "status" => false,
		                "errors" =>"Invalid otp"
		            ), 400);
		        }		           

			}else{
				return response()->json(array(
	                "status" => false,
	                "errors" =>"Invalid otp"
	            ), 400);
			}

		} catch(Exception $e){
    		return response()->json(array(
                "status" => 400,
                "errors" => $e->getMessage(),
                "message"=>$e->getMessage(),
            ), 400);

    	}      
        
	}
    
}
