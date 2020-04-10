<?php

use Illuminate\Database\Seeder;

class exterior extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('exterior')->delete();
        DB::table('exterior')->insert([
			'id' => 1,
            'section_background' => 'http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/s-exterior/img-left.png',
			'section_background_mobile' => 'http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/s-exterior/img-left-mb@2x.jpg',
            'section_title' => 'ĐỊNH NGHĨA MỚI VỀ SỰ HOÀN MỸ',
			'section_description' => 'Civic thế hệ mới được phát triển trên tinh thần “OTOKOMAE”.<br>Đẹp không đơn thuần chỉ là một dáng vẻ bên ngoài cuốn hút.',
        ]);
    }
}
