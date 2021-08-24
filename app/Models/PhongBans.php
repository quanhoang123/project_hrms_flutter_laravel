<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhongBans extends Model
{
    use HasFactory;
    protected $table="phong_bans";
    public $timestamps = true;
}
