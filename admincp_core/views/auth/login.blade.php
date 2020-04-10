@extends('auth.layout')

@section('title'){{ __('Login') }}@endsection

@section('content')

    <div class="container login">
        <div class="row">
            <div class="col-xs-12 col-md-4 login__background">
            </div>
			<div class="col-xs-12 col-md-4">
				<section class="form-gradient mt-4">
                    <div class="card">
						<div class="card-header">
							<h5 class="text-center">Login</h5>
						</div>
                        <div class="card-body">

							<form method="POST" action="{{ route('admincp.login') }}">
								@csrf

                                @if( Session::has( 'success' ) )
                                    <div class="alert alert-success" role="alert">
                                        {!! Session::get( 'success' ) !!}
                                    </div>
                                @endif

                                @if( Session::has( 'danger' ) )
                                    <div class="alert alert-danger" role="alert">
                                        {!! Session::get( 'danger' ) !!}
                                    </div>
                                @endif

								{{-- error --}}
								@if ($errors->has('username') || $errors->has('email') || $errors->has('password'))
									<div class="alert alert-danger" role="alert">
										<strong>Error: </strong> Credentials mismatch.
									</div>
								@endif

								{{-- account --}}
								<div class="md-form form-sm">
								  	<input type="text" id="account" name="account" class="form-control form-control-sm" value="{{ old('account') }}">
								  	<label for="account">Username or Email address</label>
								</div>

								{{-- password --}}
								<div class="md-form form-sm">
								  	<input type="password" id="password" name="password" class="form-control form-control-sm" autocomplete="off">
								  	<label for="password">Password</label>
								</div>

								{{-- remember --}}
								<div class="form-check">
								    <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
								    <label class="form-check-label" for="remember">Remember Me</label>
								</div>

								<div class="text-center mt-2">
									<button type="submit" class="btn btn-primary">LOG IN</button>
								</div>

							</form>

                        </div>
                    </div>
                </section>
			</div>
        </div>
    </div>
@endsection
