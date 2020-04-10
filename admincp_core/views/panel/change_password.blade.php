@extends('panel.layout')

@section('title'){{ __('Change Password') }}@endsection

@section('content')

<h4>Change Password</h4><br>

<form action="{{ route('admincp.password.change') }}" method="post" autocomplete="off">
	@csrf
	@method('patch')

	{{-- password --}}
	<div class="row">
		<div class="col-md-3">
			<div class="md-form form-sm">
				<input type="password" id="current_password" name="current_password" class="form-control form-control-sm">
				<label for="current_password">Current Password</label>
			</div>
		</div>
	</div>

	{{-- new password --}}
	<div class="row">
		<div class="col-md-3">
			<div class="md-form form-sm">
				<input type="password" id="new_password" name="new_password" class="form-control form-control-sm">
				<label for="new_password">New Password</label>
			</div>
		</div>
	</div>

	{{-- password confirm --}}
	<div class="row">
		<div class="col-md-3">
			<div class="md-form form-sm">
				<input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-control form-control-sm">
				<label for="new_password_confirmation">Confirm New Password</label>
			</div>
		</div>
	</div>

	{{-- button group --}}
	<div class="button-group mt-5">
		<button type="submit" class="btn blue-gradient">Save</button>
	</div>

</form>

@endsection
