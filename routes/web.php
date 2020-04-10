<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*******************************************************************************
*   ADMIN AUTHENTICATION ROUTES
*******************************************************************************/
Route::group([
	'middleware' => ['guest', 'throttle:60,1'],
    'prefix' => 'admincp',
    'as' => 'admincp.',
], function () {
	/* Login */
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
	Route::post('login', 'Auth\LoginController@login');
});

Route::group([
	'middleware' => ['auth'],
    'prefix' => 'admincp',
    'as' => 'admincp.',
], function () {
	/* Registration	*/
	Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
	Route::post('register', 'Auth\RegisterController@register');

	/* Log out */
	Route::post('logout', 'Auth\LoginController@logout')->name('logout');

	/* Change Password */
	Route::get('password/change', '\App\AdmincpController@show_change_password_form')->name('password.change');
	Route::patch('password/change', '\App\AdmincpController@change_password');

	/* User Management */
	Route::group([
		'middleware' => ['can_register']
	], function () {
		Route::get('user', '\App\AdmincpController@user_list')->name('user.list');
		Route::get('user/{user}', '\App\AdmincpController@user_edit')->name('user.edit');
		Route::post('user/{user}', '\App\AdmincpController@user_save')->name('user.save');
		Route::patch('user/{user}', '\App\AdmincpController@user_lock')->name('user.lock');
		Route::delete('user/{user}', '\App\AdmincpController@user_delete')->name('user.delete');
	});
});



