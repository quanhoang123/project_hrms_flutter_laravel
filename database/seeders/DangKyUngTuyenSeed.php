<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DangKyUngTuyenSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employee=array(
            [
                'id'=>1,
                'nameEmp'=>'Hoang Trung Quan',
                'gender'=>true,
                'dienthoai'=>'0355739816',
                'email'=>'hoangtrungquan2001@gmail.com',
                'file_cv'=>'https://www.coolfreecv.com/images/cv_templates_with_photo.jpg',
                'address'=>'101b Le Huu Trac, Son Tra , Da Nang',
                'position'=>'Dev Developer',
                'status'=>true,
                'created_at'=>null,
                'updated_at'=>null
            ]
        );
        DB::table('dang_ky_ung_tuyen')->insert($employee);
    }
}
