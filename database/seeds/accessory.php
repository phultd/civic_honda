<?php

use Illuminate\Database\Seeder;

class accessory extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('accessory')->delete();
        DB::table('accessory')->insert([
			'id' => 1,
            'section_background' => 'http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/s-interior/img-left.jpg',
			'section_background_mobile' => 'http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/s-interior/img-left-mb@2x.jpg',
            'section_title' => 'PHỤ KIỆN TUỲ CHỌN CHÍNH HÃNG',
			'section_description' => 'Bạn có thể lựa chọn những phụ kiện trang trí giúp cho Civic sở hữu phong cách thể thao nổi bật hay sang trọng cá tính và trang bị thêm những chi tiết giúp cho hành trình trở nên tiện lợi và hữu dụng',
        ]);
    }
}
