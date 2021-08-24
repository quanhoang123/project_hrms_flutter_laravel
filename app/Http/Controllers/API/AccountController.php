<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account=User::all();
        return $account;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return $roles;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6|max:32'
        ],[
            'name.required'     => 'Bạn chưa nhập "Họ tên"',
            'email.required'    => 'Bạn chưa nhập "Email"',
            'email.email'       => '"Email" không đúng định dạng',
            'email.unique'      => '"Email" người dùng đã tồn tại',
            'password.required' => 'Bạn chưa nhập "Mật khẩu"',
            'password.min'      => '"Mật khẩu" phải ít nhất 6 ký tự',
            'password.max'      => '"Mật khẩu" không quá 32 ký tự'
        ]);
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
      
        try{
            $user->save();
            $user->syncRoles($request->role);
            Log::info('Người dùng ID:'.Auth::user()->id.' đã thêm người dùng ID:'.$user->id);
            if($user !=null){
                return response()->json([
                    'message'=>'Account Created Successfully!!',
                    'role'=>$user,
                    'status'=>200,
                ]);
            }
        }
        catch(\Exception $e){
            Log::error($e);
            return response()->json([
                'message'=>'Do not create account !!',
                'status' => 100,
            ]);
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
        $user = User::where('id', $id)->with('roles')->first();
        return $user;
        // return $role->withRole($role)->withPermissions($permissions);   
    }
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    { 
        $roles = Role::all();
        return $roles;
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
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,'.$request->id,
            'password' => 'max:32' 
        ],[
            'name.required'    => 'Bạn chưa nhập "Họ tên"',
            'email.required'   => 'Bạn chưa nhập "Email"',
            'email.email'      => '"Email" không đúng định dạng',
            'email.unique'     => '"Email" người dùng đã tồn tại',
            'password.max'     => '"Mật khẩu" không quá 32 ký tự'
        ]);

        $user = User::findOrFail($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        if(!empty($request->password)){
            $user->password = bcrypt($request->password);
        }
        $user->active = $request->active;
        $image=$this->save_record_image($_FILES['image']);
        $user->avatar=$image['data']['url'];
        try{
            $user->save();
            $user->syncRoles($request->role);
            Log::info('Người dùng ID:'.Auth::user()->id.' đã chỉnh sửa người dùng id:'.$user->id);
            return response()->json([
                'message'=>'Account Created Successfully!!',
                'user'=>$user,
                'status'=>200,
            ]);
        }
        catch(\Exception $e){
            Log::error($e);
            return response()->json([
                'message'=>'Account do not created Successfully!!',
                'status' => 100,
            ]);
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if($user->id == Auth::user()->id){
            return response()->json([
                'status_danger'=>'Bạn không được xóa tài khoản của mình!',
                'status' => 100,
            ]);
            
        }else{
            try{
                $user->delete();
                Log::info('Người dùng ID:'.Auth::user()->id.' đã xóa người dùng id:'.$id);
                return response()->json([
                    'status_success'=>'Xóa người dùng thành công!',
                    'status' => 200,
                ]);
                
            }
            catch(\Exception $e){
                Log::error($e);
                return response()->json([
                    'status_error'=>'Xảy ra lỗi khi xóa người dùng!',
                    'status' => 500,
                ]);
            }
            
        }
    }
}
