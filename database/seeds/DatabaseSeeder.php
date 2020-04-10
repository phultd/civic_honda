<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
		$this->call([
            users::class,
            banner::class,
            message::class,
            exterior::class,
			exterior_category::class,
			exterior_item::class,
            interior::class,
			interior_category::class,
			interior_item::class,
            operation::class,
            operation_category::class,
            operation_item::class,
			utility::class,
            utility_category::class,
            utility_item::class,
            safety_item::class,
            accessory::class,
			accessory_category::class,
            accessory_item::class,
            specification::class,
            gallery_category::class,
            gallery_item::class,
            hyperlink::class,
        ]);

    }
}
