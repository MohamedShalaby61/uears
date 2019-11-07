<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Faculty;
use Validator;

class FacultyController extends Controller
{

       public function insert_faculty(Request $request){ 
		     
		        $validator = Validator::make($request->all(), [ 
		            'name' => 'required', 
		            'image' => 'required|image', 
		            'info' => 'required|max:20', 
		            'description' => 'required',
		        ]);
		        
		        if ($validator->fails()) {          
		            return response()->json(['message'=>$validator->messages()->first()]);            
		        }
		        $input = $request->all();
		        if($request->hasFile('image')){
		            $input['image'] = $request->file('image');
		            $allowedfileExtension=['jpg','png','jpeg'];
		            $extension = $input['image']->getClientOriginalExtension();
		            $filename =pathinfo($input['image']->getClientOriginalName(), PATHINFO_FILENAME);
		            $filename = md5($filename . time()) .'.' . $extension;            
		            $check=in_array($extension,$allowedfileExtension);
		            if($check){
		                $path     = $input['image']->move(public_path("/storage") , $filename);
		                $fileURL  = url('/storage/'. $filename);
		                $input['image'] = $fileURL;
		                $faculty = Faculty::create($input);
		            }
		        }else{
		    	        $faculty = Faculty::create($input);
		        }
	        return response()->json([ 'message'=>'Faculty has been stored successfully']); 
       }


       public function all_faculities(){
       	  $faculties = Faculty::query()->select('name','image','info')->get();
       	  return response()->json(['all_faculities' => $faculties]);
       
       }

       public function get_faculty(Request $request){
       	 $faculty = Faculty::where('id' , $request->id)->first();
       	 return response()->json(['faculty' => $faculty]);
       }





	
}
