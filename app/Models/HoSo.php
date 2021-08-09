<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoSo extends Model
{
    use HasFactory;
    public static function getNameById($id){
        $ho_so = HoSo::findOrFail($id);
        return $ho_so->ten;
    }
}
