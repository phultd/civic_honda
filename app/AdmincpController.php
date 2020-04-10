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

class AdmincpController extends Controller
{
	/*
	* Dashboard
	*/
    public function index() {
		$last_password_changed = Carbon::parse( Auth::user()->last_password_changed );
		$password_life_time = $last_password_changed->diffInDays( Carbon::now() );
		if( Auth::user()->role == 1 ) {
			$active_user = DB::table('users')->where('locked_status',0)->orWhere('locked_status',2)->count();
			$locked_user = DB::table('users')->where('locked_status',1)->orWhere('locked_status',3)->orWhere('locked_status',4)->count();
			return view('panel.index')->with([
				'active_user' => $active_user,
				'locked_user' => $locked_user,
				'password_life_time' => $password_life_time,
			]);
		} else {
			return view('panel.index')->with([
				'password_life_time' => $password_life_time,
			]);
		}
    }



    /***************************************************************************
	* USER MANAGEMENT
	***************************************************************************/
    /*
    * Show user list
    */
    public function user_list() {
        $users = DB::table('users')->get();
		return view('panel.user.list')->with([
            'users' => $users
        ]);
	}

    /*
    * Show user detail
    */
    public function user_edit(Request $request) {
		$user = DB::table('users')->where('id', $request->route('user'))->first();

        if( $user !== null ) {
            return view('panel.user.edit')->with([
                'user' => $user
            ]);
        } else {
            return redirect()->route('admincp.index');
        }
    }

    /*
    * Save password
    */
    public function user_save(Request $request) {
			// validate the data
			$validator = Validator::make($request->all(), [
				'new_password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/'],
			],[
				'new_password.regex' => 'The :attribute must have character: Uppercase, lowercase, number and special character'
			]);

			if ($validator->fails()) {
				return redirect()->back()
				->withErrors($validator);
			}
			$user_id = $request->route('user');
			$obj_user = User::find($user_id);
			$obj_user->password = Hash::make($request->input('new_password'));
            $obj_user->last_login = date("Y-m-d H:i:s");
            $obj_user->last_password_changed = date("Y-m-d H:i:s");
            $obj_user->locked_status = 0;
            $obj_user->updated_at = date("Y-m-d H:i:s");
			$obj_user->save();

