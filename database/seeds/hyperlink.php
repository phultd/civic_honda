<?php

use Illuminate\Database\Seeder;

class hyperlink extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('hyperlink')->delete();

        $items = [
            [
	            "key" => "test_drive",
	            "title" => "Đăng ký lái thử",
	            "url" => "https://www.honda.com.vn/",
                "icon" => "",
	            "icon_hover" => ""
	        ],
            [
                "key" => "download_catalog",
	            "title" => "Tải catalog",
	            "url" => "https://www.honda.com.vn/",
                "icon" => "",
	            "icon_hover" => ""
	        ],
            [
                "key" => "price_table",
	            "title" => "Bảng giá",
	            "url" => "https://www.honda.com.vn/",
                "icon" => "",
	            "icon_hover" => ""
	        ],
            [
                "key" => "cost_estimate",
	            "title" => "Dự toán chi phí",
	            "url" => "https://www.honda.com.vn/",
                "icon" => "",
	            "icon_hover" => ""
	        ],
            [
                "key" => "find_agency",
	            "title" => "Tìm đại lý",
	            "url" => "https://www.honda.com.vn/",
                "icon" => "",
	            "icon_hover" => ""
	        ],
            [
                "key" => "facebook",
                "title" => "Facebook",
                "url" => "https://www.facebook.com/",
                "icon" => "",
                "icon_hover" => ""
	        ],
            [
                "key" => "youtube",
	            "title" => "Youtube",
	            "url" => "https://www.youtube.com/",
                "icon" => "",
	            "icon_hover" => ""
	        ]
        ];

        foreach( $items as $item ) {
			DB::table('hyperlink')->insert($item);
		}
    }
}
