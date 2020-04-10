<?php

/*
* Table of content:
* __construct
* get_module
* get_model
* post_list
* post_new
* post_save
* post_view
* post_edit
* post_update
* post_delete
* post_restore
* post_export_data
*/

namespace App\Modules\manage_post;

use DB;
use Auth;
use Session;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\CliController;
use App\Modules\manage_module\manage_module_model;

class manage_post_controller extends CliController
{
	private $module = null;
	private $model = null;

	/***************************************************************************
	* @action
	* Construct, set data module, data model
	***************************************************************************/
	public function __construct(Request $request) {
		parent::__construct();
		if( $request->get('module') ) {
			$this->module = $this->get_module( $request->get('module') );
			$this->model = $this->get_model( $this->module );
		}
	}

	/***************************************************************************
	* @action
	* Retrive module
	***************************************************************************/
	private function get_module( $module_slug ) {
		$module = manage_module_model::where('slug', $module_slug)->first();
		if( isset($module) && $module->fields ) {
			$module->fields = json_decode($module->fields, true);
		}
		return $module;
	}

	/***************************************************************************
	* @action
	* Retrive model
	***************************************************************************/
	private function get_model( $module ) {
		$folder_name = $module->folder_name;
		$model_name = str_replace_first(env('DB_PREFIX'), '', $module->table_name);
		$model = "App\Modules\\{$folder_name}\\{$model_name}_model";
		return $model;
	}

	/***************************************************************************
	* @view
	* Listing all items
	***************************************************************************/
    public function post_list(Request $request) {
        $per_page = 20;
        $posts = '';
		if( $request->filled('post_status') and ($request->input('post_status') == 'trash') ) {
            $posts = $this->model::onlyTrashed()->orderBy('created_at', 'desc')->paginate($per_page);
        } else {
            $posts = $this->model::orderBy('created_at', 'desc')->paginate($per_page);
        }

        $all_count = $this->model::all()->count();
        $trash_count = $this->model::onlyTrashed()->count();

        return view('cms.post.list')->with([
			'module' => $this->module,
            'posts' => $posts,
            'all_count' => $all_count,
            'trash_count' => $trash_count
        ]);
    }

	/***************************************************************************
	* @view
	* Form create
	****************************************************************************/
    public function post_new(Request $request) {
        return view('cms.post.create')
        ->with([
			'module' => $this->module
		]);
    }

	/***************************************************************************
	* @action
	* Save data from form create
	***************************************************************************/
    public function post_save(Request $request) {
        // validate the data
        $request->validate([
            'title' => 'required|max:255'
        ]);

        // store in the database
        $post = new $this->model;

		if( count( $this->module->fields ) ) {
			foreach( $this->module->fields as $key => $data ) {
				$post->$key = $request->input($key);
			}
		}

		$post->title = $request->input('title');
        $post->slug = $request->input('slug');
		$post->status = $request->input('status');
		$post->author = Auth::id();

        $post->save();

        Session::flash('success', 'Item created!');

        return redirect()->route('cms.post_edit', ['module'=>$this->module->slug,'post'=>$post->id]);
    }

	/***************************************************************************
	* @view
	* Show item data
	***************************************************************************/
	public function post_view(Request $request) {

		$post = $this->model::findOrFail($request->get('post'));

		if( count( $this->module->fields ) ) {
			foreach( $this->module->fields as $key => $data ) {
				if( !empty( $data['_constraint'] ) ) {
					$module_from_id = $this->module->id;
					$post_from_id = $post->id;
					$module_to_id_raw = DB::table('cms_module')
									->select('id')
									->where('slug',$data['_constraint'])
									->get();
					$module_to_id = $module_to_id_raw->toArray();
					$post_to_id_raw = DB::table('cms_module_constraint')
									->select('post_to_id as id')
									->where([
										['module_from_id', '=', $module_from_id],
										['post_from_id', '=', $post_from_id],
										['module_to_id', '=', $module_to_id[0]->id]
									])
									->get();
					$temp_array = [];
					if( !empty($post_to_id_raw->toArray()) ) {
						foreach( $post_to_id_raw->toArray() as $post_to_id ) {
							array_push( $temp_array, $post_to_id->id );
						}
					}
					$post->$key = $temp_array;
				}
			}
		}

		$author = User::find( $post->author_id )->first();

        return view('cms.post.view')
        ->with([
			'module' => $this->module,
            'post' => $post,
			'author' => $author
        ]);
	}