            Session::flash('success', 'Success');
            return redirect()->back();
    }

    /*
    * Lock user
    */
    public function user_lock(Request $request) {
        $user_id = $request->route('user');
        $obj_user = User::find($user_id);
        $obj_user->locked_status = 4;
        $obj_user->updated_at = date("Y-m-d H:i:s");
        $obj_user->save();

        Session::flash('success', 'Success');
        return redirect()->back();
    }

    /*
    * Delete user
    */
    public function user_delete(Request $request) {
        $user_id = $request->route('user');
        $obj_user = User::where('id', $user_id)->delete();

        Session::flash('success', 'Success');
        return redirect()->route('admincp.user.list');
    }



	/***************************************************************************
	* CHANGE PASSWORD
	***************************************************************************/
	/*
	* Show form change password
	*/
	public function show_change_password_form() {
		return view('panel.change_password');
	}

	/*
	* change password
	*/
	public function change_password( Request $request ) {
		if( Auth::check() ) {
			// validate the data
			$validator = Validator::make($request->all(), [
				'current_password' => ['required', 'string', 'min:8'],
				'new_password' => ['required', 'string', 'min:8', 'confirmed', 'different:current_password', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/'],
			],[
				'new_password.regex' => 'The :attribute must have character: Uppercase, lowercase, number and special character'
			]);

			if ($validator->fails()) {
				return redirect()->back()
				->withErrors($validator);
			}

			if(Hash::check($request->input('current_password'), Auth::User()->password)) {
				$user_id = Auth::User()->id;
				$obj_user = User::find($user_id);
				$obj_user->password = Hash::make($request->input('new_password'));
                $obj_user->last_password_changed = date("Y-m-d H:i:s");
                if( $obj_user->locked_status == 2 ) {
                    $obj_user->locked_status = 0;
                }
                $obj_user->updated_at = date("Y-m-d H:i:s");
				$obj_user->save();

                Auth::logout();
                Session::flash('success', 'Password changed. Login with new password.');
                return redirect()->route('admincp.login');
			} else {
				Session::flash('danger', 'Current password mismatch.');
			}
		} else {
			Session::flash('danger', 'Not authenticated.');
		}
		return redirect()->route('admincp.password.change');
	}


    /***************************************************************************
    * BANNER
    ****************************************************************************/

	/*
	* View form edit Banner
	*/
	public function banner_edit() {
		$banner = DB::table('banner')->where('id', 1)->first();
        return view('panel.banner')->with([
			'banner' => $banner
		]);
    }

	/*
	* Save Banner
	*/
	public function banner_update( Request $request ) {
		// validate the data
		$validator = Validator::make($request->all(), [
			'banner' => ['required', 'max:255'],
			'banner_mobile' => ['required', 'max:255'],
			'popup_type' => ['max:255'],
			'popup_image' => ['max:255'],
			'popup_video' => ['max:255'],
			'explore_link' => ['max:255'],
			'trial_link' => ['max:255'],
		]);

		if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

		DB::table('banner')
            ->where('id',1)
            ->update([
				'banner' => clean( $request->input('banner') ),
				'banner_mobile' => clean( $request->input('banner_mobile') ),
				'popup_type' => clean( $request->input('popup_type') ),
				'popup_image' => clean( $request->input('popup_image') ),
				'popup_video' => clean( $request->input('popup_video') ),
				'explore_link' => clean( $request->input('explore_link') ),
				'trial_link' => clean( $request->input('trial_link') ),
			]);

		$banner = DB::table('banner')->where('id', 1)->first();

		Session::flash('success', 'Success');

        return redirect()->route('admincp.banner.edit')->with(['banner'=>$banner]);

    }



    /***************************************************************************
    * MESSAGE
    ****************************************************************************/

	/*
	* View form edit Message
	*/
	public function message_edit() {
		$message = DB::table('message')->where('id', 1)->first();
        return view('panel.message')->with([
			'message' => $message
		]);
    }

	/*
	* Save Message
	*/
	public function message_update( Request $request ) {
		// validate the data
		$validator = Validator::make($request->all(), [
			'section_title' => ['required', 'max:255'],
			'section_description' => ['required', 'max:1000'],
		]);

		if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

		DB::table('message')
            ->where('id',1)
            ->update([
				'section_title' => clean( $request->input('section_title') ),
				'section_description' => clean( $request->input('section_description') ),
			]);

		$message = DB::table('message')->where('id', 1)->first();

		Session::flash('success', 'Success');

        return redirect()->route('admincp.message.edit')->with(['message'=>$message]);

    }



    /***************************************************************************
    * SAFETY
    ****************************************************************************/

	/*
	* View form edit Safety
	*/
	public function safety_edit() {
		$safety_items = DB::table('safety_item')->orderBy('order', 'desc')->get();
        return view('panel.safety.safety')->with([
			'safety_items' => $safety_items
		]);
    }

	/*
	* View form Add New Safety Item
	*/
	public function safety_add_item() {
        return view('panel.safety.safety_add_item');
    }

	/*
	* Save Safety Item
	*/
	public function safety_save_item( Request $request ) {
		// validate the data
		$validator = Validator::make($request->all(), [
			'title' => ['required', 'max:255'],
			'description' => ['required', 'max:1000'],
			'image' => ['required', 'max:255'],
			'image_mobile' => ['required', 'max:255'],
		]);

		if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

		$id = DB::table('safety_item')->insertGetId([
			'title' => clean( $request->input( 'title' ) ),
			'description' => clean( $request->input( 'description' ) ),
			'image' => clean( $request->input( 'image' ) ),
			'image_mobile' => clean( $request->input( 'image_mobile' ) ),
			'order' => clean( $request->input( 'order' ) ),
		]);

		Session::flash('success', 'Success');

		return redirect()->route('admincp.safety.item.edit', ['item'=>$id]);

    }

	/*
	* View form edit Safety Item
	*/
	public function safety_item_edit( Request $request ) {
		$safety = DB::table('safety_item')->where('id', $request->route('item'))->first();
        return view('panel.safety.safety_item_edit')->with([
			'safety' => $safety
		]);
    }

	/*
	* Update Safety Item
	*/
	public function safety_item_save( Request $request ) {
		// validate the data
		$validator = Validator::make($request->all(), [
			'title' => ['required', 'max:255'],
			'description' => ['required', 'max:1000'],
			'image' => ['required', 'max:255'],
			'image_mobile' => ['required', 'max:255'],
		]);

		if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

		DB::table('safety_item')
            ->where('id',$request->route('item'))
            ->update([
				'title' => clean( $request->input( 'title' ) ),
				'description' => clean( $request->input( 'description' ) ),
				'image' => clean( $request->input( 'image' ) ),
				'image_mobile' => clean( $request->input( 'image_mobile' ) ),
				'order' => clean( $request->input( 'order' ) ),
			]);

		Session::flash('success', 'Success');

        return redirect()->route('admincp.safety.item.edit',['item'=>$request->route('item')]);

    }

	/*
	* Delete Safety Item
	*/
	public function safety_item_delete( Request $request ) {

		DB::table('safety_item')->where('id', $request->route('item'))->delete();

		Session::flash('success', 'Success');

        return redirect()->route('admincp.safety.edit');

    }



    /***************************************************************************
    * SPECIFICATION
    ****************************************************************************/

	/*
	* View form edit Specification
	*/
	public function specification_edit() {
		$specification = DB::table('specification')->where('id', 1)->first();
        return view('panel.specification')->with([
			'specification' => $specification
		]);
    }

	/*
	* Save Specification
	*/
	public function specification_save( Request $request ) {
		// validate the data
		$validator = Validator::make($request->all(), [
			'specification' => ['required'],
		]);

		if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

		DB::table('specification')
            ->where('id',1)
            ->update([
				'specification' => clean( $request->input('specification') ),
			]);

		$specification = DB::table('specification')->where('id', 1)->first();

		Session::flash('success', 'Success');

        return redirect()->route('admincp.specification.edit')->with(['specification'=>$specification]);

    }



    /***************************************************************************
    * HYPERLINK
    ****************************************************************************/

	/*
	* List Hyperlink
	*/
	public function hyperlink_list() {
		$links = DB::table('hyperlink')->get();
        return view('panel.hyperlink.list')->with([
			'links' => $links
		]);
    }

    /*
	* View form edit Hyperlink
	*/
	public function hyperlink_edit(Request $request) {
		$link = DB::table('hyperlink')->where('id',$request->route('link'))->first();
        return view('panel.hyperlink.edit')->with([
			'link' => $link
		]);
    }

	/*
	* Save Hyperlink
	*/
	public function hyperlink_save( Request $request ) {
		// validate the data
		$validator = Validator::make($request->all(), [
			'title' => ['required', 'max:255'],
			'icon' => ['max:255'],
			'icon_hover' => ['max:255'],
            'url' => ['max:255'],
		]);

		if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

		DB::table('hyperlink')
            ->where('id',$request->route('link'))
            ->update([
				'title' => clean( $request->input('title') ),
				'icon' => clean( $request->input('icon') ),
				'icon_hover' => clean( $request->input('icon_hover') ),
				'url' => clean( $request->input('url') ),
			]);

		Session::flash('success', 'Success');

        return redirect()->route('admincp.hyperlink.edit', ['link'=>$request->route('link')]);

    }

}
