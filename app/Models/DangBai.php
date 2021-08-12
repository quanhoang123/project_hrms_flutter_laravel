<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DangBai extends Model
{
    use HasFactory;
    protected $table='dang_bai_viet';
    protected $fillable=['title','content','image'];
    public $timestamps = true;
}
