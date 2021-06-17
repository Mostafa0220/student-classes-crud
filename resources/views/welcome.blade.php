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
		<table>
			<thead>
				<tr>
					<th>Sl No.</th>
					<th>Student Name</th>
					<th>DOB</th>
					<th>Address</th>
					<th>Class</th>
					<th>Gender</th>
					<th>E-mail</th>
					<th>Image</th>
					<th>Options</th>
				</tr>
			</thead>
			<tbody>
				@if(count($students) > 0)
					@php ($sl 	=	1)
					@foreach ($students as $key)
						<tr>
							<td>{{ $sl }}</td>
							<td>{{ ucwords($key->first_name) }} {{ ucwords($key->last_name) }}</td>
							<td>{{ $key->date_of_birth }}</td>
							<td>{{ $key->address }}</td>
							<td>{{ $key->class_name }}</td>
							<td>{{ ucwords($key->gender) }}</td>
							<td>{{ $key->e_mail }}</td>
							<td><img src="{{ asset('images/'.$key->student_image) }}" style="width:40px;height:40px;" /></td>
							<td>
								<a href='{{ url("/edit/$key->id") }}'>Edit</a>
								<a href='{{ url("/remove/$key->id") }}'>Remove</a>
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
		{{ $students->links() }}
	</div>
@endsection