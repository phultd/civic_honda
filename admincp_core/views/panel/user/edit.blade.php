@extends('panel.layout')

@section('title'){{ __('Edit Users') }}@endsection

@section('content')

<h4>Edit Users</h4><br>

@if( $user->id != Auth::user()->id )
<form action="{{ route('admincp.user.save',['user'=>$user->id]) }}" method="post" autocomplete="off">
	@csrf
@endif
    <div class="row">
        <div class="col-md-1">Username:</div>
        <div class="col-md-11"><b>{{ $user->username }} @if( $user->id == Auth::user()->id )<small class="text-info">(currently logged in)</small>@endif</b></div>
    </div>
    <div class="row">
        <div class="col-md-1">Email:</div>
        <div class="col-md-11"><b>{{ $user->email }}</b></div>
    </div>
    <div class="row">
        <div class="col-md-1">Role:</div>
        <div class="col-md-11"><b>{{ $user->role == 1 ? 'Administrator' : 'Editor' }}</b></div>
    </div>
    <div class="row">
        <div class="col-md-1">Status:</div>
        <div class="col-md-11"><b>{!! $user->locked_status == 0 ? '<span class="text-success">Active</span>' : '<span class="text-danger">Locked</span>' !!}</b></div>
    </div>
	@if( $user->locked_status != 0 )
	<div class="row">
        <div class="col-md-1">Lock Reason:</div>
        <div class="col-md-11 text-info"><b>
			@if( $user->locked_status == 1 )Failed login attemps (10 times) @endif
			@if( $user->locked_status == 2 )Login password expired after 90 days @endif
			@if( $user->locked_status == 3 )Inactivity for more than 100 days @endif
			@if( $user->locked_status == 4 )Locked by admin for security purposes @endif
		</b></div>
    </div>
	@endif
    @if( $user->id != Auth::user()->id )
    <br><br>

    <h5>Change User Password</h5>

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
		<button type="submit" class="btn blue-gradient">Change Password</button>
        @if( $user->locked_status == 0 )
        <button type="button" class="btn btn-warning text-danger" data-toggle="modal" data-target="#modal_lock">Lock User</button>
        @endif
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal_delete">Delete User</button>
	</div>

</form>

<form id="form_delete" class="d-none" action="{{ route('admincp.user.delete', ['user'=>$user->id]) }}" method="post">
	@csrf
	@method('delete')
</form>

@if( $user->locked_status == 0 )
<form id="form_lock" class="d-none" action="{{ route('admincp.user.lock', ['user'=>$user->id]) }}" method="post">
	@csrf
	@method('patch')
</form>

<div class="modal fade" id="modal_lock" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title">Confirm Lock</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			Are you sure to LOCK user?
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-warning text-danger" onclick="$('#form_lock').submit()">Lock</button>
		</div>
	</div>
</div>
</div>
@endif

<div class="modal fade" id="modal_delete" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title">Confirm Delete</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			Are you sure to DELETE user?
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-danger" onclick="$('#form_delete').submit()">Delete</button>
		</div>
	</div>
</div>
</div>
@endif

@endsection
