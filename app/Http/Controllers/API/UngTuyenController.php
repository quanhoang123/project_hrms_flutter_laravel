<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UngTuyen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UngTuyenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ung_tuyen=UngTuyen::all();
        return response()->json([
            "success" => true,
            "message" => "List Ung Cu Vien",
            "data" => $ung_tuyen,
        ]);
    }


    function getTotalOfNumberStaff($status){
        $total = 0;
        if($status == -1){
            $total = UngTuyen::all()->count();
        }elseif($status == 0){
            $total = UngTuyen::where('status', 0)->get()->count();
        }elseif($status == 1){
            $total = UngTuyen::where('status', 1)->get()->count();
        }
        return $total;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            "nameEmp" =>"required",
            "gender" => "required",
            "dienthoai"=>"required",
            "email"=>"required",
            "file_cv"=>"required",
            "file_cv"=>'mimes:jpeg,jpg,png,gif|max:10000',
            "address"=>"required",
            "position"=>"required"   
        ],
        [
            'nameEmp.required'=>'Vui lòng nhập tên đối tác',
            'file_cv.required'=>'Vui lòng chọn ảnh',
        ]);

        if($validator->fails()) {
            return response()->json(["status" => "failed", "message" => "validation_error", "errors" => $validator->errors()]);
        }
      
        $data=array();
        $data['nameEmp'] = $request->nameEmp;
        $data['gender']=$request->gender;
        $data['dienthoai']=$request->dienthoai;
        $data['email']=$request->email;
        $data['address']=$request->address;
        $image=$this->save_record_image($_FILES['image']);
        $data['file_cv']=$image['data']['url'];
        $data['position']=$request->position;
        $enroll=UngTuyen::create($data);
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
        $ung_tuyen = UngTuyen::find($id);
        if (is_null($ung_tuyen)) {
        return $this->sendError('Bai Dang not found.');
        }
        return response()->json([
        "success" => true,
        "message" => "Ung cu vien retrieved successfully.",
        "data" => $ung_tuyen
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ung_tuyen=UngTuyen::findOrFail($id);
        
        $validator=Validator::make($request->all(), [
            "nameEmp" =>"required",
            "gender" => "required",
            "dienthoai"=>"required",
            "email"=>"required",
            "file_cv"=>"required",
            "file_cv"=>'mimes:jpeg,jpg,png,gif|max:10000',
            "address"=>"required",
            "position"=>"required"   
        ],
        [
            'nameEmp.required'=>'Vui lòng nhập tên đối tác',
            'file_cv.required'=>'Vui lòng chọn ảnh',
        ]);

        if($validator->fails()) {
            return response()->json(["status" => "failed", "message" => "validation_error", "errors" => $validator->errors()]);
        }
     
        $ung_tuyen->nameEmp= $request->nameEmp;
        $ung_tuyen->dienthoai=$request->dienthoai;
        $ung_tuyen->gender=$request->gender;
        $ung_tuyen->address=$request->address;
        $image=$this->save_record_image($_FILES['image']);
        $ung_tuyen->file_cv=$image['data']['url'];
        $ung_tuyen->position=$request->position;
        $ung_tuyen->save();
        
        if(!is_null($ung_tuyen)) {
            return response()->json(["status" => $this->status_code, "success" => true, "message" => "Bai Viet completed successfully", "data" => $ung_tuyen]);
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
        $ung_tuyen = UngTuyen::findOrFail($id);
        $ung_tuyen->delete();
        return response()->json(null, 204);
    }
}
