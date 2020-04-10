@extends('panel.layout')

@section('title'){{ __('Add New Ngoại thất Item') }}@endsection

@section('content')

<h4>Add New Ngoại thất Item</h4>

<a href="{{ route('admincp.exterior.edit.category',['category'=>Request::route('category')]) }}" class="btn btn-sm btn-light mb-5"><i class="fa fa-chevron-left"></i> Back to category <b>@if( !empty($category->title) ){{ $category->title }}@endif</b></a>

<form action="{{ route('admincp.exterior.save.item',['category'=>Request::route('category')]) }}" method="post">
	@csrf

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

	{{-- item title --}}
	<div class="card mb-3">
		<div class="card-header">
			Title
		</div>
		<div class="card-body">
			<div class="md-form">
				<input type="text" id="title" name="title" class="form-control"
				value="@if( old('title') ){{ old('title') }}@endif">
				<label for="title">Input Title</label>
			</div>
		</div>
	</div>

	{{-- item description --}}
	<div class="card mb-3">
		<div class="card-header">
			Description
		</div>
		<div class="card-body">
			<div class="md-form">
				<textarea id="description" name="description" class="md-textarea form-control" rows="3" value="@if( old('description') ){{ old('description') }}@endif"></textarea>
				<label for="description">Input Description</label>
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
