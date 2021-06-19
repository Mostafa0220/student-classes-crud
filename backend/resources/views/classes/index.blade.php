@extends('base')
@section('main')
	<div class="m-b-md">
		@if ($message = Session::get('success'))
			<div class="alert alert-success">
				<p>{{ $message }}</p>
			</div>
		@endif
		@if ($message = Session::get('error'))
			<div class="alert alert-danger">
				<p>{{ $message }}</p>
			</div>
		@endif
		<a class="{{ request()->is('addclass') ? 'active' : '' }}" href="{{ url('/addclass') }}">Add a
			Class</a>
		<table>
			<thead>
				<tr>
					<th>#</th>
					<th>Class Code</th>
					<th>Class Name</th>
					<th>Max Students</th>
					<th>Status</th>
					<th>Options</th>
				</tr>
			</thead>
			<tbody>
				@if(count($classes) > 0)
					@php ($sl 	=	1)
					@foreach ($classes as $key)
						<tr>
							<td>{{ $sl }}</td>
							<td>{{ $key->code }}</td>
							<td>{{ ucwords($key->class_name) }}</td>
							
							<td>{{ $key->maximum_students }}</td>
							<td>{{ $key->status }}</td>
							
							<td>
								<a href='{{ url("/editclass/$key->id") }}'>Edit</a>
								<a href='{{ url("/removeclass/$key->id") }}'>Remove</a>
							</td>
						</tr>
						@php ($sl++)
					@endforeach
				@else
					<tr>
						<td colspan="6" style="text-color:red;">No record(s) found</td>
					</tr>
				@endif
			</tbody>
		</table>
		{{ $classes->links() }}
	</div>
@endsection