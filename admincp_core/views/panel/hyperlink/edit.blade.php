@extends('panel.layout')

@section('title'){{ __('Edit Liên kết') }}@endsection

@section('content')

<h4>Edit Liên kết</h4><br>

<form action="{{ route('admincp.hyperlink.save', ['link'=>$link->id]) }}" method="post">
	@csrf

	{{-- link title --}}
	<div class="card mb-3">
		<div class="card-header">
			Title
		</div>
		<div class="card-body">
			<div class="md-form">
				<input type="text" id="title" name="title" class="form-control"
				value="@if( old('title') ){{ old('title') }}@elseif( !empty($link) && $link->title ){{ $link->title }}@endif">
				<label for="title">Input Title</label>
			</div>
		</div>
	</div>

	{{-- link url --}}
	<div class="card mb-3">
		<div class="card-header">
			URL
		</div>
		<div class="card-body">
			<div class="md-form">
				<input type="text" id="url" name="url" class="form-control"
				value="@if( old('url') ){{ old('url') }}@elseif( !empty($link) && $link->url ){{ $link->url }}@endif">
				<label for="url">Input URL</label>
			</div>
		</div>
	</div>

	{{-- icon --}}
	{{-- <div class="card mb-3">
		<div class="card-header">
			Icon
		</div>
		<div class="card-body">
			<div class="md-form">
				<button id="icon" type="button" class="btn btn-primary btn-sm btn-wysiwyg">Select Image</button>
				<input type="text" hidden name="icon"
				value="@if( old('icon') )
					{{ old('icon') }}
				@elseif( !empty($link) && $link->icon )
					{{ $link->icon }}
				@endif">

				<div class="image-preview">
					@if( old('icon') )
						<img class="img-thumbnail" src="{{ url( old('icon') ) }}">
						<a type="button" class="btn-floating btn-sm btn-warning btn-wysiwyg-remove"><i class="fa fa-trash-o"></i></a>
					@elseif( !empty($link) && $link->icon )
						<img class="img-icon" src="{{ url( $link->icon ) }}">
						<a type="button" class="btn-floating btn-sm btn-warning btn-wysiwyg-remove"><i class="fa fa-trash-o"></i></a>
					@else
					<span>No image selected</span>
					@endif
				</div>
			</div>

		</div>
	</div> --}}

	{{-- icon_hover --}}
	{{-- <div class="card mb-3">
		<div class="card-header">
			Icon Alternative
		</div>
		<div class="card-body">
			<div class="md-form">
				<button id="icon_hover" type="button" class="btn btn-primary btn-sm btn-wysiwyg">Select Image</button>
				<input type="text" hidden name="icon_hover"
				value="@if( old('icon_hover') )
					{{ old('icon_hover') }}
				@elseif( !empty($link) && $link->icon_hover )
					{{ $link->icon_hover }}
				@endif">

				<div class="image-preview">
					@if( old('thumbnail') )
						<img class="img-thumbnail" src="{{ url( old('icon_hover') ) }}">
						<a type="button" class="btn-floating btn-sm btn-warning btn-wysiwyg-remove"><i class="fa fa-trash-o"></i></a>
					@elseif( !empty($link) && $link->icon_hover )
						<img class="img-thumbnail" src="{{ url( $link->icon_hover ) }}">
						<a type="button" class="btn-floating btn-sm btn-warning btn-wysiwyg-remove"><i class="fa fa-trash-o"></i></a>
					@else
					<span>No image selected</span>
					@endif
				</div>
			</div>

		</div>
	</div> --}}

	{{-- button group --}}
	<div class="button-group mt-5">
		<button type="submit" class="btn blue-gradient">Save</button>
	</div>

</form>

@endsection
