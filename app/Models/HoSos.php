<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoSos extends Model
{
    use HasFactory;
    protected $table='ho_sos';
    protected $fillable=['ten'];
    public $timestamps = true;
}
