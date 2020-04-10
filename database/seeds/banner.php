<?php

use Illuminate\Database\Seeder;

class banner extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('banner')->delete();
        DB::table('banner')->insert([
			'id' => 1,
            'banner' => 'http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/s-intro/top-banner.jpg',
            'banner_mobile' => 'http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/s-intro/top-banner-mb@2x.jpg',
            'popup_type' => 'image',
			'popup_image' => 'http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/popup/img-banner.jpg',
            'popup_video' => '',
            'explore_link' => 'https://www.honda.com.vn/',
            'trial_link' => 'https://www.honda.com.vn/',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
