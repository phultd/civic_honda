<?php

/*
* Table of content:
* table_list
* table_new
* table_save
* table_edit
* table_profile
* table_update
* table_delete
* table_perform_delete
*/

namespace App\Modules\manage_table;

use DB;
use Auth;
use Schema;
use Session;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\CliController;
use App\Modules\manage_user\User;
use App\Modules\manage_module\manage_module_model;

class manage_table_controller extends CliController
{

	/***************************************************************************
	* @view
	* Listing all modules
	***************************************************************************/
    public function table_list(Request $request) {
		$s = ( $request->has('s') && $request->input('s') != '' ) ? $request->input('s') : '';
		// get all tables in db
		$tables_in_db = DB::select('SHOW TABLES');
    	$db_name = "Tables_in_".env('DB_DATABASE');
		// remove default tables from the avaiable list
		$chk_tables = [
			'migrations',
			'users',
			'password_resets',
			'cms_module',
			'cms_module_field',
			'cms_module_constraint',
			'cms_role',
			'cms_role_permission'
		];
		// available tables for module to connect
        $tables = [];
        foreach($tables_in_db as $table){
			if( $s != '' ) {
				if( ! in_array( $table->{$db_name}, $chk_tables ) && is_numeric( strpos( $table->{$db_name}, $s ) ) ) {
					$tables[] = $table->{$db_name};
				}
			} else {
				if( ! in_array( $table->{$db_name}, $chk_tables ) ) {
					// $tables[$table->{$db}] = DB::select(DB::raw("SHOW COLUMNS FROM {$table->{$db}}"));
					$tables[] = $table->{$db_name};
				}
			}
        }
		// all module
		$modules = [];
		$all_modules = manage_module_model::all();
		if( ! $all_modules->isEmpty() ) {
			foreach( $all_modules as $module ) {
				$modules[$module->table_name] = $module;
			}
		}
		// render view
        return view('cms.table.list')->with([
			'tables' => $tables,
			'modules' => $modules,
			's' => $s
		]);
    }

	/***************************************************************************
	* @view
	* Form create
	***************************************************************************/
    public function table_new() {
		// render view
        return view('cms.table.create')->with([]);
    }

	/***************************************************************************
	* @action
	* Save data from form create
	***************************************************************************/
    public function table_save(Request $request) {
		// validate the data
		$validator = Validator::make($request->all(), [
			'username' => ['required', 'regex:/^[0-9A-Za-z.\-_]+$/', 'max:255', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
			'name' => ['nullable', 'string', 'max:255'],
		]);

		if ($validator->fails()) {
            return redirect()->route('cms.table_new')
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
			return redirect()->route('cms.table_edit', ['user'=>$user->id]);
		} else {
			Session::flash('danger', 'Something went wrong. Please try again or report to administrator.');
			return redirect()->route('cms.table_new')
                ->withInput();
		}

    }

	/***************************************************************************
	* @view
	* Form edit item
	***************************************************************************/
    public function table_edit(Request $request) {
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
    public function table_profile() {
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
    public function table_update(Request $request) {
		// get user
		$user = User::findOrFail($request->input('user'));

		// validate the data
		$validator = Validator::make($request->all(), [
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
			'name' => ['nullable', 'string', 'max:255'],
			'password' => ['nullable', 'string', 'min:6']
		]);

		if ($validator->fails()) {
            return redirect()->route('cms.table_edit', ['user'=>$user->id])
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
		return redirect()->route('cms.table_edit', ['user'=>$user->id]);
    }

	/***************************************************************************
	* @view
	* Delete item
	***************************************************************************/
    public function table_delete(Request $request) {
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
    public function table_perform_delete(Request $request) {
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
		return redirect()->route('cms.table_list');
    }

}
