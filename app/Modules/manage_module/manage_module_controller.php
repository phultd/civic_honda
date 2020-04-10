<?php

/*
* Table of content:
* module_list
* module_new
* module_save
* module_view
* module_edit
* module_update
* module_delete
*/

namespace App\Modules\manage_module;

use DB;
use Auth;
use Session;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\CliController;
use App\Modules\manage_module\manage_module_model;

class manage_module_controller extends CliController
{

	/***************************************************************************
	* @view
	* Listing all modules
	***************************************************************************/
    public function module_list() {
        $modules = manage_module_model::orderBy('created_at', 'asc')->get();

        $modules_count = manage_module_model::all()->count();

        return view('cms.module.list')->with([
            'modules' => $modules,
            'modules_count' => $modules_count
        ]);
    }

	/***************************************************************************
	* @view
	* Form create
	***************************************************************************/
    public function module_new() {

		// get all tables in db
		$tables_in_db = DB::select('SHOW TABLES');
    	$db = "Tables_in_".env('DB_DATABASE');
		// remove default tables from the avaiable list
		$chk_tables = [
			env('DB_PREFIX').'migrations',
			env('DB_PREFIX').'users',
			env('DB_PREFIX').'password_resets',
			env('DB_PREFIX').'cms_module',
			env('DB_PREFIX').'cms_module_field',
			env('DB_PREFIX').'cms_module_constraint',
		];
		// available tables for module to connect
        $tables = [];
        foreach($tables_in_db as $table){
			$table_in_use = manage_module_model::where('table_name', $table->{$db})->first();
			if( ! in_array( $table->{$db}, $chk_tables ) && empty( $table_in_use ) ) {
				$tables[] = $table->{$db};
			}
        }

		// get field type list
		$field_types = DB::table('cms_module_field')->get();

		// render
        return view('cms.module.create')
        ->with([
			'tables' => $tables,
			'field_types' => $field_types
		]);
    }

	/***************************************************************************
	* @action
	* Save data from form create
	***************************************************************************/
    public function module_save(Request $request) {
        // validate the data
		$validator = Validator::make($request->all(), [
			'title' => ['required', 'max:255'],
			'title_plural' => ['required', 'max:255'],
			'slug' => ['required', 'max:255', 'alpha_dash', 'unique:cms_module,slug'],
			'table_name' => ['required', 'max:255', 'alpha_dash', 'unique:cms_module,table_name'],
			'folder_name' => ['required', 'max:255', 'alpha_dash', 'unique:cms_module,folder_name']
		]);

		if ($validator->fails()) {
            return redirect()->route('cms.module_new')
                ->withErrors($validator)
                ->withInput();
        }

        // store in the database
		$module = new manage_module_model;

        $module->title = $request->input('title');
        $module->title_plural = $request->input('title_plural');
		$module->slug = $request->input('slug');
		$module->table_name = $request->input('table_name');
		$module->folder_name = str_replace( '-', '_', $request->input('folder_name') );
        $module->status = 1;

		// fetch input data fields
		$fields = [];
		$columns = \CHelper::get_fillable_columns($request->input('table_name'));
		if( count($columns) ) {
			foreach( $columns as $key => $column ) {
				$fields[ $column ] = [
					'_field_name' => $request->input($column.'_field_name'),
					'_field_type' => $request->input($column.'_field_type'),
					'_field_instruction' => $request->input($column.'_field_instruction'),
					'_field_note' => $request->input($column.'_field_note'),
					'_constraint' => $request->input($column.'_constraint'),
				];
			}
		}
		$module->fields = json_encode($fields);

		// create module folder
		$folder_name = str_replace( '-', '_', $request->input('folder_name'));
		$path = strtolower( app_path('Modules').'/'.$folder_name );
		if( ! is_dir( $path ) ) {
			mkdir($path, 0755, true);
		}

		// create module model
		$model_file_name = str_replace_first(env('DB_PREFIX'), '', $module->table_name).'_model.php';
		$model_file = fopen($path."/".$model_file_name, "w") or die("Unable to open file!");
		$model_file_content = view('cms.module.template.template_model')->with(['module' => $module]);
		fwrite($model_file, $model_file_content);
		fclose($model_file);

		// create module controller
		$controller_file_name = str_replace_first(env('DB_PREFIX'), '', $module->table_name).'_controller.php';
		$controller_file = fopen($path."/".$controller_file_name, "w") or die("Unable to open file!");
		$controller_file_content = view('cms.module.template.template_controller')->with(['module' => $module]);
		fwrite($controller_file, $controller_file_content);
		fclose($controller_file);

		// create module route
		$route_file = fopen($path."/routes.php", "w") or die("Unable to open file!");
		$route_file_content = view('cms.module.template.template_route')->with(['module' => $module]);
		fwrite($route_file, $route_file_content);
		fclose($route_file);

		// success
		$module->save();

        Session::flash('success', 'Module created!');

        return redirect()->route('cms.module_edit', ['module'=>$module->slug]);
    }

