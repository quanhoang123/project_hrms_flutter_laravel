<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laratrust\Models\LaratrustRole;


class Role extends LaratrustRole
{
    use HasFactory;
    protected $table='roles';
    protected $fillable=['name','display_name','description'];

    public $timestamps = true;
  

}
