<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoPhan extends Model
{
    use HasFactory;
    protected $table='bo_phans';
    protected $fillable=['ten'];
    public $timestamps = true;
    public function scopeGetByPhongBanId($query, $id)
    {
        return $query->where('phongban_id', $id);
    }
}
