<?php

use Illuminate\Database\Seeder;

class interior_item extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('interior_item')->delete();

		$items = [
			[
                "category" => 1,
                "title" => "Nội thất",
                "image" => "http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/popup/front.jpg",
	            "description" => "Mặt trước xe nổi bật với thanh crom hình cánh chim kết nối với hai bên cụm đèn trước tạo nên phong cách mạnh mẽ đầy khí thế.",
                "order" => 1
	        ],
            [
                "category" => 1,
                "title" => "Nội thất",
                "image" => "http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/popup/front.jpg",
	            "description" => "Mặt trước xe nổi bật với thanh crom hình cánh chim kết nối với hai bên cụm đèn trước tạo nên phong cách mạnh mẽ đầy khí thế.",
                "order" => 1
	        ],
            [
                "category" => 1,
                "title" => "Nội thất",
                "image" => "http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/popup/front.jpg",
	            "description" => "Mặt trước xe nổi bật với thanh crom hình cánh chim kết nối với hai bên cụm đèn trước tạo nên phong cách mạnh mẽ đầy khí thế.",
                "order" => 1
	        ],
            [
                "category" => 1,
                "title" => "Nội thất",
                "image" => "http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/popup/front.jpg",
	            "description" => "Mặt trước xe nổi bật với thanh crom hình cánh chim kết nối với hai bên cụm đèn trước tạo nên phong cách mạnh mẽ đầy khí thế.",
                "order" => 1
	        ]
		];

		foreach( $items as $item ) {
			DB::table('interior_item')->insert($item);
		}

    }
}
