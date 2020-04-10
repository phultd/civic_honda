<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Session;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('auth');
        $this->middleware('can_register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
			'username' => ['required', 'max:255', 'unique:users', 'regex:/^[0-9A-Za-z.\-_]+$/'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/'],
			'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'min:1', 'max:2'],
        ],[
			'password.regex' => 'The :attribute must have character: Uppercase, lowercase, number and special character'
		]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
			'username' => $data['username'],
			'email' => $data['email'],
			'password' => Hash::make($data['password']),
            'name' => $data['name'],
            'role' => $data['role'],
            'last_login' => date("Y-m-d H:i:s"),
            'last_password_changed' => date("Y-m-d H:i:s"),
            'locked_status' => 0,
        ]);
    }

	/*
	* Disable auto logged in after registration
	*/
	public function register(Request $request)
	{
	    $this->validator($request->all())->validate();

	    event(new Registered($user = $this->create($request->all())));

	    // $this->guard()->login($user);

        Session::flash('success', 'User created');

	    return $this->registered($request, $user) ?: redirect()->route('admincp.user.list');
	}

}
