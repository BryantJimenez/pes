<?php

use Illuminate\Database\Seeder;

class ZipsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $zips = [
            ['id' => 1, 'name' => '54474', 'slug' => '54474', 'state' => '1'],
            ['id' => 2, 'name' => '54414', 'slug' => '54414', 'state' => '1'],
            ['id' => 3, 'name' => '54407', 'slug' => '54407', 'state' => '1'],
            ['id' => 4, 'name' => '54467', 'slug' => '54467', 'state' => '1'],
            ['id' => 5, 'name' => '54417', 'slug' => '54417', 'state' => '1'],
            ['id' => 6, 'name' => '54402', 'slug' => '54402', 'state' => '1'],
            ['id' => 7, 'name' => '54405', 'slug' => '54405', 'state' => '1'],
            ['id' => 8, 'name' => '54400', 'slug' => '54400', 'state' => '1'],
            ['id' => 9, 'name' => '54469', 'slug' => '54469', 'state' => '1'],
            ['id' => 10, 'name' => '54476', 'slug' => '54476', 'state' => '1'],
            ['id' => 11, 'name' => '54473', 'slug' => '54473', 'state' => '1'],
            ['id' => 12, 'name' => '54460', 'slug' => '54460', 'state' => '1'],
            ['id' => 13, 'name' => '54466', 'slug' => '54466', 'state' => '1'],
            ['id' => 14, 'name' => '54416', 'slug' => '54416', 'state' => '1'],
            ['id' => 15, 'name' => '54413', 'slug' => '54413', 'state' => '1'],
            ['id' => 16, 'name' => '54435', 'slug' => '54435', 'state' => '1'],
            ['id' => 17, 'name' => '54430', 'slug' => '54430', 'state' => '1'],
            ['id' => 18, 'name' => '54448', 'slug' => '54448', 'state' => '1'],
            ['id' => 19, 'name' => '54459', 'slug' => '54459', 'state' => '1'],
            ['id' => 20, 'name' => '54410', 'slug' => '54410', 'state' => '1'],
            ['id' => 21, 'name' => '54463', 'slug' => '54463', 'state' => '1'],
            ['id' => 22, 'name' => '54539', 'slug' => '54539', 'state' => '1'],
            ['id' => 23, 'name' => '54434', 'slug' => '54434', 'state' => '1'],
            ['id' => 24, 'name' => '54457', 'slug' => '54457', 'state' => '1'],
            ['id' => 25, 'name' => '54409', 'slug' => '54409', 'state' => '1'],
            ['id' => 26, 'name' => '54408', 'slug' => '54408', 'state' => '1'],
            ['id' => 27, 'name' => '54475', 'slug' => '54475', 'state' => '1'],
            ['id' => 28, 'name' => '54464', 'slug' => '54464', 'state' => '1'],
            ['id' => 29, 'name' => '54439', 'slug' => '54439', 'state' => '1'],
            ['id' => 30, 'name' => '54449', 'slug' => '54449', 'state' => '1'],
            ['id' => 31, 'name' => '54455', 'slug' => '54455', 'state' => '1'],
            ['id' => 32, 'name' => '54420', 'slug' => '54420', 'state' => '1'],
            ['id' => 33, 'name' => '54440', 'slug' => '54440', 'state' => '1'],
            ['id' => 34, 'name' => '54470', 'slug' => '54470', 'state' => '1'],
            ['id' => 35, 'name' => '54477', 'slug' => '54477', 'state' => '1'],
            ['id' => 36, 'name' => '54424', 'slug' => '54424', 'state' => '1'],
            ['id' => 37, 'name' => '54425', 'slug' => '54425', 'state' => '1'],
            ['id' => 38, 'name' => '54426', 'slug' => '54426', 'state' => '1'],
    	];
    	DB::table('zips')->insert($zips);
    }
}
