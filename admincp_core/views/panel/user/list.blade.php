@extends('panel.layout')

@section('title'){{ __('Users') }}@endsection

@section('content')

<h4>Users</h4>

<div class="button-group mb-2">
	<a href="{{ route('admincp.register') }}" type="button" class="btn btn-sm btn-primary">Add New</a>
</div>

<table class="table table-list table-striped table-bordered table-sm table-hover">
        <thead>
            <tr class="text-center">
				<th>No.</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>

			@forelse( $users as $user )
				<tr class="text-center">
					<td>
						{{ $loop->iteration }}
					</td>
	                <td>
						<a class="btn-link text-primary" href="{{ route('admincp.user.edit', ['user'=>$user->id]) }}">
							{{ $user->username }}
						</a>
					</td>
	                <td>
						{{ $user->email }}
					</td>
	                <td>{{ $user->role == 1 ? 'Administrator' : 'Editor' }}</td>
	                <td>{!! $user->locked_status == 0 ? '<span class="text-success">Active</span>' : '<span class="text-danger">Locked</span>' !!}</td>
	            </tr>
			@empty
				<tr><td colspan="5">{{ __('No data to display.') }}</td></tr>
            @endforelse

        </tbody>
    </table>

@endsection
