@extends('base')
@section('main')
	<div class="m-b-md">
		@if ($errors->any())
		<div class="alert alert-danger">
			@foreach ($errors->all() as $error)
				<div>{{ $error }}</div>
			@endforeach
		</div>
		@endif
		<form action="{{ route('update',$stud->id) }}" method="POST" enctype="multipart/form-data">
			{{-- @csrf --}}
			{{ csrf_field() }}
			<div class="row">
				<div class="col-25">
					<label for="fname">First Name: <font color='#f00'>*</font></label>
				</div>
				<div class="col-75">
					<input type="text" name="first_name" placeholder="First Name" value="{{ $stud->first_name }}">
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="fname">Last Name: <font color='#f00'>*</font></label>
				</div>
				<div class="col-75">
					<input type="text" name="last_name" placeholder="Last Name" value="{{ $stud->last_name }}">
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="fname">Date of Birth: <font color='#f00'>*</font></label>
				</div>
				<div class="col-75">
					<input type="text" name="date_of_birth" placeholder="Date of Birth" value="{{ $stud->date_of_birth }}">
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="address">Address: <font color='#f00'>*</font></label>
				</div>
				<div class="col-75">
					<textarea name="address" placeholder="Address">{{ $stud->address }}</textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="class_id">Select A Class: <font color='#f00'>*</font></label>
				</div>
				<div class="col-75">
					<select name="class_id">
						<option value="">--Select A Class--</option>
						@foreach ($classArr as $class)
							<option @if($stud->class_id == $class->id) selected @endif value="{{ $class->id }}">{{ $class->class_name }}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="gender">Gender: </label>
				</div>
				<div class="col-75">
					<input type="radio" name="gender" @if($stud->gender == 'male') checked @endif value="male">Male
					<input type="radio" name="gender" @if($stud->gender == 'female') checked @endif value="female">Female
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="e_mail">E-mail: <font color='#f00'>*</font></label>
				</div>
				<div class="col-75">
					<input type="text" name="e_mail" placeholder="E-mail" value="{{ $stud->e_mail }}">
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="student_image">Student Image: </label>
				</div>
				<div class="col-75">
					<input type="file" name="student_image" value="{{ $stud->student_image }}"><br>
					<img src="{{ asset('images/'.$stud->student_image) }}" style="width:40px;height:40px;" />
				</div>
			</div>
			<div class="row">
				<button type="submit" name="submit" class="btn btn-submit">Submit</button>
				<button type="submit" name="cancel" class="btn btn-cancel">Cancel</button>
			</div>
		</form>
	</div>
@endsection