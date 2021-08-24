<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BoPhan;
use App\Models\HopDong;
use App\Models\HoSos;
use App\Models\LoaiHopDong;
use App\Models\LoaiQuyetDinh;
use App\Models\NhanSu;

use App\Models\PhongBans;
use App\Models\QuyetDinh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Rap2hpoutre\FastExcel\FastExcel;
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee=NhanSu::all();
        return $employee;
    }
    

    public function read($id)
    {
        $nhan_su = NhanSu::findOrFail($id);
        return response()->json([
            'nhan_su' => $nhan_su,
            'ds_hop_dong'   => HopDong::getByNhanSuId($id)->get(),
            'ds_quyet_dinh' => QuyetDinh::getByNhanSuId($id)->get()
        ]);
    }

    // AJAX function
    public function dsBoPhanTheoPhongBan(Request $request)
	{
		
		return response()->json(BoPhan::getByPhongBanId($request->phongban_id)->get());
    }
    // END AJAX

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json([
            'ds_phong_ban' => PhongBans::all(),
            'ds_ho_so' => HoSos::all()
        ]);
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
            'ma_nv'        => 'unique:nhan_sus',
            'so_cmnd'        => 'unique:nhan_sus'
        ],[
            'ma_nv.unique' => '"Mã nhân viên" đã tồn tại',
            'so_cmnd.unique' => '"Số CMND" đã tồn tại'
        ]);
      
        try{
            $nhan_su = NhanSu::saveNhanSu(0, $request->all());
            Log::info('Người dùng ID:'.Auth::user()->id.' đã thêm nhân sự ID:'.$nhan_su->id.'-'.$nhan_su->ho_ten);
                return response()->json([
                    'message'=>'Employee Created Successfully!!',
                    'employee'=>$nhan_su,
                    'status'=>200,
                ]);      
            
        }
        catch(\Exception $e){
            Log::error($e);
            return response()->json([
                'message'=>'Employee do not created Successfully!!',
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
        $total = NhanSu::all()->count();
        return $total; 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json([
            'nhan_su'       => NhanSu::findOrFail($id), 
            'ds_phong_ban'  => PhongBans::all(),
            'ds_ho_so'      => HoSos::all()->pluck('ten','id'),
            'ds_hop_dong'   => HopDong::getByNhanSuId($id)->get(),
            'ds_loai_hd'    => LoaiHopDong::all(),
            'ds_quyet_dinh' => QuyetDinh::getByNhanSuId($id)->get(),
            'ds_loai_qd'    => LoaiQuyetDinh::all()
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
        $request->validate([
            'ma_nv'        => 'unique:nhan_sus,ma_nv,'.$id,
            'so_cmnd'        => 'unique:nhan_sus,so_cmnd,'.$id
        ],[
            'ma_nv.unique' => '"Mã nhân viên" đã tồn tại',
            'so_cmnd.unique' => '"Số CMND" đã tồn tại'
        ]);

        try{
            $nhan_su = NhanSu::saveNhanSu($id, $request->all());
            Log::info('Người dùng ID:'.Auth::user()->id.' đã sửa nhân sự ID:'.$nhan_su->id.'-'.$nhan_su->ho_ten);
            return response()->json([
                'message'=>'Employee Created Successfully!!',
                'employee'=>$nhan_su,
                'Admin'=>Auth::user()->name,
                'status'=>200,
            ]);      
        
        }
        catch(\Exception $e){
            Log::error($e);
            return response()->json([
                'message'=>'Employee do not created Successfully!!',
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
        $nhan_su = NhanSu::findOrFail($id);
        $name = $nhan_su->ho_ten;
        try{
            $nhan_su->delete();
            Log::info('Người dùng ID:'.Auth::user()->id.' đã xóa nhân sự id:'.$id.'-'.$name);
            return response()->json([
                'message'=>'Delete Employee Successfully!!',
                'employee'=>$nhan_su,
                'status'=>200,
            ]);      
        }
        
        catch(\Exception $e){
            Log::error($e);
            return response()->json([
                'message'=>'Employee do not delete !!',
                'status' => 100,
            ]);
        }
    }
}
