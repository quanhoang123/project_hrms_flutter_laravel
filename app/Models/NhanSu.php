<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhanSu extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $table ='nhan_sus';
    protected $fillable=['ma_nv','ho_ten','gioi_tinh','ngay_sinh','so_cmnd','ngay_cap_cmnd','noi_cap_cmnd','dia_chi_thuong_tru','dia_chi_lien_he','dien_thoai','email','trinh_do','truong_tot_nghiep','nam_tot_nghiep','ngay_bat_dau_lam','ngay_lam_viec_cuoi','chuc_danh','phongban_id','bophan_id','chung_chi','hoso_id','trang_thai'];
    /**
     * Get the phongban for the nhansu.
     */
    public function phongbans()
    {
        return $this->belongsTo(PhongBans::class, 'phongban_id');
    }

    /**
     * Get the bophan for the nhansu.
     */
    public function bophans()
    {
        return $this->belongsTo(BoPhan::class, 'bophan_id');
    }

    /**
     * Save nhân sự
     * -1  : Import
     *  0  : Add
     * $id : Edit
     */
    public static function saveNhanSu($id, $data){
        if($id == 0 || $id == -1){
            $nhan_su = new NhanSu;
        }else{
            $nhan_su = NhanSu::findOrFail($id);
            $nhan_su->trang_thai     = $data['trang_thai'];
        }
        $nhan_su->ma_nv              = $data['ma_nv'];
        $nhan_su->ho_ten             = $data['ho_ten'];
        $nhan_su->dia_chi_thuong_tru = $data['dia_chi_thuong_tru'];
        $nhan_su->dia_chi_lien_he    = $data['dia_chi_lien_he'];
        $nhan_su->dien_thoai         = $data['dien_thoai'];
        $nhan_su->email              = $data['email'];
        $nhan_su->gioi_tinh          = $data['gioi_tinh'];
        $nhan_su->ngay_sinh          = Carbon::parse($data['ngay_sinh'])->format('Y-m-d');
        $nhan_su->so_cmnd            = $data['so_cmnd'];
        if($data['ngay_cap_cmnd'] != null){
            $nhan_su->ngay_cap_cmnd      = Carbon::parse($data['ngay_cap_cmnd'])->format('Y-m-d');
        }else{
            $nhan_su->ngay_cap_cmnd      = null;
        }
        
        $nhan_su->noi_cap_cmnd       = $data['noi_cap_cmnd'];
        if($data['ngay_bat_dau_lam'] != null){
            $nhan_su->ngay_bat_dau_lam   = Carbon::parse($data['ngay_bat_dau_lam'])->format('Y-m-d');
        }else{
            $nhan_su->ngay_bat_dau_lam   = null;
        }
        
        if($data['ngay_lam_viec_cuoi'] != null){
            $nhan_su->ngay_lam_viec_cuoi   = Carbon::parse($data['ngay_lam_viec_cuoi'])->format('Y-m-d');
        }else{
            $nhan_su->ngay_lam_viec_cuoi   = null;
        }
        $nhan_su->trinh_do           = $data['trinh_do'];
        $nhan_su->truong_tot_nghiep  = $data['truong_tot_nghiep'];
        $nhan_su->nam_tot_nghiep     = $data['nam_tot_nghiep'];
        $nhan_su->chung_chi          = $data['chung_chi'];
        $nhan_su->chuc_danh          = $data['chuc_danh'];
        $nhan_su->phongban_id        = $data['phongban_id'];
        $nhan_su->bophan_id          = $data['bophan_id'];
        if($id == -1){
            $nhan_su->hoso_id        = $data['hoso_id'];
        }else{
            if(!empty($data['hoso_id'])){
                $nhan_su->hoso_id        = $data['hoso_id'];
            }else{
                $nhan_su->hoso_id        = null;
            }
        }
        
        $nhan_su->save();
        return $nhan_su;
    }

    public function getNgaySinhAttribute($value)
    {
        return Carbon::parse($value)->format('d-m-Y');
    }

    public function getNgayCapCmndAttribute($value)
    {
        if($value != null){
            return Carbon::parse($value)->format('d-m-Y');
        }
        return null;
    }

    public function getNgayBatDauLamAttribute($value)
    {
        if($value != null){
            return Carbon::parse($value)->format('d-m-Y');
        }
        return null;
    }

    public function getNgayLamViecCuoiAttribute($value)
    {
        if($value != null){
            return Carbon::parse($value)->format('d-m-Y');
        }
        return null;
    }
}
