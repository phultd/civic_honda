<?php

use Illuminate\Database\Seeder;

class utility extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('utility')->delete();
        DB::table('utility')->insert([
			'id' => 1,
            'section_background' => 'http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/s-utilities/img-left.jpg',
			'section_background_mobile' => 'http://demo.thinkclimax.com/hondaoto/honda-civic/dist/assets/images/s-utilities/img-left-mb@2x.jpg',
            'section_title' => 'CHINH PHỤC MỌI TRÁI TIM',
			'section_description' => 'Không gian nội thất của Civic đạt đến sự hoàn mỹ mà bất cứ ai cũng phải khao khát. Rộng rãi và tiện nghi nâng tầm , chât liệu cao cấp đáp ứng những khách hàng muốn tận hưởng sự thư giãn , sang trọng. Không gian thiết kế thể thao hay những trang bị giao tiếp thông minh mang đến cho chủ nhân cá tính những trải nghiệm đầy cảm hứng.',
        ]);
    }
}
