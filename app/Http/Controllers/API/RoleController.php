<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role=Role::all();
        return $role;
           
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return $permissions->withPermissions($permissions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'display_name' => 'required|max:255',
            'name' => 'required|max:100|alpha_dash|unique:roles,name',
            'description' => 'sometimes|max:255',
        ]);

        $role = new Role();
        $role->display_name = $request->display_name;
        $role->name = $request->name;
        $role->description = $request->description;
        $role->save();
        
        if($request->permissions){
            $role->syncPermissions($request->permissions);
        }
        if($role !=null){
            return response()->json([
                'message'=>'Account Created Successfully!!',
                'role'=>$role->display_name,
                'status'=>200,
            ]);
        }
        else{
            return response()->json([
                'message'=>'Account do not created Successfully!!',
                'role'=>$role,
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
        $role = Role::where('id',$id)->with('permissions')->first();
        $permissions = Permission::all();
        return response()->json([
            'role'=>$role,
            'permission'=>$permissions,
            'status'=>200,
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
        $role = Role::where('id',$id)->with('permissions')->first();
        $permissions = Permission::all();
        return response()->json([
            'role'=>$role,
            'permission'=>$permissions,
            'status'=>200,
        ]);
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
        $this->validate($request, [
            'display_name' => 'required|max:255',
            'description' => 'sometimes|max:255',
        ]);

        $role = Role::findOrFail($id);
        $role->display_name = $request->display_name;
        $role->description = $request->description;
        $role->save();

        if($request->permissions){
            $role->syncPermissions($request->permissions);
        }
        if($role !=null){
            return response()->json([
                'message'=>'Role Created Successfully!!',
                'role'=>$role->display_name,
                'status'=>200,
            ]);
        }
        else{
            return response()->json([
                'message'=>'Account do not created Successfully!!',
                'status' => 100,
            ]);
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
        $user = Role::findOrFail($id);

        if($user->id == Auth::user()->id){
            return redirect()->route('user.index')->with('status_danger', 'Bạn không được xóa tài khoản của mình!');
        }else{
            try{
                $user->delete();
                Log::info('Người dùng ID:'.Auth::user()->id.' đã xóa người dùng id:'.$id);
                return response()->json([
                    'message'=>'Xóa người dùng thành công!!!',
                    'status'=>200,
                ]);   
            }
            catch(\Exception $e){
                Log::error($e);
                return response()->json([
                    'message'=>'Xảy ra lỗi khi xóa người dùng!',
                    'status'=>200,
                ]);  
            }
            
        }
    }
}
