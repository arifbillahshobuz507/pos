<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\OTPMail;
use App\Helper\JWTToken;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Catch_;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function UserRegistration(Request $request){
        // user create best way 

        try{
            User::create(
                $request->input()
            );
            return response()->json([
                "status" => "success",
                "message" => "User Registration Successfully.",
            ], 201);

        }catch(Exception $messageexception){
            return response()->json([
                "status" => "Failed",
                "message" => "User Registration Failed for". $messageexception->getMessage(),
            ], 200);
        }

        // user crate way but this is not standard way
        // try{
        //     $data = User::create([
        //         'firstName'=> $request->input('firstName'),
        //         'lastName'=> $request->input('lastName'),
        //         'email'=> $request->input('email'),
        //         'mobail'=> $request->input('mobail'),
        //         'password'=> $request->input('password')
        //     ]);
        //     return response()->json([
        //         "status"=> "success",
        //         "data" =>  $data,
        //         "message"=> "User Registration Successfully.",
        //     ]);
        // }catch(Exception $exception){
        //     return response()->json([
        //         "status"=> "Failed",
        //         "message"=> "User Registration Failed" .$exception->getMessage()
        //     ], 200);
        // }
    }

    function UserLogin(Request $request): object
    {
        $count = User::where('email', '=', $request->input('email'))
            ->where('password', '=', $request->input('password'))
            ->count();

        if ($count == 1) {
            $token = JWTToken::CreateToken($request->input('email'));
            return response()->json([
                'status' => 'Success',
                'message' => 'User Login Successfully',
                'token' => $token
            ]);
        } else {
            return response()->json([
                'status' => 'Failed',
                'message' => 'User Login Failed'
            ]);
        }
    }

    public function SendOTPCode(Request $request){
        $email = $request->input("email");
        $otp = rand(100000, 999999);

        $count = User::where('email', '=', $email)->count();
        
        if($count == 1){
            //otp email address
          Mail::to($email)->send(new OTPMail($otp));
          // otp code table update
          User::where('email', '=', $email)->update(['otp'=>$otp]);  
          return response()->json([
            'status' => 'Success',
            'message' => '6 digit otp code has been send your mail',
        ]);
        }else{
            return response()->json([
                'status' => 'Failed',
                'message' => 'User Login Failed'
            ]);
        }
    }

}
