<?php

use Illuminate\Database\Seeder;

class message extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('message')->delete();
        DB::table('message')->insert([
			'id' => 1,
            'section_title' => 'KỶ NGUYÊN CIVIC, <br> KỶ NGUYÊN CỦA BỨT PHÁ',
			'section_description' => 'Khi mọi xu hướng đã trở nên củ kỹ và bão hoà, hãy phá vỡ nó bằng những định luật riêng của bạn.<br> Với Civic mới , bạn hoàn toàn có đủ quyền năng và sự kiêu hãnh để bứt phá , kiến tạo và dẫn đầu xu hướng.',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
