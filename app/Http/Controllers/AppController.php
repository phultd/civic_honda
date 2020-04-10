<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends CliController
{
    public function homepage() {
		$top_banner = [
			"index" => [
				"image" => asset("/images/banner/top-banner-index.jpg")
			]
		];
        return view('app.index')->with([
			'top_banner' => $top_banner
		]);
    }
}
