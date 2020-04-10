<?php

namespace App\Http\Controllers;

use DB;
use Schema;
use Illuminate\Http\Request;

class AdminAjaxController extends CliController
{

	public function index(Request $request) {
		if( ! $request->has('action') ) {
			return response()->json(['error'=>1, 'html'=>'No action called']);
			exit();
		} else {
			$action = $request->input('action');
			return $this->$action($request);
		}
	}

	/*
	* Toggle item status
	*/
	private function change_status($request) {
		// some code here
		// ...
		// return json
		return response()->json(['error'=>0, 'html'=>'Status updated']);
		exit();
    }

}
