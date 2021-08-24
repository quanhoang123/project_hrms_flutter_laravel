<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoSos extends Model
{
    use HasFactory;
    public static function getNameById($id){
        $ho_so = HoSos::findOrFail($id);
        return $ho_so->ten;
    }
}
