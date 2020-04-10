<?php

use Illuminate\Database\Seeder;

class gallery_category extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('gallery_category')->delete();

		$items = [
			[
	            "title" => "Hình ảnh ngoại thất",
	            "heading" => "ĐỊNH NGHĨA MỚI VỀ SỰ HOÀN MỸ",
	            "description" => "Vượt trên kiểu dáng phá cách , khả năng vận hành và những công nghệ hiện đại giúp Civic định nghĩa lại chuẩn mực cho phân khúc Compact Sedan.",
                'image' => 'http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/s-gallery/thumb.jpg',
                'order' => 1
	        ],
			[
	            "title" => "Hình ảnh nội thất",
	            "heading" => "ĐỊNH NGHĨA MỚI VỀ SỰ HOÀN MỸ",
	            "description" => "Vượt trên kiểu dáng phá cách , khả năng vận hành và những công nghệ hiện đại giúp Civic định nghĩa lại chuẩn mực cho phân khúc Compact Sedan.",
                'image' => 'http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/s-gallery/thumb.jpg',
                'order' => 1
	        ],
			[
	            "title" => "Video",
	            "heading" => "ĐỊNH NGHĨA MỚI VỀ SỰ HOÀN MỸ",
	            "description" => "Vượt trên kiểu dáng phá cách , khả năng vận hành và những công nghệ hiện đại giúp Civic định nghĩa lại chuẩn mực cho phân khúc Compact Sedan.",
                'image' => 'http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/s-gallery/thumb.jpg',
                'order' => 1
	        ]
		];

		foreach( $items as $item ) {
			DB::table('gallery_category')->insert($item);
		}

    }
}
