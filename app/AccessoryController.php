<?php

namespace App;

use DB;
use Auth;
use Hash;
use Session;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccessoryController extends Controller
{

	/*
	* View form edit accessory
	*/
	public function accessory_edit() {
		$accessory = DB::table('accessory')->where('id', 1)->first();
		$accessory_categories = DB::table('accessory_category')->orderBy('order', 'desc')->get();
        return view('panel.accessory.edit')->with([
			'accessory' => $accessory,
			'accessory_categories' => $accessory_categories
		]);
    }

	/*
	* Save accessory
	*/
	public function accessory_update( Request $request ) {
		// validate the data
		$validator = Validator::make($request->all(), [
            'section_background' => ['required', 'max:255'],
            'section_background_mobile' => ['required', 'max:255'],
			'section_title' => ['required', 'max:255'],
			'section_description' => ['required', 'max:1000'],
		]);

		if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

		DB::table('accessory')
            ->where('id',1)
            ->update([
				'section_background' => clean( $request->input('section_background') ),
				'section_background_mobile' => clean( $request->input('section_background_mobile') ),
				'section_title' => clean( $request->input('section_title') ),
				'section_description' => clean( $request->input('section_description') ),
			]);

		$accessory = DB::table('accessory')->where('id', 1)->first();

		Session::flash('success', 'Success');

        return redirect()->route('admincp.accessory.edit')->with(['accessory'=>$accessory]);

    }



    /*********************************************************************************************************************************/

    /*
	* View form add accessory Category
	*/
	public function accessory_add_category() {
		return view('panel.accessory.add_category');
    }

    /*
	* Save accessory Category
	*/
	public function accessory_save_category( Request $request ) {
		// validate the data
		$validator = Validator::make($request->all(), [
			'title' => ['required', 'max:255'],
			'heading' => ['required', 'max:255'],
			'description' => ['required', 'max:1000'],
            'image' => ['required', 'max:255'],
            'image_mobile' => ['required', 'max:255'],
            'order' => ['regex:/^[0-9]+$/'],
		]);

		if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $category = DB::table('accessory_category')->insertGetId([
			'title' => clean( $request->input( 'title' ) ),
			'heading' => clean( $request->input( 'heading' ) ),
			'description' => clean( $request->input( 'description' ) ),
			'image' => clean( $request->input( 'image' ) ),
            'image_mobile' => clean( $request->input( 'image_mobile' ) ),
			'order' => clean( $request->input( 'order' ) ),
		]);

		Session::flash('success', 'Success');

        return redirect()->route('admincp.accessory.edit.category',['category'=>$category]);

    }

    /*
	* View form edit accessory Category
	*/
	public function accessory_edit_category( Request $request ) {
		$category = DB::table('accessory_category')->where('id', $request->route('category'))->first();
		$items = DB::table('accessory_item')->where('category', $request->route('category'))->orderBy('order','desc')->get();
        return view('panel.accessory.edit_category')->with([
			'category' => $category,
            'items' => $items
		]);
    }

    /*
	* Update accessory Category
	*/
	public function accessory_update_category( Request $request ) {
		// validate the data
		$validator = Validator::make($request->all(), [
			'title' => ['required', 'max:255'],
			'heading' => ['required', 'max:255'],
			'description' => ['required', 'max:1000'],
            'image' => ['required', 'max:255'],
            'image_mobile' => ['required', 'max:255'],
            'order' => ['regex:/^[0-9]+$/'],
		]);

		if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('accessory_category')
            ->where('id',$request->route('category'))
            ->update([
                'title' => clean( $request->input( 'title' ) ),
    			'heading' => clean( $request->input( 'heading' ) ),
    			'description' => clean( $request->input( 'description' ) ),
    			'image' => clean( $request->input( 'image' ) ),
                'image_mobile' => clean( $request->input( 'image_mobile' ) ),
    			'order' => clean( $request->input( 'order' ) ),
			]);

		Session::flash('success', 'Success');

        return redirect()->route('admincp.accessory.edit.category',['category'=>$request->route('category')]);

    }

    /*
	* Delete accessory Category
	*/
	public function accessory_delete_category( Request $request ) {

		DB::table('accessory_item')->where('category', $request->route('category'))->delete();
		DB::table('accessory_category')->where('id', $request->route('category'))->delete();

		Session::flash('success', 'Success');

        return redirect()->route('admincp.accessory.edit');

    }



    /***********************************************************************************************************************************/

	/*
	* View form Add New accessory Item
	*/
	public function accessory_add_item(Request $request) {
        $category = DB::table('accessory_category')->where('id', $request->route('category'))->first();
        return view('panel.accessory.add_item')->with([
            'category' => $category
        ]);
    }

	/*
	* Save accessory Item
	*/
	public function accessory_save_item( Request $request ) {
		// validate the data
		$validator = Validator::make($request->all(), [
            'image' => ['required', 'max:255'],
			'title' => ['max:255'],
			'description' => ['required', 'max:1000'],
            'order' => ['regex:/^[0-9]+$/'],
		]);

		if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

		$item = DB::table('accessory_item')->insertGetId([
            'category' => clean( $request->route('category') ),
            'image' => clean( $request->input( 'image' ) ),
			'title' => clean( $request->input( 'title' ) ),
			'description' => clean( $request->input( 'description' ) ),
			'order' => clean( $request->input( 'order' ) ),
		]);

		Session::flash('success', 'Success');

		return redirect()->route('admincp.accessory.edit.item', ['category'=>$request->route('category'),'item'=>$item]);

    }

	/*
	* View form edit accessory Item
	*/
	public function accessory_edit_item( Request $request ) {
		$category = DB::table('accessory_category')->where('id', $request->route('category'))->first();
		$item = DB::table('accessory_item')->where('id', $request->route('item'))->first();
        return view('panel.accessory.edit_item')->with([
			'category' => $category,
			'item' => $item
		]);
    }

	/*
	* Update accessory Item
	*/
	public function accessory_update_item( Request $request ) {
		// validate the data
		$validator = Validator::make($request->all(), [
            'image' => ['required', 'max:255'],
			'title' => ['max:255'],
			'description' => ['required', 'max:1000'],
            'order' => ['regex:/^[0-9]+$/'],
		]);

		if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

		DB::table('accessory_item')
            ->where('id',$request->route('item'))
            ->update([
                'image' => clean( $request->input( 'image' ) ),
    			'title' => clean( $request->input( 'title' ) ),
    			'description' => clean( $request->input( 'description' ) ),
    			'order' => clean( $request->input( 'order' ) ),
			]);

		Session::flash('success', 'Success');

        return redirect()->route('admincp.accessory.edit.item',['category'=>$request->route('category'),'item'=>$request->route('item')]);

    }

	/*
	* Delete accessory Item
	*/
	public function accessory_delete_item( Request $request ) {

		DB::table('accessory_item')->where('id', $request->route('item'))->delete();

		Session::flash('success', 'Success');

        return redirect()->route('admincp.accessory.edit.category',['category'=>$request->route('category')]);

    }

}
