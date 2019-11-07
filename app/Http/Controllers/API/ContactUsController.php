<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ContactUs;
use Validator;

    /**
     * @OA\Post(
     *     path="/contactus",
     *     @OA\Parameter(
     *         name="name",
     *         in="path",
     *         description="Contact - username",
     *         required=true,
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="path",
     *         description="Contact - user email",
     *         required=true,
     *     ),
     *     @OA\Parameter(
     *         name="subject",
     *         in="path",
     *         description="subject",
     *         required=true,
     *     ),
     *     @OA\Parameter(
     *         name="message",
     *         in="path",
     *         description="your message",
     *         required=true,
     *     ),
     *     @OA\Response(response="200", description="when required fields is not added the response returns validation error , if the message was sent successfully it will return json success message")
     * )
    */

class ContactUsController extends Controller
{
    public function store(Request $request){
        $data = Validator::make($request->all(),[
            'name' => 'max:255',
            'email' => 'max:255|email|required',
            'message' => 'required',
            'subject' => 'required|max:255',
        ]);

        if($data->fails()){
          	 return response()->json(['message' => $data->messages()->first()]);
        }else{
        	$arrayData = $request->all();
	        ContactUs::create($arrayData);
          return response()->json(['message' => 'Your message has been sent successfully']);
        }
    }
}
