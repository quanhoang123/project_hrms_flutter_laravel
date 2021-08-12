<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UngTuyen extends Model
{
    use HasFactory;
    protected $table='dang_ky_ung_tuyen';

    protected $fillable=['nameEmp','gender','dienthoai','email','file_cv','address','position'];
    public $timestamps = true;
}