	/***************************************************************************
	* @view
	* Form edit item
	***************************************************************************/
    public function post_edit(Request $request) {

        $post = $this->model::findOrFail($request->get('post'));

		if( count( $this->module->fields ) ) {
			foreach( $this->module->fields as $key => $data ) {
				if( !empty( $data['_constraint'] ) ) {
					$module_from_id = $this->module->id;
					$post_from_id = $post->id;
					$module_to_id_raw = DB::table('cms_module')
									->select('id')
									->where('slug',$data['_constraint'])
									->get();
					$module_to_id = $module_to_id_raw->toArray();
					$post_to_id_raw = DB::table('cms_module_constraint')
									->select('post_to_id as id')
									->where([
										['module_from_id', '=', $module_from_id],
										['post_from_id', '=', $post_from_id],
										['module_to_id', '=', $module_to_id[0]->id]
									])
									->get();
					$temp_array = [];
					if( !empty($post_to_id_raw->toArray()) ) {
						foreach( $post_to_id_raw->toArray() as $post_to_id ) {
							array_push( $temp_array, $post_to_id->id );
						}
					}
					$post->$key = $temp_array;
				}
			}
		}

		$author = User::find( $post->author_id )->first();

        return view('cms.post.edit')
        ->with([
			'module' => $this->module,
            'post' => $post,
			'author' => $author
        ]);
    }

	/***************************************************************************
	* @action
	* Save data from form edit
	***************************************************************************/
    public function post_update(Request $request) {

        // validate the data
        $request->validate([
            'title' => 'required|max:255'
        ]);

        // store in the database
		$post = $this->model::findOrFail($request->input('post'));

		if( count( $this->module->fields ) ) {
			foreach( $this->module->fields as $key => $data ) {
				/* asign normal data */
				if( !is_array( $request->input($key) ) ) {
					$post->$key = $request->input($key);
				}
				/* update foreign keys (module object data) */
				if( !empty( $data['_constraint'] ) && !empty($request->input($key)) ) {
					$module_from_id = $this->module->id;
					$post_from_id = $post->id;
					$module_to_id_raw = DB::table('cms_module')
									->select('id')
									->where('slug',$data['_constraint'])
									->get();
					$module_to_id = $module_to_id_raw->toArray();
					/* delete old keys */
					DB::table('cms_module_constraint')
					->where([
						['module_from_id', '=', $module_from_id],
						['post_from_id', '=', $post_from_id],
						['module_to_id', '=', $module_to_id[0]->id]
					])
					->delete();
					/* insert new keys */
					foreach( $request->input($key) as $post_to_id ) {
						DB::table('cms_module_constraint')->insert([
							'module_from_id' => $module_from_id,
							'post_from_id' => $post_from_id,
							'module_to_id' => $module_to_id[0]->id,
							'post_to_id' => intval($post_to_id),
						]);
					}
				}
			}
		}

		$post->title = $request->input('title');
        $post->slug = $request->input('slug');
		$post->status = $request->input('status');

        $post->save();

        Session::flash('success', 'Item updated!');

        return redirect()->route('cms.post_edit', [
			'module' => $this->module->slug,
            'post' => $post
        ]);
    }

	/***************************************************************************
	* @action
	* Delete item
	***************************************************************************/
    public function post_delete(Request $request) {

        // store in the database
		$post = $this->model::withTrashed()->findOrFail($request->input('post'));

        if ($post->trashed()) {
			// hard delete post's constraint
			DB::table('cms_module_constraint')
			->where([
				['module_from_id', '=', $this->module->id],
				['post_from_id', '=', $post->id]
			])
			->orWhere([
				['module_to_id', '=', $this->module->id],
				['post_to_id', '=', $post->id]
			])
			->delete();
			// hard delete post
            $post->forceDelete();
            Session::flash('success', 'Item deleted!');
        } else {
			// soft delete post's constraint
			DB::table('cms_module_constraint')
			->where([
				['module_to_id', '=', $this->module->id],
				['post_to_id', '=', $post->id]
			])
			->update(['deleted_at' => date("Y-m-d H:i:s")]);
			// soft delete post
            $post->delete();
            Session::flash('warning', 'Item moved to trash! <a href="'. route("cms.post_restore", ['module'=>$this->module->slug,'post'=>$post->id]) .'">(Undo)</a>');
        }

        return redirect()->route('cms.post_list', ['module'=>$this->module->slug]);
    }

	/***************************************************************************
	* @action
	* Restore item from soft delete
	***************************************************************************/
    public function post_restore(Request $request) {

        $post = $this->model::onlyTrashed()->findOrFail($request->input('post'));

		// restore post's constraint
		DB::table('cms_module_constraint')
		->where([
			['module_to_id', '=', $this->module->id],
			['post_to_id', '=', $post->id]
		])
		->update(['deleted_at' => NULL]);

        if ($post->trashed()) {
            $post->restore();
            Session::flash('success', 'Item restored!');
        }

        return redirect()->route('cms.post_list', ['module'=>$this->module->slug]);
    }

}
