@extends('panel.layout')

@section('title'){{ __('Edit Thư viện Item') }}@endsection

@section('content')

<h4>Edit Thư viện Item</h4>

<a href="{{ route('admincp.gallery.edit.category',['category'=>Request::route('category')]) }}" class="btn btn-sm btn-light mb-5"><i class="fa fa-chevron-left"></i> Back to category <b>@if( !empty($category->title) ){{ $category->title }}@endif</b></a>

<form action="{{ route('admincp.gallery.update.item', ['category'=>Request::route('category'),'item'=>$item->id]) }}" method="post">
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
				@elseif( !empty($item) && $item->type == 'image' )
					checked
				@elseif( !empty($item) && empty($item->type ) )
					checked
				@endif>
				<label class="form-check-label" for="type_1">Static Image</label>
			</div>

			<div class="form-check">
				<input type="radio" class="form-check-input" id="type_2" name="type" value="tvc"
				@if( old('type') && old('type') == 'video' )
					checked
				@elseif( !empty($item) && $item->type == 'video' )
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
				@elseif( !empty($item) && $item->image )
					{{ $item->image }}
				@endif">

				<div class="image-preview">
					@if( old('thumbnail') )
						<img class="img-thumbnail" src="{{ url( old('image') ) }}">
						<a type="button" class="btn-floating btn-sm btn-warning btn-wysiwyg-remove"><i class="fa fa-trash-o"></i></a>
					@elseif( !empty($item) && $item->image )
						<img class="img-thumbnail" src="{{ url( $item->image ) }}">
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
				value="@if( old('video') ){{ old('video') }}@elseif( !empty($item) && $item->video ){{ $item->video }}@endif">
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
				value="@if( old('order') ){{ old('order') }}@elseif( !empty($item) && $item->order ){{ $item->order }}@endif">
				<label for="title">Input Order</label>
			</div>
		</div>
	</div>

	{{-- button group --}}
	<div class="button-group mt-5">
		<button type="submit" class="btn blue-gradient">Save</button>
		<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal_delete">Delete Item</button>
	</div>

</form>

<form id="form_delete" class="d-none" action="{{ route('admincp.gallery.delete.item', ['category'=>Request::route('category'),'item'=>$item->id]) }}" method="post">
	@csrf
	@method('delete')
</form>

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
			Are you sure to delete?
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-danger" onclick="$('#form_delete').submit()">Delete Item</button>
		</div>
	</div>
</div>
</div>

@endsection
