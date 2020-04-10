@extends('panel.layout')

@section('title'){{ __('Dashboard') }}@endsection

@section('content')

<h4>Dashboard</h4><br>

<p>You are currently logged in as <b class="text-primary">{{ Auth::user()->username }}</b></p>

@if( isset( $active_user ) and isset( $locked_user ) )
<p><span class="badge badge-light">{{ $active_user }}</span> active user.</p>
<p><span class="badge badge-light">{{ $locked_user }}</span> locked user.</p>
@endif

@if( $password_life_time < 90 )
	<p>Your password will expire in <span class="badge badge-light">{{ 90 - $password_life_time }}</span> days.</p>
@endif

@endsection
