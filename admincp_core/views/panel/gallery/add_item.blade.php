@extends('panel.layout')

@section('title'){{ __('Add New Thư viện Item') }}@endsection

@section('content')

<h4>Add New Thư viện Item</h4>

<a href="{{ route('admincp.gallery.edit.category',['category'=>Request::route('category')]) }}" class="btn btn-sm btn-light mb-5"><i class="fa fa-chevron-left"></i> Back to category <b>@if( !empty($category->title) ){{ $category->title }}@endif</b></a>

<form action="{{ route('admincp.gallery.save.item',['category'=>Request::route('category')]) }}" method="post">
	@csrf

	{{-- type --}}
	<div class="card mb-3">
		<div class="card-header">
			Item Type
		</div>
		<div class="card-body">
			<div class="form-check">
				<input type="radio" class="form-check-input" id="type_1" name="type" value="image"
				@if( old('type') && old('type') == 'image' )
					checked
				@endif>
				<label class="form-check-label" for="type_1">Static Image</label>
			</div>

			<div class="form-check">
				<input type="radio" class="form-check-input" id="type_2" name="type" value="tvc"
				@if( old('type') && old('type') == 'video' )
					checked
				@endif>
				<label class="form-check-label" for="type_2">Youtube TVC</label>
			</div>

		</div>
	</div>

	{{-- image --}}
	<div class="card mb-3">
		<div class="card-header">
			Image
		</div>
		<div class="card-body">
			<div class="md-form">
				<button id="image" type="button" class="btn btn-primary btn-sm btn-wysiwyg">Select Image</button>
				<input type="text" hidden name="image"
				value="@if( old('image') )
					{{ old('image') }}
				@endif">

				<div class="image-preview">
					@if( old('image') )
						<img src="{{ url( old('image') ) }}">
						<a type="button" class="btn-floating btn-sm btn-warning btn-wysiwyg-remove"><i class="fa fa-trash-o"></i></a>
					@else
					<span>No image selected</span>
					@endif
				</div>
			</div>

		</div>
	</div>

	{{-- youtube id --}}
	<div class="card mb-3">
		<div class="card-header">
			Youtube Video ID
		</div>
		<div class="card-body">
			<div class="md-form">
				<input type="text" id="video" name="video" class="form-control"
				value="@if( old('video') ){{ old('video') }}@endif">
				<label for="video">Input Youtube Video ID</label>
			</div>

		</div>
	</div>

	{{-- item order --}}
	<div class="card mb-3">
		<div class="card-header">
			Order
		</div>
		<div class="card-body">
			<div class="md-form">
				<input type="number" id="order" name="order" class="form-control"
				value="@if( old('order') ){{ old('order') }}@endif">
				<label for="title">Input Order</label>
			</div>
		</div>
	</div>

	{{-- button group --}}
	<div class="button-group mt-5">
		<button type="submit" class="btn blue-gradient">Save</button>
	</div>

</form>

@endsection
