@extends('panel.layout')

@section('title'){{ __('Banner') }}@endsection

@section('content')

<h4>Banner</h4><br>

<form action="{{ route('admincp.banner.update') }}" method="post" autocomplete="off">
	@csrf

	{{-- banner image --}}
	<div class="card mb-3">
		<div class="card-header">
			Banner Image
		</div>
		<div class="card-body">
			<div class="md-form">
				<button id="banner" type="button" class="btn btn-primary btn-sm btn-wysiwyg">Select Image</button>
				<input type="text" hidden name="banner"
				value="@if( old('banner') )
					{{ old('banner') }}
				@elseif( !empty($banner) && $banner->banner )
					{{ $banner->banner }}
				@endif">

				<div class="image-preview">
					@if( old('banner') )
						<img class="img-thumbnail" src="{{ url( old('banner') ) }}">
						<a type="button" class="btn-floating btn-sm btn-warning btn-wysiwyg-remove"><i class="fa fa-trash-o"></i></a>
					@elseif( !empty($banner) && $banner->banner )
						<img class="img-thumbnail" src="{{ url( $banner->banner ) }}">
						<a type="button" class="btn-floating btn-sm btn-warning btn-wysiwyg-remove"><i class="fa fa-trash-o"></i></a>
					@else
					<span>No image selected</span>
					@endif
				</div>
			</div>

		</div>
	</div>

	{{-- banner image mobile --}}
	<div class="card mb-3">
		<div class="card-header">
			Banner Image Mobile
		</div>
		<div class="card-body">
			<div class="md-form">
				<button id="banner_mobile" type="button" class="btn btn-primary btn-sm btn-wysiwyg">Select Image</button>
				<input type="text" hidden name="banner_mobile"
				value="@if( old('banner_mobile') )
					{{ old('banner_mobile') }}
				@elseif( !empty($banner) && $banner->banner_mobile )
					{{ $banner->banner_mobile }}
				@endif">

				<div class="image-preview">
					@if( old('banner_mobile') )
						<img class="img-thumbnail" src="{{ url( old('banner_mobile') ) }}">
						<a type="button" class="btn-floating btn-sm btn-warning btn-wysiwyg-remove"><i class="fa fa-trash-o"></i></a>
					@elseif( !empty($banner) && $banner->banner_mobile )
						<img class="img-thumbnail" src="{{ url( $banner->banner_mobile ) }}">
						<a type="button" class="btn-floating btn-sm btn-warning btn-wysiwyg-remove"><i class="fa fa-trash-o"></i></a>
					@else
					<span>No image selected</span>
					@endif
				</div>
			</div>

		</div>
	</div>

	{{-- popup type --}}
	<div class="card mb-3">
		<div class="card-header">
			Popup Type
		</div>
		<div class="card-body">
			<div class="form-check">
				<input type="radio" class="form-check-input" id="popup_type_1" name="popup_type" value="image"
				@if( old('popup_type') && old('popup_type') == 'image' )
					checked
				@elseif( !empty($banner) && $banner->popup_type == 'image' )
					checked
				@elseif( !empty($banner) && empty($banner->popup_type ) )
					checked
				@endif>
				<label class="form-check-label" for="popup_type_1">Static Image</label>
			</div>

			<div class="form-check">
				<input type="radio" class="form-check-input" id="popup_type_2" name="popup_type" value="tvc"
				@if( old('popup_type') && old('popup_type') == 'tvc' )
					checked
				@elseif( !empty($banner) && $banner->popup_type == 'tvc' )
					checked
				@endif>
				<label class="form-check-label" for="popup_type_2">Youtube TVC</label>
			</div>

		</div>
	</div>


	{{-- popup image --}}
	<div class="card mb-3">
		<div class="card-header">
			Popup Image
		</div>
		<div class="card-body">
			<div class="md-form">
				<button id="popup_image" type="button" class="btn btn-primary btn-sm btn-wysiwyg">Select Image</button>
				<input type="text" hidden name="popup_image"
				value="@if( old('popup_image') )
					{{ old('popup_image') }}
				@elseif( !empty($banner) && $banner->popup_image )
					{{ $banner->popup_image }}
				@endif">

				<div class="image-preview">
					@if( old('popup_image') )
						<img class="img-thumbnail" src="{{ url( old('popup_image') ) }}">
						<a type="button" class="btn-floating btn-sm btn-warning btn-wysiwyg-remove"><i class="fa fa-trash-o"></i></a>
					@elseif( !empty($banner) && $banner->popup_image )
						<img class="img-thumbnail" src="{{ url( $banner->popup_image ) }}">
						<a type="button" class="btn-floating btn-sm btn-warning btn-wysiwyg-remove"><i class="fa fa-trash-o"></i></a>
					@else
					<span>No image selected</span>
					@endif
				</div>
			</div>

		</div>
	</div>

	{{-- popup youtube id --}}
	<div class="card mb-3">
		<div class="card-header">
			Popup Youtube Video ID
		</div>
		<div class="card-body">
			<div class="md-form">
				<input type="text" id="popup_video" name="popup_video" class="form-control"
				value="@if( old('popup_video') ){{ old('popup_video') }}@elseif( !empty($banner) && $banner->popup_video ){{ $banner->popup_video }}@endif">
				<label for="popup_video">Input Youtube Video ID</label>
			</div>

		</div>
	</div>

	{{-- explore now link --}}
	<div class="card mb-3">
		<div class="card-header">
			Explore Now Link
		</div>
		<div class="card-body">
			<div class="md-form">
				<input type="text" id="explore_link" name="explore_link" class="form-control"
				value="@if( old('explore_link') ){{ old('explore_link') }}@elseif( !empty($banner) && $banner->explore_link ){{ $banner->explore_link }}@endif">
				<label for="explore_link">Input Explore Now Link</label>
			</div>

		</div>
	</div>

	{{-- explore now link --}}
	<div class="card mb-3">
		<div class="card-header">
			Trial Link
		</div>
		<div class="card-body">
			<div class="md-form">
				<input type="text" id="trial_link" name="trial_link" class="form-control"
				value="@if( old('trial_link') ){{ old('trial_link') }}@elseif( !empty($banner) && $banner->trial_link ){{ $banner->trial_link }}@endif">
				<label for="explore_link">Input Trial Link</label>
			</div>

		</div>
	</div>

	{{-- button group --}}
	<div class="button-group mt-5">
		<button type="submit" class="btn blue-gradient">Save</button>
	</div>

</form>

@endsection