/*******************************************************************************
*   ADMIN CONTROL PANEL ROUTES
*******************************************************************************/
Route::group([
	'middleware' => ['auth', 'password_not_expired'],
	'prefix' => 'admincp',
    'as' => 'admincp.',
], function () {
    /* Dashboard */
    Route::get('/', '\App\AdmincpController@index')->name('index');

	/* Banner */
	Route::get('banner', '\App\AdmincpController@banner_edit')->name('banner.edit');
	Route::post('banner', '\App\AdmincpController@banner_update')->name('banner.update');

	/* Message */
	Route::get('message', '\App\AdmincpController@message_edit')->name('message.edit');
	Route::post('message', '\App\AdmincpController@message_update')->name('message.update');

	/***************************************************************************/
	/* Exterior */
	Route::get('exterior', '\App\ExteriorController@exterior_edit')->name('exterior.edit');
	Route::post('exterior', '\App\ExteriorController@exterior_update')->name('exterior.update');
	/* Exterior Category */
	Route::get('exterior/new', '\App\ExteriorController@exterior_add_category')->name('exterior.add.category');
	Route::post('exterior/new', '\App\ExteriorController@exterior_save_category')->name('exterior.save.category');
	Route::get('exterior/{category}', '\App\ExteriorController@exterior_edit_category')->name('exterior.edit.category');
	Route::post('exterior/{category}', '\App\ExteriorController@exterior_update_category')->name('exterior.update.category');
	Route::delete('exterior/{category}', '\App\ExteriorController@exterior_delete_category')->name('exterior.delete.category');
	/* Exterior Item */
	Route::get('exterior/{category}/new', '\App\ExteriorController@exterior_add_item')->name('exterior.add.item');
	Route::post('exterior/{category}/new', '\App\ExteriorController@exterior_save_item')->name('exterior.save.item');
	Route::get('exterior/{category}/{item}', '\App\ExteriorController@exterior_edit_item')->name('exterior.edit.item');
	Route::post('exterior/{category}/{item}', '\App\ExteriorController@exterior_update_item')->name('exterior.update.item');
	Route::delete('exterior/{category}/{item}', '\App\ExteriorController@exterior_delete_item')->name('exterior.delete.item');

	/***************************************************************************/
	/* Interior */
	Route::get('interior', '\App\InteriorController@interior_edit')->name('interior.edit');
	Route::post('interior', '\App\InteriorController@interior_update')->name('interior.update');
	/* Interior Category */
	Route::get('interior/new', '\App\InteriorController@interior_add_category')->name('interior.add.category');
	Route::post('interior/new', '\App\InteriorController@interior_save_category')->name('interior.save.category');
	Route::get('interior/{category}', '\App\InteriorController@interior_edit_category')->name('interior.edit.category');
	Route::post('interior/{category}', '\App\InteriorController@interior_update_category')->name('interior.update.category');
	Route::delete('interior/{category}', '\App\InteriorController@interior_delete_category')->name('interior.delete.category');
	/* Interior Item */
	Route::get('interior/{category}/new', '\App\InteriorController@interior_add_item')->name('interior.add.item');
	Route::post('interior/{category}/new', '\App\InteriorController@interior_save_item')->name('interior.save.item');
	Route::get('interior/{category}/{item}', '\App\InteriorController@interior_edit_item')->name('interior.edit.item');
	Route::post('interior/{category}/{item}', '\App\InteriorController@interior_update_item')->name('interior.update.item');
	Route::delete('interior/{category}/{item}', '\App\InteriorController@interior_delete_item')->name('interior.delete.item');

	/***************************************************************************/
	/* Operation */
	Route::get('operation', '\App\OperationController@operation_edit')->name('operation.edit');
	Route::post('operation', '\App\OperationController@operation_update')->name('operation.update');
	/* Operation Category */
	Route::get('operation/new', '\App\OperationController@operation_add_category')->name('operation.add.category');
	Route::post('operation/new', '\App\OperationController@operation_save_category')->name('operation.save.category');
	Route::get('operation/{category}', '\App\OperationController@operation_edit_category')->name('operation.edit.category');
	Route::post('operation/{category}', '\App\OperationController@operation_update_category')->name('operation.update.category');
	Route::delete('operation/{category}', '\App\OperationController@operation_delete_category')->name('operation.delete.category');
	/* Operation Item */
	Route::get('operation/{category}/new', '\App\OperationController@operation_add_item')->name('operation.add.item');
	Route::post('operation/{category}/new', '\App\OperationController@operation_save_item')->name('operation.save.item');
	Route::get('operation/{category}/{item}', '\App\OperationController@operation_edit_item')->name('operation.edit.item');
	Route::post('operation/{category}/{item}', '\App\OperationController@operation_update_item')->name('operation.update.item');
	Route::delete('operation/{category}/{item}', '\App\OperationController@operation_delete_item')->name('operation.delete.item');

	/***************************************************************************/
	/* Utility */
	Route::get('utility', '\App\UtilityController@utility_edit')->name('utility.edit');
	Route::post('utility', '\App\UtilityController@utility_update')->name('utility.update');
	/* Utility Category */
	Route::get('utility/new', '\App\UtilityController@utility_add_category')->name('utility.add.category');
	Route::post('utility/new', '\App\UtilityController@utility_save_category')->name('utility.save.category');
	Route::get('utility/{category}', '\App\UtilityController@utility_edit_category')->name('utility.edit.category');
	Route::post('utility/{category}', '\App\UtilityController@utility_update_category')->name('utility.update.category');
	Route::delete('utility/{category}', '\App\UtilityController@utility_delete_category')->name('utility.delete.category');
	/* Utility Item */
	Route::get('utility/{category}/new', '\App\UtilityController@utility_add_item')->name('utility.add.item');
	Route::post('utility/{category}/new', '\App\UtilityController@utility_save_item')->name('utility.save.item');
	Route::get('utility/{category}/{item}', '\App\UtilityController@utility_edit_item')->name('utility.edit.item');
	Route::post('utility/{category}/{item}', '\App\UtilityController@utility_update_item')->name('utility.update.item');
	Route::delete('utility/{category}/{item}', '\App\UtilityController@utility_delete_item')->name('utility.delete.item');

	/* Safety */
	Route::get('safety', '\App\AdmincpController@safety_edit')->name('safety.edit');
	Route::get('safety/new', '\App\AdmincpController@safety_add_item')->name('safety.add.item');
	Route::post('safety/new', '\App\AdmincpController@safety_save_item')->name('safety.save.item');
	/* Safety Item */
	Route::get('safety/{item}', '\App\AdmincpController@safety_item_edit')->name('safety.item.edit');
	Route::post('safety/{item}', '\App\AdmincpController@safety_item_save')->name('safety.item.save');
	Route::delete('safety/{item}', '\App\AdmincpController@safety_item_delete')->name('safety.item.delete');

	/***************************************************************************/
	/* Accessory */
	Route::get('accessory', '\App\AccessoryController@accessory_edit')->name('accessory.edit');
	Route::post('accessory', '\App\AccessoryController@accessory_update')->name('accessory.update');
	/* Accessory Category */
	Route::get('accessory/new', '\App\AccessoryController@accessory_add_category')->name('accessory.add.category');
	Route::post('accessory/new', '\App\AccessoryController@accessory_save_category')->name('accessory.save.category');
	Route::get('accessory/{category}', '\App\AccessoryController@accessory_edit_category')->name('accessory.edit.category');
	Route::post('accessory/{category}', '\App\AccessoryController@accessory_update_category')->name('accessory.update.category');
	Route::delete('accessory/{category}', '\App\AccessoryController@accessory_delete_category')->name('accessory.delete.category');
	/* Accessory Item */
	Route::get('accessory/{category}/new', '\App\AccessoryController@accessory_add_item')->name('accessory.add.item');
	Route::post('accessory/{category}/new', '\App\AccessoryController@accessory_save_item')->name('accessory.save.item');
	Route::get('accessory/{category}/{item}', '\App\AccessoryController@accessory_edit_item')->name('accessory.edit.item');
	Route::post('accessory/{category}/{item}', '\App\AccessoryController@accessory_update_item')->name('accessory.update.item');
	Route::delete('accessory/{category}/{item}', '\App\AccessoryController@accessory_delete_item')->name('accessory.delete.item');

	/* Specification */
	Route::get('specification', '\App\AdmincpController@specification_edit')->name('specification.edit');
	Route::post('specification', '\App\AdmincpController@specification_save')->name('specification.save');

	/***************************************************************************/
	/* Gallery */
	Route::get('gallery', '\App\GalleryController@gallery_edit')->name('gallery.edit');
	/* Gallery Category */
	Route::get('gallery/new', '\App\GalleryController@gallery_add_category')->name('gallery.add.category');
	Route::post('gallery/new', '\App\GalleryController@gallery_save_category')->name('gallery.save.category');
	Route::get('gallery/{category}', '\App\GalleryController@gallery_edit_category')->name('gallery.edit.category');
	Route::post('gallery/{category}', '\App\GalleryController@gallery_update_category')->name('gallery.update.category');
	Route::delete('gallery/{category}', '\App\GalleryController@gallery_delete_category')->name('gallery.delete.category');
	/* Gallery Item */
	Route::get('gallery/{category}/new', '\App\GalleryController@gallery_add_item')->name('gallery.add.item');
	Route::post('gallery/{category}/new', '\App\GalleryController@gallery_save_item')->name('gallery.save.item');
	Route::get('gallery/{category}/{item}', '\App\GalleryController@gallery_edit_item')->name('gallery.edit.item');
	Route::post('gallery/{category}/{item}', '\App\GalleryController@gallery_update_item')->name('gallery.update.item');
	Route::delete('gallery/{category}/{item}', '\App\GalleryController@gallery_delete_item')->name('gallery.delete.item');

	/* Hyperlink */
	Route::get('hyperlink', '\App\AdmincpController@hyperlink_list')->name('hyperlink.list');
	Route::get('hyperlink/{link}', '\App\AdmincpController@hyperlink_edit')->name('hyperlink.edit');
	Route::post('hyperlink/{link}', '\App\AdmincpController@hyperlink_save')->name('hyperlink.save');
});

