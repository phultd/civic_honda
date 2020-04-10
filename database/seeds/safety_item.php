<?php

use Illuminate\Database\Seeder;

class safety_item extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('safety_item')->delete();

		$items = [
			[
				"image" => "http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/s-safe/safe-img.jpg",
				"image_mobile" => "http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/s-safe/img-mb@2x.jpg",
	            "title" => "AN TOÀN TIÊN PHONG",
	            "description" => "Sự an toàn của người lái luôn là mối quan tâm hàng đầu của <br>Honda Với hệ thống an toàn chủ động và bị động vượt trội, <br>bạn hoàn toàn an tâm tận hưởng niềm vui cầm lái cùng Civic",
	        ],
			[
				"image" => "http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/s-safe/safe-img.jpg",
				"image_mobile" => "http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/s-safe/img-mb@2x.jpg",
	            "title" => "AN TOÀN TIÊN PHONG",
	            "description" => "Sự an toàn của người lái luôn là mối quan tâm hàng đầu của <br>Honda Với hệ thống an toàn chủ động và bị động vượt trội, <br>bạn hoàn toàn an tâm tận hưởng niềm vui cầm lái cùng Civic",
	        ],
			[
				"image" => "http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/s-safe/safe-img.jpg",
				"image_mobile" => "http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/s-safe/img-mb@2x.jpg",
	            "title" => "AN TOÀN TIÊN PHONG",
	            "description" => "Sự an toàn của người lái luôn là mối quan tâm hàng đầu của <br>Honda Với hệ thống an toàn chủ động và bị động vượt trội, <br>bạn hoàn toàn an tâm tận hưởng niềm vui cầm lái cùng Civic",
	        ]
		];

		foreach( $items as $item ) {
			DB::table('safety_item')->insert($item);
		}

    }
}
