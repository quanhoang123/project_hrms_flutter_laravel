<?php

use App\Models\NhanSu;
use App\Models\PhongBan;
use App\Models\User;

if(! function_exists('getTotalOfNumberStaff')){
        function getTotalOfNumberStaff($status){
            $total = 0;
            if($status == -1){
                $total = NhanSu::all()->count();
            }elseif($status == 0){
                $total = NhanSu::where('trang_thai', 0)->get()->count();
            }elseif($status == 1){
                $total = NhanSu::where('trang_thai', 1)->get()->count();
            }
    
            return $total;
        }
    }
    
    /*
     * Get tên phòng ban theo phongban_id
     * @phongban_id: string
     * 
     */
    if(! function_exists('getTenPhongBanById')){
        function getTenPhongBanById($phongban_id){
            if($phongban_id > 0){
                $tenphongban = PhongBan::findOrFail($phongban_id)->ten;
            }else{
                $tenphongban = '';
            }
            return $tenphongban;
        }
    }
    
    if(! function_exists('getTotalOfNumberUser')){
        function getTotalOfNumberUser($status){
            $total = 0;
            if($status == -1){
                $total = User::all()->count();
            }elseif($status == 0){
                $total = User::where('active', 0)->get()->count();
            }elseif($status == 1){
                $total = User::where('active', 1)->get()->count();
            }
    
            return $total;
        }
}
