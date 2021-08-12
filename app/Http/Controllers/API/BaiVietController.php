<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DangBai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BaiVietController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $baiviet=DangBai::all();
        return response()->json([
            "success" => true,
            "message" => "Bai Dang List",
            "data" => $baiviet,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    private $status_code=200;
    public function store(Request $request)
    {
        $validator=Validator::make($request->all(), [
            "title" =>"required",
            "content" => "required",
            "image"=>"required",
            
        ]);

        if($validator->fails()) {
            return response()->json(["status" => "failed", "message" => "validation_error", "errors" => $validator->errors()]);
        }
        $user = Auth::user()->id;
        
        $data=array();
        $data['title'] = $request->title;
        $data['content']=$request->content;
        $image=$this->save_record_image($_FILES['image']);
        $data['image']=$image['data']['url'];
    	$data['role_id']=$user;
        $enroll=DangBai::create($data);
        if(!is_null($enroll)) {
            return response()->json(["status" => $this->status_code, "success" => true, "message" => "Bai Viet completed successfully", "data" => $enroll]);
        }
        else {
            return response()->json(["status" => "failed", "success" => false, "message" => "failed to Post Bai Viet"]);
        }
  
    }
    public function save_record_image($image, $name = null)
    {
        $API_KEY = '9e962aa8399148137e861fe113518504';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.imgbb.com/1/upload?key=' . $API_KEY);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
        $file_name = ($name) ? $name . '.' . $extension : $image['name'];
        $data = array('image' => base64_encode(file_get_contents($image['tmp_name'])), 'name' => $file_name);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            return 'Error:' . curl_error($ch);
            curl_close($ch);
        } else {
            return json_decode($result, true);
            curl_close($ch);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = DangBai::find($id);
        if (is_null($student)) {
        return $this->sendError('Bai Dang not found.');
        }
        return response()->json([
        "success" => true,
        "message" => "Bai Dang retrieved successfully.",
        "data" => $student
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //'image'=>'mimes:jpeg,jpg,png,gif|max:10000'
    public function update(Request $request, $id)
    {
        $data_baiviet=DangBai::findOrFail($id);
        
        $validator=Validator::make($request->all(), [
            "title" =>"required",
            "content" => "required",
            "image"=>"required",
            
        ]);

        if($validator->fails()) {
            return response()->json(["status" => "failed", "message" => "validation_error", "errors" => $validator->errors()]);
        }
        $user = Auth::user()->id;
    
        $data_baiviet->title = $request->title;
        $data_baiviet->content=$request->content;
        $image=$this->save_record_image($_FILES['image']);
        $data_baiviet->image=$image['data']['url'];  
    	$data_baiviet->role_id=$user;

      
        $data_baiviet->save();
        
        if(!is_null($data_baiviet)) {
            return response()->json(["status" => $this->status_code, "success" => true, "message" => "Bai Viet completed successfully", "data" => $data_baiviet]);
        }
        else {
            return response()->json(["status" => "failed", "success" => false, "message" => "failed to Post Bai Viet"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $article = DangBai::findOrFail($id);
        $article->delete();
        return response()->json(null, 204);
    }
}
