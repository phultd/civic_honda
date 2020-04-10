<?php

use Illuminate\Database\Seeder;

class operation extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('operation')->delete();
        DB::table('operation')->insert([
			'id' => 1,
            'section_background' => 'http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/s-operation/img-left.jpg',
			'section_background_mobile' => 'http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/s-operation/img-left-mb@2x.jpg',
            'section_title' => 'VẬN HÀNH BỨT PHÁ',
			'section_description' => 'VTEC TURBO là thế hệ động cơ tăng áp mới đột phá của Honda giúp xe đạt được đồng thời hai yếu tố : khả năng vận hành mạnh mẽ và tiết kiệm nhiên liệu vượt trội - khắc phục được nhược điểm của động cơ tăng áp truyền thống.',
        ]);
    }
}
