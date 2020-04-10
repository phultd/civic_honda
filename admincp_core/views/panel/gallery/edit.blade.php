@extends('panel.layout')

@section('title'){{ __('Danh sách Thư viện Category') }}@endsection

@section('content')

<h4>Danh sách Thư viện Category</h4><br>

<div class="button-group mb-2">
	<a href="{{ route('admincp.gallery.add.category') }}" type="submit" class="btn btn-sm btn-primary">Add New Category</a>
</div>

<table class="table table-list table-striped table-bordered table-sm table-hover">
        <thead>
            <tr class="text-center">
				<th>No.</th>
                <th>Title</th>
                <th>Heading</th>
                <th>Description</th>
                <th>Order</th>
            </tr>
        </thead>
        <tbody>

			@forelse( $gallery_categories as $category )
				<tr class="text-center">
					<td>{{ $loop->iteration }}</td>
	                <td><a class="btn-link text-primary" href="{{ route('admincp.gallery.edit.category', ['category'=>$category->id]) }}">{{ $category->title }}</a></td>
	                <td>{{ $category->heading }}</td>
	                <td>{{ $category->description }}</td>
	                <td>{{ $category->order }}</td>
	            </tr>
			@empty
				<tr><td colspan="5">{{ __('No data to display.') }}</td></tr>
            @endforelse

        </tbody>
    </table>

@endsection
