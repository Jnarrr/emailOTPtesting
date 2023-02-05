<?php

namespace App\Http\Controllers;

use App\Mail\MailMessage;
use App\Models\sampleUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class sampleUserController extends Controller
{
    public function sendMail(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|unique:sample_users'
        ]);

        if ($validator->fails()){
            return new JsonResponse(
                [
                    'success' => false, 
                    'message' => $validator->errors() 
                ], 422);
        }

        $email = $request->all()['email'];
        $otp = rand(100000,999999); //add

        $sampleuser = sampleUser::create([
            'email' => $email,
            'otp' => $otp //add
        ]);

        if($sampleuser){
            Mail::to($email)->send(new MailMessage($email, $otp)); // add $otp
            return new JsonResponse(
                [
                    'success' => true,
                    'message' => 'Thank you for registering your account, Please check your inbox'
                ], 200
            );
        }
    }

    public function verifyEmail(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|max:191',
            'otp' => 'required|max:191'
        ]);

        if ($validator->fails()){
            return new JsonResponse(
                [
                    'success' => false, 
                    'message' => $validator->errors() 
                ], 422);
        }

        $user = sampleUser::where([['email','=',$request->email],['otp','=',$request->otp]])->first();
        if($user){
            sampleUser::where('email','=',$request->email)->update(['otp' => '000000', 'is_verified' => 'true']);

            return response(["status" => 200, "message" => "Success"]);
        }
        else{
            return response(["status" => 401, 'message' => 'Invalid']);
        }
    }
}
