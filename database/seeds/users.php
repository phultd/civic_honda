<?php

use Illuminate\Database\Seeder;

class users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('users')->delete();
        DB::table('users')->insert([
			'id' => 1,
            'username' => 'thinkclimaxadmin',
            'email' => 'bao.pham@thinkclimax.com',
            'password' => bcrypt('adminb123#'),
            'role' => '1',
			'name' => 'Bảo Phạm',
            'last_login' => date("Y-m-d H:i:s"),
            'last_password_changed' => date("Y-m-d H:i:s"),
            'locked_status' => '0',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('users')->insert([
            'username' => 'test',
            'email' => 'test@test.test',
            'password' => bcrypt('adminb123#'),
            'role' => '2',
			'name' => 'test',
            'last_login' => date("Y-m-d H:i:s"),
            'last_password_changed' => date("Y-m-d H:i:s"),
            'locked_status' => '0',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
		DB::table('users')->insert([
            'username' => 'yen.nguyen',
            'email' => 'yen.nguyen@thinkclimax.com',
            'password' => bcrypt('Admin123!@#'),
            'role' => '1',
			'name' => 'Yến Nguyễn',
            'last_login' => date("Y-m-d H:i:s"),
            'last_password_changed' => date("Y-m-d H:i:s"),
            'locked_status' => '0',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
		DB::table('users')->insert([
            'username' => 'hoanganh.nguyen',
            'email' => 'hoanganh.nguyen@thinkclimax.com',
            'password' => bcrypt('Admin123!@#'),
            'role' => '1',
			'name' => 'Hoàng Anh',
            'last_login' => date("Y-m-d H:i:s"),
            'last_password_changed' => date("Y-m-d H:i:s"),
            'locked_status' => '0',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
