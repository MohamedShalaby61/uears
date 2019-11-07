<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\OauthAccessToken;
use Validator;

class UserController extends Controller
{

    /**
	 * @OA\Info(title="User login and register", version="0.1")
	 */

	/**
	 * @OA\Post(
	 *     path="/login",
	 *     @OA\Parameter(
     *         name="email",
     *         in="path",
     *         description="user registered email",
     *         required=true,
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="path",
     *         description="user Password",
     *         required=true,
     *     ),
	 *     @OA\Response(response="200", description="login with email and password")
	 * )
    */

    public function login(Request $request){

        if(auth()->attempt(['email'=>$request->email,'password'=>$request->password])){
            return response()->json(['Success'=>'Successfully Logged in !!']);
        }else{
            return response()->json(['Failed'=>'Login Failed !!']);
        } 
    }
    
    
    /**
	 * @OA\Post(
	 *     path="/register",
	 *     @OA\Parameter(
     *         name="name",
     *         in="path",
     *         description="user registered email",
     *         required=true,
     *     ),
	 *     @OA\Parameter(
     *         name="email",
     *         in="path",
     *         description="user registered email",
     *         required=true,
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="path",
     *         description="user Password",
     *         required=true,
     *     ),
     *     @OA\Parameter(
     *         name="phone_number",
     *         in="path",
     *         description="user registered email",
     *         required=true,
     *     ),
     *     @OA\Parameter(
     *         name="DOB",
     *         in="path",
     *         description="user registered email",
     *         required=true,
     *     ),
	 *     @OA\Response(response="200", description="Register a new user with the above params")
	 * )
    */



    public function register(Request $request){
       $validator = Validator::make($request->all(),[
       'name'=>'required',
       'email'=>'required|unique:users',
       'password'=>'required',
       'phone_number'=>'required|max:15',
       'gender_id'=>'required|integer',
       'DOB'=>'required|date_format:Y-m-d|before:today'
       ]);

       if($validator->fails()){
       	 return response()->json(['message' => $validator->messages()->first()]);
       }else{
       	$data = $request->all();
       	$data['password'] = bcrypt($request->password);
       	User::create($data);
     	return response()->json(['message' => 'Registered Successfully']);
       }

    }

}
