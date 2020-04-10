<?php

use Illuminate\Database\Seeder;

class gallery_item extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('gallery_item')->delete();

		$items = [
			[
                "category" => 1,
				"type" => 'image',
                "image" => "http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/popup/front.jpg",
	            "video" => "tiTspPHwPUY",
                "order" => 1
	        ],
			[
                "category" => 1,
				"type" => 'video',
                "image" => "http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/popup/front.jpg",
	            "video" => "tiTspPHwPUY",
                "order" => 1
	        ],
			[
                "category" => 1,
				"type" => 'image',
                "image" => "http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/popup/front.jpg",
	            "video" => "tiTspPHwPUY",
                "order" => 1
	        ],
			[
                "category" => 2,
				"type" => 'image',
                "image" => "http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/popup/front.jpg",
	            "video" => "tiTspPHwPUY",
                "order" => 1
	        ],
			[
                "category" => 2,
				"type" => 'video',
                "image" => "http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/popup/front.jpg",
	            "video" => "tiTspPHwPUY",
                "order" => 1
	        ],
			[
                "category" => 2,
				"type" => 'image',
                "image" => "http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/popup/front.jpg",
	            "video" => "tiTspPHwPUY",
                "order" => 1
	        ],
			[
                "category" => 3,
				"type" => 'image',
                "image" => "http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/popup/front.jpg",
	            "video" => "tiTspPHwPUY",
                "order" => 1
	        ],
			[
                "category" => 3,
				"type" => 'video',
                "image" => "http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/popup/front.jpg",
	            "video" => "tiTspPHwPUY",
                "order" => 1
	        ],
			[
                "category" => 3,
				"type" => 'image',
                "image" => "http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/popup/front.jpg",
	            "video" => "tiTspPHwPUY",
                "order" => 1
	        ]
		];

		foreach( $items as $item ) {
			DB::table('gallery_item')->insert($item);
		}

    }
}
