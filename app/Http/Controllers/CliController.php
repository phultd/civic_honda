<?php

namespace App\Http\Controllers;

use DB;
use View;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class CliController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public function __construct(){

		/*
		* Admin menu
		*/
		// $admin_menu = DB::table('cms_module')->get();
		// View::share([
		// 	"admin_menu" => $admin_menu
		// ]);

	    // dummy data object.
	    $global_data = "Dummy global data";

	    // global view data
	    View::share([
			'assets_url' => url('/'),
			'global_data' => $global_data
		]);
  	}

}
