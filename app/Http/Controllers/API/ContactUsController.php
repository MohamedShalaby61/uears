<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ContactUs;
use Validator;

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
          return response()->json(['message' => 'Youe message has been sent successfully']);
        }
    }
}
