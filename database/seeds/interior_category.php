<?php

use Illuminate\Database\Seeder;

class interior_category extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('interior_category')->delete();

		$items = [
			[
	            "title" => "Buồng lái",
	            "heading" => "ĐỊNH NGHĨA MỚI VỀ SỰ HOÀN MỸ",
	            "description" => "Civic thế hệ mới được phát triển trên tinh thần “OTOKOMAE”.<br>Đẹp không đơn thuần chỉ là một dáng vẻ bên ngoài cuốn hút.",
                'image' => 'http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/s-interior/img-left.jpg',
    			'image_mobile' => 'http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/s-interior/img-left-mb@2x.jpg',
                'order' => 1
	        ],
			[
	            "title" => "Tiện nghi",
	            "heading" => "ĐỊNH NGHĨA MỚI VỀ SỰ HOÀN MỸ",
	            "description" => "Civic thế hệ mới được phát triển trên tinh thần “OTOKOMAE”.<br>Đẹp không đơn thuần chỉ là một dáng vẻ bên ngoài cuốn hút.",
                'image' => 'http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/s-interior/img-left.jpg',
    			'image_mobile' => 'http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/s-interior/img-left-mb@2x.jpg',
                'order' => 1
	        ]
		];

		foreach( $items as $item ) {
			DB::table('interior_category')->insert($item);
		}

    }
}
