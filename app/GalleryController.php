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

class GalleryController extends Controller
{

	/*
	* View form edit gallery
	*/
	public function gallery_edit() {
		$gallery_categories = DB::table('gallery_category')->orderBy('order', 'desc')->get();
        return view('panel.gallery.edit')->with([
			'gallery_categories' => $gallery_categories
		]);
    }



    /*********************************************************************************************************************************/

    /*
	* View form add gallery Category
	*/
	public function gallery_add_category() {
		return view('panel.gallery.add_category');
    }

    /*
	* Save gallery Category
	*/
	public function gallery_save_category( Request $request ) {
		// validate the data
		$validator = Validator::make($request->all(), [
			'title' => ['required', 'max:255'],
			'heading' => ['required', 'max:255'],
			'description' => ['required', 'max:1000'],
            'image' => ['required', 'max:255'],
            'order' => ['regex:/^[0-9]+$/'],
		]);

		if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $category = DB::table('gallery_category')->insertGetId([
			'title' => clean( $request->input( 'title' ) ),
			'heading' => clean( $request->input( 'heading' ) ),
			'description' => clean( $request->input( 'description' ) ),
			'image' => clean( $request->input( 'image' ) ),
			'order' => clean( $request->input( 'order' ) ),
		]);

		Session::flash('success', 'Success');

        return redirect()->route('admincp.gallery.edit.category',['category'=>$category]);

    }

    /*
	* View form edit gallery Category
	*/
	public function gallery_edit_category( Request $request ) {
		$category = DB::table('gallery_category')->where('id', $request->route('category'))->first();
		$items = DB::table('gallery_item')->where('category', $request->route('category'))->orderBy('order','desc')->get();
        return view('panel.gallery.edit_category')->with([
			'category' => $category,
            'items' => $items
		]);
    }

    /*
	* Update gallery Category
	*/
	public function gallery_update_category( Request $request ) {
		// validate the data
		$validator = Validator::make($request->all(), [
			'title' => ['required', 'max:255'],
			'heading' => ['required', 'max:255'],
			'description' => ['required', 'max:1000'],
            'image' => ['required', 'max:255'],
            'order' => ['regex:/^[0-9]+$/'],
		]);

		if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::table('gallery_category')
            ->where('id',$request->route('category'))
            ->update([
                'title' => clean( $request->input( 'title' ) ),
    			'heading' => clean( $request->input( 'heading' ) ),
    			'description' => clean( $request->input( 'description' ) ),
    			'image' => clean( $request->input( 'image' ) ),
    			'order' => clean( $request->input( 'order' ) ),
			]);

		Session::flash('success', 'Success');

        return redirect()->route('admincp.gallery.edit.category',['category'=>$request->route('category')]);

    }

    /*
	* Delete gallery Category
	*/
	public function gallery_delete_category( Request $request ) {

		DB::table('gallery_item')->where('category', $request->route('category'))->delete();
		DB::table('gallery_category')->where('id', $request->route('category'))->delete();

		Session::flash('success', 'Success');

        return redirect()->route('admincp.gallery.edit');

    }



    /***********************************************************************************************************************************/

	/*
	* View form Add New gallery Item
	*/
	public function gallery_add_item(Request $request) {
        $category = DB::table('gallery_category')->where('id', $request->route('category'))->first();
        return view('panel.gallery.add_item')->with([
            'category' => $category
        ]);
    }

	/*
	* Save gallery Item
	*/
	public function gallery_save_item( Request $request ) {
		// validate the data
		$validator = Validator::make($request->all(), [
            'image' => ['required', 'max:255'],
            'order' => ['regex:/^[0-9]+$/'],
		]);

		if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

		$item = DB::table('gallery_item')->insertGetId([
            'category' => clean( $request->route('category') ),
            'image' => clean( $request->input( 'image' ) ),
			'order' => clean( $request->input( 'order' ) ),
		]);

		Session::flash('success', 'Success');

		return redirect()->route('admincp.gallery.edit.item', ['category'=>$request->route('category'),'item'=>$item]);

    }

	/*
	* View form edit gallery Item
	*/
	public function gallery_edit_item( Request $request ) {
		$category = DB::table('gallery_category')->where('id', $request->route('category'))->first();
		$item = DB::table('gallery_item')->where('id', $request->route('item'))->first();
        return view('panel.gallery.edit_item')->with([
			'category' => $category,
			'item' => $item
		]);
    }

	/*
	* Update gallery Item
	*/
	public function gallery_update_item( Request $request ) {
		// validate the data
		$validator = Validator::make($request->all(), [
            'image' => ['required', 'max:255'],
            'order' => ['regex:/^[0-9]+$/'],
		]);

		if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

		DB::table('gallery_item')
            ->where('id',$request->route('item'))
            ->update([
                'image' => clean( $request->input( 'image' ) ),
    			'order' => clean( $request->input( 'order' ) ),
			]);

		Session::flash('success', 'Success');

        return redirect()->route('admincp.gallery.edit.item',['category'=>$request->route('category'),'item'=>$request->route('item')]);

    }

	/*
	* Delete gallery Item
	*/
	public function gallery_delete_item( Request $request ) {

		DB::table('gallery_item')->where('id', $request->route('item'))->delete();

		Session::flash('success', 'Success');

        return redirect()->route('admincp.gallery.edit.category',['category'=>$request->route('category')]);

    }

}
