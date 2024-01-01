<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Catch_;

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
}