Route::get('/', function () {
	$context = [
		'assets_url' => asset('dist/assets/'),
		'app_environment' => App::environment(),
	];
	$context['title'] = "Honda Civic";

	/* Section Banner */
	$context['banner'] = DB::table('banner')->where('id', 1)->first();

	/* Section Message */
	$context['message'] = DB::table('message')->where('id', 1)->first();

	/* Section Exterior */
	$context['exterior'] = DB::table('exterior')->where('id', 1)->first();
	$exterior_categories = DB::table('exterior_category')->orderBy('order', 'desc')->get()->keyBy('id');
	$exterior_categories = $exterior_categories->toArray();
	foreach( $exterior_categories as $exterior_category ) {
		$exterior_category->items = [];
	}
	$context['exterior_categories'] = $exterior_categories;
	$exterior_items = DB::table('exterior_item')->orderBy('order', 'desc')->get();
	$exterior_items = $exterior_items->toArray();
	foreach( $exterior_items as $exterior_item ) {
		if( isset( $exterior_categories[$exterior_item->category]->items ) ) {
			array_push( $exterior_categories[$exterior_item->category]->items, $exterior_item );
		}
	}

	/* Section Interior */
	$context['interior'] = DB::table('interior')->where('id', 1)->first();
	$interior_categories = DB::table('interior_category')->orderBy('order', 'desc')->get()->keyBy('id');
	$interior_categories = $interior_categories->toArray();
	foreach( $interior_categories as $interior_category ) {
		$interior_category->items = [];
	}
	$context['interior_categories'] = $interior_categories;
	$interior_items = DB::table('interior_item')->orderBy('order', 'desc')->get();
	$interior_items = $interior_items->toArray();
	foreach( $interior_items as $interior_item ) {
		if( isset( $interior_categories[$interior_item->category]->items ) ) {
			array_push( $interior_categories[$interior_item->category]->items, $interior_item );
		}
	}

	/* Section Operation */
	$context['operation'] = DB::table('operation')->where('id', 1)->first();
	$operation_categories = DB::table('operation_category')->orderBy('order', 'desc')->get()->keyBy('id');
	$operation_categories = $operation_categories->toArray();
	foreach( $operation_categories as $operation_category ) {
		$operation_category->items = [];
	}
	$context['operation_categories'] = $operation_categories;
	$operation_items = DB::table('operation_item')->orderBy('order', 'desc')->get();
	$operation_items = $operation_items->toArray();
	foreach( $operation_items as $operation_item ) {
		if( isset( $operation_categories[$operation_item->category]->items ) ) {
			array_push( $operation_categories[$operation_item->category]->items, $operation_item );
		}
	}

	/* Section Utility */
	$context['utility'] = DB::table('utility')->where('id', 1)->first();
	$utility_categories = DB::table('utility_category')->orderBy('order', 'desc')->get()->keyBy('id');
	$utility_categories = $utility_categories->toArray();
	foreach( $utility_categories as $utility_category ) {
		$utility_category->items = [];
	}
	$context['utility_categories'] = $utility_categories;
	$utility_items = DB::table('utility_item')->orderBy('order', 'desc')->get();
	$utility_items = $utility_items->toArray();
	foreach( $utility_items as $utility_item ) {
		if( isset( $utility_categories[$utility_item->category]->items ) ) {
			array_push( $utility_categories[$utility_item->category]->items, $utility_item );
		}
	}

	/* Section Safety */
	$safety_parts = DB::table('safety_item')->orderBy('order', 'desc')->get();
	$safety_parts = $safety_parts->toArray();
	$context['safety_parts'] = $safety_parts;

	/* Section Accessory */
	$context['accessory'] = DB::table('accessory')->where('id', 1)->first();
	$accessory_categories = DB::table('accessory_category')->orderBy('order', 'desc')->get()->keyBy('id');
	$accessory_categories = $accessory_categories->toArray();
	foreach( $accessory_categories as $accessory_category ) {
		$accessory_category->items = [];
	}
	$context['accessory_categories'] = $accessory_categories;
	$accessory_items = DB::table('accessory_item')->orderBy('order', 'desc')->get();
	$accessory_items = $accessory_items->toArray();
	foreach( $accessory_items as $accessory_item ) {
		if( isset( $accessory_categories[$accessory_item->category]->items ) ) {
			array_push( $accessory_categories[$accessory_item->category]->items, $accessory_item );
		}
	}

	/* Section Specification */
	$context['specification'] = DB::table('specification')->where('id', 1)->first();

	/* Section Gallery */
	$gallery_categories = DB::table('gallery_category')->orderBy('order', 'desc')->get()->keyBy('id');
	$gallery_categories = $gallery_categories->toArray();
	foreach( $gallery_categories as $gallery_category ) {
		$gallery_category->items = [];
	}
	$context['gallery_categories'] = $gallery_categories;
	$gallery_items = DB::table('gallery_item')->orderBy('order', 'desc')->get();
	$gallery_items = $gallery_items->toArray();
	foreach( $gallery_items as $gallery_item ) {
		if( isset( $gallery_categories[$gallery_item->category]->items ) ) {
			array_push( $gallery_categories[$gallery_item->category]->items, $gallery_item );
		}
	}

	/* Hyperlinks */
	$hyperlinks = DB::table('hyperlink')->get()->keyBy('key');;
	$hyperlinks = $hyperlinks->toArray();
	$context['hyperlinks'] = $hyperlinks;

    // return view('index');
    return View::make('index', $context);
});