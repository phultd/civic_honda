@extends('panel.layout')

@section('title'){{ __('An toàn') }}@endsection

@section('content')

<h4>Danh sách An toàn</h4><br>

<div class="button-group mb-2">
	<a href="{{ route('admincp.safety.add.item') }}" type="submit" class="btn btn-sm btn-primary">Add New</a>
</div>

<table class="table table-list table-striped table-bordered table-sm table-hover">
        <thead>
            <tr class="text-center">
				<th>No.</th>
                <th>Title</th>
                <th>Description</th>
                <th>Order</th>
            </tr>
        </thead>
        <tbody>

			@forelse( $safety_items as $item )
				<tr class="text-center">
					<th>{{ $loop->iteration }}</th>
	                <th><a class="btn-link text-primary" href="{{ route('admincp.safety.item.edit', ['item'=>$item->id]) }}">{{ $item->title }}</a></th>
	                <th>{{ $item->description }}</th>
	                <th>{{ $item->order }}</th>
	            </tr>
			@empty
				<tr><td colspan="4">{{ __('No data to display.') }}</td></tr>
            @endforelse

        </tbody>
    </table>

@endsection
