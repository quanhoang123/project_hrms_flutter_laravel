<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PhongBansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seeder Phòng ban
        $phongbans = array(
            [
                'id'   => 1,
                'ten' => 'Kỹ Thuật'
            ],
            [
                'id'   => 2,
                'ten' => 'Dự Án'
            ],
            [
                'id'   => 3,
                'ten' => 'Tài Chính - Kế Toán'
            ],
            [
                'id'   => 4,
                'ten' => 'Hành Chính - Nhân Sự'
            ],
            [
                'id'   => 5,
                'ten' => 'Dev'
            ]
        );
        
        DB::table('phong_bans')->insert($phongbans);
        // Seeder Bộ phận
        $bophans = array(
            [
                'ten'        => 'DeSign',
                'phongban_id' => 1
            ],
            [
                'ten'        => 'Technical',
                'phongban_id' => 1
            ],
            [
                'ten'        => 'Maintant',
                'phongban_id' => 1
            ],
            [
                'ten'        => 'Store',
                'phongban_id' => 1
            ],
            [
                'ten'        => 'Accounting',
                'phongban_id' => 3
            ],
            [
                'ten'        => 'Customer Service',
                'phongban_id' => 3
            ],
            [
                'ten'        => 'Kho',
                'phongban_id' => 3
            ]
        );
        
        DB::table('bo_phans')->insert($bophans);
    }
}
