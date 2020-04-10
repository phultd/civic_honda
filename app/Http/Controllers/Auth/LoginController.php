<?php

namespace App\Http\Controllers\Auth;

use DB;
use Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admincp';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        // $this->middleware('not_locked')->except('logout');
    }

	/*
	* Allow to authenticate via username
	*/
	public function username()
	{
		$account = request()->input('account');
	    $field = filter_var($account, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
	    request()->merge([$field => $account]);
	    return $field;
	}

    /*
    * Custom login throttling
    */
    public function login( Request $request ) {
        $account = request()->input('account');
	    $field = filter_var($account, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $password = $request->input('password');

        $user = DB::table('users')->select('locked_status')->where($field,$account)->first();

        if( $user === null ) {
            Session::flash('danger', 'Credentials mismatch.');
            return redirect()->route('admincp.login');
        }

        switch( $user->locked_status ) {
            case 1:
                Session::flash('danger', 'Account <b>'.$account.'</b> has been locked due to failed login attemps.');
                return redirect()->route('admincp.login');
                break;
            case 3:
                Session::flash('danger', 'Account <b>'.$account.'</b> has been locked due to inactivity for more than 100 days.');
                return redirect()->route('admincp.login');
                break;
            case 4:
                Session::flash('danger', 'Account <b>'.$account.'</b> has been locked for security purposes.');
                return redirect()->route('admincp.login');
                break;
            default:
        }

        if (Auth::attempt([$field => $account, 'password' => $password])) {
            $this->clearLoginAttempts($request);
            // check for expired password. lock user if expired
            $last_password_changed = Carbon::parse( Auth::user()->last_password_changed );
            $password_life_time = $last_password_changed->diffInDays( Carbon::now() );
            if( $password_life_time >= 90 ) {
                $locked = DB::table('users')
                ->where('id',Auth::user()->id)
                ->update([
    				'locked_status' => 2
    			]);
                if( $locked ) {
                    Session::flash('danger', 'Your password has expired. Change password.');
                    return redirect()->route('admincp.password.change');
                }
            }

            // check for inactivity. lock user if inactivity for more than 100 days
            $last_login = Carbon::parse( Auth::user()->last_login );
            $inactivity = $last_login->diffInDays( Carbon::now() );
            if( $inactivity >= 100 ) {
                $locked = DB::table('users')
                ->where('id',Auth::user()->id)
                ->update([
    				'locked_status' => 3
    			]);
                if( $locked ) {
                    Auth::logout();
                    Session::flash('danger', 'Account <b>'.$account.'</b> has been locked due to inactivity for more than 100 days.');
                    return redirect()->route('admincp.login');
                }
            }

            // update last login date
            DB::table('users')
            ->where('id',Auth::user()->id)
            ->update([
                'last_login' => Carbon::now()
            ]);

			// logout other devices
			Auth::logoutOtherDevices($password);

            return redirect()->route('admincp.index');
        } else {
            $this->incrementLoginAttempts($request);
        }

        $attemps_count = $this->limiter()->attempts($this->throttleKey($request));

        // lock if failed login 10 times
        if( $attemps_count >= 10 ) {
            // lock user
            $locked = DB::table('users')
            ->where($field,$account)
            ->update([
				'locked_status' => 1
			]);
            if( $locked ) {
                Session::flash('danger', 'Account <b>'.$account.'</b> has been locked due to many failed login attemps.');
            }
        } else {
            Session::flash('danger', 'Credentials mismatch. ( '.$attemps_count.' attemps)');
        }

        return redirect()->route('admincp.login');
    }

}
