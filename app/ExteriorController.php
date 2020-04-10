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

class ExteriorController extends Controller
{

	/*
	* View form edit Exterior
	*/
	public function exterior_edit() {
		$exterior = DB::table('exterior')->where('id', 1)->first();
		$exterior_categories = DB::table('exterior_category')->orderBy('order', 'desc')->get();
        return view('panel.exterior.edit')->with([
			'exterior' => $exterior,
			'exterior_categories' => $exterior_categories
		]);
    }

	/*
	* Save Exterior
	*/
	public function exterior_update( Request $request ) {
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

		DB::table('exterior')
            ->where('id',1)
            ->update([
				'section_background' => clean( $request->input('section_background') ),
				'section_background_mobile' => clean( $request->input('section_background_mobile') ),
				'section_title' => clean( $request->input('section_title') ),
				'section_description' => clean( $request->input('section_description') ),
			]);

		$exterior = DB::table('exterior')->where('id', 1)->first();

		Session::flash('success', 'Success');

        return redirect()->route('admincp.exterior.edit')->with(['exterior'=>$exterior]);

    }



    /*********************************************************************************************************************************/

    /*
	* View form add Exterior Category
	*/
	public function exterior_add_category() {
		return view('panel.exterior.add_category');
    }

    /*
	* Save Exterior Category
	*/
	public function exterior_save_category( Request $request ) {
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

        $category = DB::table('exterior_category')->insertGetId([
			'title' => clean( $request->input( 'title' ) ),
			'heading' => clean( $request->input( 'heading' ) ),
			'description' => clean( $request->input( 'description' ) ),
			'image' => clean( $request->input( 'image' ) ),
            'image_mobile' => clean( $request->input( 'image_mobile' ) ),
			'order' => clean( $request->input( 'order' ) ),
		]);

		Session::flash('success', 'Success');

        return redirect()->route('admincp.exterior.edit.category',['category'=>$category]);

    }

    /*
	* View form edit Exterior Category
	*/
	public function exterior_edit_category( Request $request ) {
		$category = DB::table('exterior_category')->where('id', $request->route('category'))->first();
		$items = DB::table('exterior_item')->where('category', $request->route('category'))->orderBy('order','desc')->get();
        return view('panel.exterior.edit_category')->with([
			'category' => $category,
            'items' => $items
		]);
    }

    /*
	* Update Exterior Category
	*/
	public function exterior_update_category( Request $request ) {
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

        DB::table('exterior_category')
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

        return redirect()->route('admincp.exterior.edit.category',['category'=>$request->route('category')]);

    }

    /*
	* Delete Exterior Category
	*/
	public function exterior_delete_category( Request $request ) {

		DB::table('exterior_item')->where('category', $request->route('category'))->delete();
		DB::table('exterior_category')->where('id', $request->route('category'))->delete();

		Session::flash('success', 'Success');

        return redirect()->route('admincp.exterior.edit');

    }



    /***********************************************************************************************************************************/

	/*
	* View form Add New Exterior Item
	*/
	public function exterior_add_item(Request $request) {
        $category = DB::table('exterior_category')->where('id', $request->route('category'))->first();
        return view('panel.exterior.add_item')->with([
            'category' => $category
        ]);
    }

	/*
	* Save Exterior Item
	*/
	public function exterior_save_item( Request $request ) {
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

		$item = DB::table('exterior_item')->insertGetId([
            'category' => clean( $request->route('category') ),
            'image' => clean( $request->input( 'image' ) ),
			'title' => clean( $request->input( 'title' ) ),
			'description' => clean( $request->input( 'description' ) ),
			'order' => clean( $request->input( 'order' ) ),
		]);

		Session::flash('success', 'Success');

		return redirect()->route('admincp.exterior.edit.item', ['category'=>$request->route('category'),'item'=>$item]);

    }

	/*
	* View form edit Exterior Item
	*/
	public function exterior_edit_item( Request $request ) {
		$category = DB::table('exterior_category')->where('id', $request->route('category'))->first();
		$item = DB::table('exterior_item')->where('id', $request->route('item'))->first();
        return view('panel.exterior.edit_item')->with([
			'category' => $category,
			'item' => $item
		]);
    }

	/*
	* Update Exterior Item
	*/
	public function exterior_update_item( Request $request ) {
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

		DB::table('exterior_item')
            ->where('id',$request->route('item'))
            ->update([
                'image' => clean( $request->input( 'image' ) ),
    			'title' => clean( $request->input( 'title' ) ),
    			'description' => clean( $request->input( 'description' ) ),
    			'order' => clean( $request->input( 'order' ) ),
			]);

		Session::flash('success', 'Success');

        return redirect()->route('admincp.exterior.edit.item',['category'=>$request->route('category'),'item'=>$request->route('item')]);

    }

	/*
	* Delete Exterior Item
	*/
	public function exterior_delete_item( Request $request ) {

		DB::table('exterior_item')->where('id', $request->route('item'))->delete();

		Session::flash('success', 'Success');

        return redirect()->route('admincp.exterior.edit.category',['category'=>$request->route('category')]);

    }

}
