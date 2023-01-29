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

        $sampleuser = sampleUser::create([
            'email' => $email
        ]);

        if($sampleuser){
            Mail::to($email)->send(new MailMessage($email));
            return new JsonResponse(
                [
                    'success' => true,
                    'message' => 'Thank you for registering your account, Please check your inbox'
                ], 200
            );
        }

    }
}
