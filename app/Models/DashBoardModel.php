<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashBoardModel extends Model
{
    use HasFactory;
    protected $table= 'company';
    protected $fillable=['namecompany','address','phone'];
    public $timestamps = true;
}
