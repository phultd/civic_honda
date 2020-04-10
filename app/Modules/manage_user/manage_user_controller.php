<?php

/*
* Table of content:
* user_list
* user_new
* user_save
* user_edit
* user_profile
* user_update
* user_delete
* user_perform_delete
*/

namespace App\Modules\manage_user;

use DB;
use Auth;
use Session;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\CliController;
use App\Modules\manage_user\User;
use App\Modules\manage_role\manage_role_model;

class manage_user_controller extends CliController
{

	/***************************************************************************
	* @view
	* Listing all modules
	***************************************************************************/
    public function user_list(Request $request) {
		// sort condition
		$perpage = $request->has('perpage') ? intval($request->input('perpage')) : 20;
		$orderby = 'username';
		$order = 'asc';
		$byrole = '';
		$s = ( $request->has('s') && $request->input('s') != '' ) ? $request->input('s') : '';
		if( $request->has('orderby') && in_array( $request->input('orderby'), ['username', 'email', 'role_id'] ) ) {
			$orderby = $request->input('orderby');
		}
		if( $request->has('order') && in_array( $request->input('order'), ['asc', 'desc'] ) ) {
			$order = $request->input('order');
		}

		// get all users, exclude super-admin users. Return the result in desire order, paginate to reduce load
		if( $request->has('byrole') && $request->input('byrole') != '' ) {
			$users = User::where('role_id',$request->input('byrole'))->orderBy($orderby, $order)->with('get_role')->paginate($perpage);
			$byrole = $request->input('byrole');
		} else if( $request->has('s') && $request->input('s') != '' ) {
			$users = User::
				where([
					['role_id', '<>', 1],
					['username', 'like', "%{$s}%"],
				])
				->orderBy($orderby, $order)
				->with('get_role')
				->paginate($perpage);
		} else {
			$users = User::where('role_id','<>',1)->orderBy($orderby, $order)->with('get_role')->paginate($perpage);
		}

		// count user by role
		$roles = manage_role_model::where('slug','<>','super-administrator')->with('get_users')->get();

		// render view
        return view('cms.user.list')->with([
            'users' => $users,
			'perpage' => $perpage,
			'orderby' => $orderby,
			'order' => $order,
			'roles' => $roles,
			'byrole' => $byrole,
			's' => $s
        ]);
    }

	/***************************************************************************
	* @view
	* Form create
	***************************************************************************/
    public function user_new() {
		// render view
        return view('cms.user.create')->with([]);
    }

	/***************************************************************************
	* @action
	* Save data from form create
	***************************************************************************/
    public function user_save(Request $request) {
		// validate the data
		$validator = Validator::make($request->all(), [
			'username' => ['required', 'regex:/^[0-9A-Za-z.\-_]+$/', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
			'name' => ['nullable', 'string', 'max:255'],
		]);

		if ($validator->fails()) {
            return redirect()->route('cms.user_new')
                ->withErrors($validator)
                ->withInput();
        }

		// set role
		$role_id = manage_role_model::where('slug','editor')->first();
		$role_id_chk = manage_role_model::where('slug',$request->input('role'))->first();
		if( $role_id_chk->id ) {
			$role_id = $role_id_chk->id;
		}

		// create new user
		$user = User::create([
			'username' => $request->input('username'),
            'email' => $request->input('email'),
			'password' => \Hash::make($request->input('password')),
			'name' => $request->input('name'),
			'role_id' => $role_id,
			'avatar' => $request->input('avatar')
        ]);

		if( $user->id ) {
			Session::flash('success', 'User created.');
			return redirect()->route('cms.user_edit', ['user'=>$user->id]);
		} else {
			Session::flash('danger', 'Something went wrong. Please try again or report to administrator.');
			return redirect()->route('cms.user_new')
                ->withInput();
		}

    }

	/***************************************************************************
	* @view
	* Form edit item
	***************************************************************************/
    public function user_edit(Request $request) {
		// get user
		$id = $request->input('user');
        $user = User::findOrFail($id);
		//render view
		return view('cms.user.edit')->with([
			'user' => $user
		]);
    }

	/***************************************************************************
	* @view
	* Form edit item
	***************************************************************************/
    public function user_profile() {
        $user = User::where('id',Auth::id())->with('get_role')->first();
		//render view
		return view('cms.user.edit')->with([
			'user' => $user
		]);
    }

	/***************************************************************************
	* @action
	* Update data from form edit
	***************************************************************************/
    public function user_update(Request $request) {
		// get user
		$user = User::findOrFail($request->input('user'));

		// validate the data
		$validator = Validator::make($request->all(), [
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
			'name' => ['nullable', 'string', 'max:255'],
			'password' => ['nullable', 'string', 'min:6']
		]);

		if ($validator->fails()) {
            return redirect()->route('cms.user_edit', ['user'=>$user->id])
                ->withErrors($validator)
                ->withInput();
        }

		// set role
		$role_id = manage_role_model::where('slug','editor')->first();
		$role_id_chk = manage_role_model::where('slug',$request->input('role'))->first();
		if( $role_id_chk->id ) {
			$role_id = $role_id_chk->id;
		}

		$user->email = $request->input('email');
		if( $request->input('password') != '' ) {
			$user->password = \Hash::make($request->input('password'));
		}
		$user->name = $request->input('name');
		$user->role_id = $role_id;
		$user->avatar = $request->input('avatar');

		$user->save();

		Session::flash('success', 'User updated.');
		return redirect()->route('cms.user_edit', ['user'=>$user->id]);
    }

	/***************************************************************************
	* @view
	* Delete item
	***************************************************************************/
    public function user_delete(Request $request) {
		// get user
		$id = $request->input('user');
        $user = User::with('get_role')->findOrFail($id);

		// posts belong to this user
		$is_author = false;
		$modules = DB::table('cms_module')->get();
		if( ! $modules->isEmpty() ) {
			foreach( $modules as $module ) {
				$chk_author = DB::table($module->table_name)
					->where('author_id', $user->id)
					->first();
				if( ! $chk_author->isEmpty() ) {
					$is_author = true;
					break;
				}
			}
		}

		// user list to attribute
		$users = User::where([
				['role_id','<>',1],
				['id','<>',$id]
			])
			->orderBy('username', 'asc')
			->get();
		//render view
		return view('cms.user.delete')->with([
			'user' => $user,
			'is_author' => $is_author,
			'users' => $users
		]);
    }

	/***************************************************************************
	* @action
	* Delete item
	***************************************************************************/
    public function user_perform_delete(Request $request) {
		// check owned_action
		if($request->has('is_author') && !$request->has('owned_action')) {
			return redirect()
				->back()
				->withErrors(['Please choose action'])
				->withInput();
		}

		// get user
		$id = $request->input('user');
		$user = User::findOrFail($id);

		$owned_action = $request->input('owned_action');
		$attributed_author = $request->input('attribute');

		// proceed owned_action
		$modules = DB::table('cms_module')->get();
		if( ! $modules->isEmpty() ) {
			foreach( $modules as $module ) {
				if( $owned_action == 'attribute' ) {
					// assign posts to other user
					DB::table($module->table_name)
						->where('author_id', $user->id)
						->update(['author_id' => $attributed_author]);
				} else {
					// delete posts
					DB::table($module->table_name)
						->where('author_id', $user->id)
						->forceDelete();
				}
			}
		}

		$user->delete();

		Session::flash('success', 'User deleted.');
		return redirect()->route('cms.user_list');
    }

}
