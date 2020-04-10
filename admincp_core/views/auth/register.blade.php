@extends('auth.layout')

@section('title'){{ __('Register') }}@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">

				<section class="form-gradient mt-4">
                    <div class="card">
						<div class="card-header">
							<h5 class="text-center">Register</h5>
						</div>
                        <div class="card-body">

							<form method="POST" action="{{ route('admincp.register') }}">
								@csrf

								{{-- error --}}
								@if ($errors->has('name') || $errors->has('email') || $errors->has('password'))
	                                <div class="alert alert-danger" role="alert">
	                                    @if ($errors->has('name'))
	                                        {{ $errors->first('name') }}
											<br>
	                                    @endif
										@if ($errors->has('username'))
	                                        {{ $errors->first('username') }}
	                                        <br>
	                                    @endif
	                                    @if ($errors->has('email'))
											{{ $errors->first('email') }}
	                                        <br>
	                                    @endif
	                                    @if ($errors->has('password'))
											{{ $errors->first('password') }}
	                                    @endif
	                                </div>
	                            @endif

								{{-- name --}}
								<div class="md-form form-sm">
								  	<input type="text" id="name" name="name" class="form-control form-control-sm" value="{{ old('name') }}">
								  	<label for="name">Display Name</label>
								</div>

								{{-- username --}}
								<div class="md-form form-sm">
								  	<input type="text" id="username" name="username" class="form-control form-control-sm" value="{{ old('username') }}">
								  	<label for="username">Username</label>
								</div>

								{{-- email --}}
								<div class="md-form form-sm">
								  	<input type="email" id="email" name="email" class="form-control form-control-sm" value="{{ old('email') }}">
								  	<label for="email">Email Address</label>
								</div>

                                {{-- role --}}
								<label for="role">User Role</label>
                                <select class="mdb-select md-form" name="role" id="role">
                                    <option value="2" selected>Editor</option>
                                    <option value="1">Administrator</option>
                                </select>

								{{-- password --}}
								<div class="md-form form-sm">
								  	<input type="password" id="password" name="password" class="form-control form-control-sm">
								  	<label for="password">Password</label>
								</div>

								{{-- password confirm --}}
								<div class="md-form form-sm">
								  	<input type="password" id="password_confirmation" name="password_confirmation" class="form-control form-control-sm">
								  	<label for="password_confirmation">Confirm Password</label>
								</div>

								<div class="text-center mt-2">
									<button type="submit" class="btn btn-primary">REGISTER</button>
								</div>

							</form>

							@if (Route::has('admincp.login'))
                                <hr class="my-4">
                                <a href="{{ route('admincp.login') }}" class="text-info">Back To Login</a>
                            @endif

                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
@endsection
