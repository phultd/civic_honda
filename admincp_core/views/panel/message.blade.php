@extends('panel.layout')

@section('title'){{ __('Thông điệp') }}@endsection

@section('content')

<h4>Thông điệp</h4><br>

<form action="{{ route('admincp.message.update') }}" method="post">
	@csrf

	{{-- section title --}}
	<div class="card mb-3">
		<div class="card-header">
			Section Title
		</div>
		<div class="card-body">
			<div class="md-form">
				<input type="text" id="section_title" name="section_title" class="form-control"
				value="@if( old('section_title') ){{ old('section_title') }}@elseif( !empty($message) && $message->section_title ){{ $message->section_title }}@endif">
				<label for="popup_video">Input Section Title</label>
			</div>

		</div>
	</div>

	{{-- section description --}}
	<div class="card mb-3">
		<div class="card-header">
			Section Description
		</div>
		<div class="card-body">
			<div class="md-form">
				<input type="text" id="section_description" name="section_description" class="form-control"
				value="@if( old('section_description') ){{ old('section_description') }}@elseif( !empty($message) && $message->section_description ){{ $message->section_description }}@endif">
				<label for="popup_video">Input Section Description</label>
			</div>

		</div>
	</div>

	{{-- button group --}}
	<div class="button-group mt-5">
		<button type="submit" class="btn blue-gradient">Save</button>
	</div>

</form>

@endsection