	/***************************************************************************
	* @view
	* Form edit item
	***************************************************************************/
    public function module_edit(Request $request) {
		$slug = $request->input('module');
        $module = manage_module_model::where('slug',$slug)->first();
		if( $module && $module->fields ) {
			$module->fields = json_decode($module->fields, true);
		}

		$tables_in_db = DB::select('SHOW TABLES');
    	$db = "Tables_in_".env('DB_DATABASE');
		$chk_tables = [
			env('DB_PREFIX').'migrations',
			env('DB_PREFIX').'users',
			env('DB_PREFIX').'password_resets',
			env('DB_PREFIX').'cms_module',
			env('DB_PREFIX').'cms_module_field',
			env('DB_PREFIX').'cms_module_constraint',
		];
        $tables = [];
        foreach($tables_in_db as $table){
			$table_in_use = manage_module_model::where([
				['table_name', '<>', $module->table_name],
				['table_name', '=', $table->{$db}]
			])->first();
			if( ! in_array( $table->{$db}, $chk_tables ) && empty( $table_in_use ) ) {
				$tables[] = $table->{$db};
			}
        }

		$field_types = DB::table('cms_module_field')->get();

		$columns = \CHelper::get_fillable_columns($module->table_name);

		$foreign_modules = DB::table('cms_module')->get();

        return view('cms.module.edit')
        ->with([
            'module' => $module,
			'field_types' => $field_types,
			'tables' => $tables,
			'columns' => $columns,
			'foreign_modules' => $foreign_modules
        ]);
    }

	/***************************************************************************
	* @action
	* Update data from form edit
	***************************************************************************/
    public function module_update(Request $request) {

		$module = manage_module_model::where('slug',$request->module)->first();

		// validate the data
		$validator = Validator::make($request->all(), [
			'title' => ['required', 'max:255'],
			'title_plural' => ['required', 'max:255'],
			'slug' => ['required', 'max:255', 'alpha_dash', Rule::unique('cms_module','slug')->ignore($module->id,'id')],
			'table_name' => ['required', 'max:255', 'alpha_dash', Rule::unique('cms_module','table_name')->ignore($module->id)],
			'folder_name' => ['required', 'max:255', 'alpha_dash', Rule::unique('cms_module','folder_name')->ignore($module->id)]
		]);

		if ($validator->fails()) {
            return redirect()->route('cms.module_edit', ['module'=>$module->slug])
                ->withErrors($validator)
                ->withInput();
        }

        // store in the database

        $module->title = $request->input('title');
        $module->title_plural = $request->input('title_plural');
		$module->slug = $request->input('slug');
		$module->table_name = $request->input('table_name');
		$module->folder_name = $request->input('folder_name');
        $module->status = 1;

		// fetch input data fields
		$fields = [];
		$columns = \CHelper::get_fillable_columns($request->input('table_name'));
		if( count($columns) ) {
			foreach( $columns as $key => $column ) {
				$fields[ $column ] = [
					'_field_name' => $request->input($column.'_field_name'),
					'_field_type' => $request->input($column.'_field_type'),
					'_field_instruction' => $request->input($column.'_field_instruction'),
					'_field_note' => $request->input($column.'_field_note'),
					'_constraint' => $request->input($column.'_constraint'),
				];
			}
		}
		$module->fields = json_encode($fields);

		// create module folders, files
		$folder_name = str_replace( ' ', '_', $request->input('folder_name'));
		$path = strtolower( app_path('Modules').'/'.$folder_name );
		if( ! is_dir( $path ) ) {
			mkdir($path, 0755, true);
		}

		// success
		$module->save();

        Session::flash('success', 'Module updated!');

        return redirect()->route('cms.module_edit', ['module'=>$module->slug]);
    }

	/***************************************************************************
	* @action
	* Delete item
	***************************************************************************/
    public function module_delete(Request $request) {
        $module = manage_module_model::where('slug', $request->input('module'))->first();

		// delete this module files and folder
		array_map( 'unlink', glob( app_path('Modules').'/'.$module->folder_name.'/*.*' ) );
		rmdir( app_path('Modules').'/'.$module->folder_name );

		// delete constraints relate to this module
		DB::table('cms_module_constraint')
		->where('module_from_id', $module->id)
		->orWhere('module_to_id', $module->id)
		->delete();

		// delete module in database
		$module->forceDelete();
		Session::flash('success', 'Module deleted!');

        return redirect()->route('cms.module_list');
    }

}
