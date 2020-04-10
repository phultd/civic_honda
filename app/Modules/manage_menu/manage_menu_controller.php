<?php

/*
* Table of content:
* menu_list
* menu_new
* menu_save
* menu_view
* menu_edit
* menu_update
* menu_delete
*/

namespace App\Modules\manage_menu;

use DB;
use Auth;
use Session;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\CliController;
use App\Modules\manage_menu\manage_menu_model;
use App\Modules\manage_menu\manage_menu_item_model;

class manage_menu_controller extends CliController
{

	/***************************************************************************
	* @view
	* Listing all menus
	***************************************************************************/
    public function menu_list(Request $request) {
		$menus = manage_menu_model::orderBy('created_at', 'asc')->get();

		$selected_menu = '';
		if( $request->has('menu') && $request->input('menu') != '' ) {
			$selected_menu = manage_menu_model::where('slug',$request->input('menu'))->first();
		}elseif( ! $menus->isEmpty() ) {
			$selected_menu = $menus[0];
		}

        return view('cms.menu.list')->with([
            'menus' => $menus,
			'selected_menu' => $selected_menu
        ]);
    }

	/***************************************************************************
	* @action
	* Save data from form create
	***************************************************************************/
    public function menu_save(Request $request) {
		// validate the data
		$validator = Validator::make($request->all(), [
			'menu_title' => ['required', 'max:255', 'unique:menu,title'],
			'menu_slug' => ['required', 'max:255', 'alpha_dash', 'unique:menu,slug']
		]);

		if ($validator->fails()) {
            return redirect()->route('cms.menu_list')
                ->withErrors($validator)
                ->withInput();
        }

        // store in the database
		$menu = new manage_menu_model;

        $menu->title = $request->input('menu_title');
		$menu->slug = $request->input('menu_slug');

		// success
		$menu->save();

        Session::flash('success', 'Menu created!');

        return redirect()->route('cms.menu_list', ['menu'=>$menu->slug]);
    }

	/***************************************************************************
	* @action
	* Update data from form edit
	***************************************************************************/
    public function menu_update(Request $request) {
		// get menu
		$menu = manage_menu_model::where('slug', $request->input('menu'))->first();

		// validate the data
		$validator = Validator::make($request->all(), [
			'menu_title_edit' => ['required', 'max:255', 'unique:menu,title,'.$menu->id],
			'menu_slug_edit' => ['required', 'max:255', 'alpha_dash', 'unique:menu,slug,'.$menu->id]
		]);

		if ($validator->fails()) {
            return redirect()->route('cms.menu_list', ['menu'=>$menu->slug])
                ->withErrors($validator)
                ->withInput();
        }

		$menu->title = $request->input('menu_title_edit');
		$menu->slug = $request->input('menu_slug_edit');

		$menu->save();

		Session::flash('success', 'Menu updated.');
		return redirect()->route('cms.menu_list', ['menu'=>$menu->slug]);
    }

	/***************************************************************************
	* @action
	* Delete item
	***************************************************************************/
    public function menu_delete(Request $request) {
        $menu = manage_menu_model::where('slug',$request->input('menu'))->first();

		$menu->delete();

		Session::flash('success', 'Menu deleted.');
		return redirect()->route('cms.menu_list');
    }

	/***************************************************************************
	* @action
	* Update data from form edit
	***************************************************************************/
    public function menu_items_update(Request $request) {

		$menu = manage_menu_model::findOrFail($request->input('menu_id'));

		// validate the data
		$validator = Validator::make($request->all(), [
			'title' => ['required', 'array'],
			'title.*' => ['required', 'string', 'max:255']
		]);

		if ($validator->fails()) {
            return redirect()->route('cms.menu_list', ['menu'=>$menu->slug])
                ->withErrors($validator)
                ->withInput();
        }

		$input_titles = $request->input('title');

		foreach( $input_titles as $key => $title ) {
			$menu_item = new manage_menu_item_model;
			$menu_item->menu_id = $menu->id;
			$menu_item->title = $title;
			$menu_item->url = '';
			$menu_item->target = '';
			$menu_item->class = '';
			$menu_item->parent_id = NULL;
			$menu_item->route = '';
			$menu_item->order = $key;

			$menu_item->save();
		}

		Session::flash('success', 'Menu updated.');
		return redirect()->route('cms.menu_list', ['menu'=>$menu->slug]);
    }

}
