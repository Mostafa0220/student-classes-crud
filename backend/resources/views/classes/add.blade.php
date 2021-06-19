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
		<form action="{{ route('storeclass') }}" method="POST" enctype="multipart/form-data">
			{{-- @csrf --}}
			{{ csrf_field() }}
			<div class="row">
				<div class="col-25">
					<label for="fname">Class Code: <font color='#f00'>*</font></label>
				</div>
				<div class="col-75">
					<input type="text" name="code" placeholder="Class Code" value="{{ old('code') }}">
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="fname">Class Name: <font color='#f00'>*</font></label>
				</div>
				<div class="col-75">
					<input type="text" name="class_name" placeholder="Class Name" value="{{ old('class_name') }}">
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="fname">Maximum Students: <font color='#f00'>*</font></label>
				</div>
				<div class="col-75">
					<input type="text" name="maximum_students" placeholder="10" value="{{ old('maximum_students') }}">
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="address">Description: <font color='#f00'>*</font></label>
				</div>
				<div class="col-75">
					<textarea name="description" placeholder="Description">{{ old('description') }}</textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-25">
					<label for="class_id">Status: <font color='#f00'>*</font></label>
				</div>
				<div class="col-75">
					<select name="status">
						<option value="">--Select A Status--</option>
						@foreach ($statuses as $status)
							<option {{ (old("status") == $status ? "selected":"") }} value="{{ $status }}">{{ $status }}</option>
						@endforeach
					</select>
				</div>
			</div>
			
			<div class="row">
				<button type="submit" name="submit" value="submit" class="btn btn-submit">Submit</button>
				<button type="submit" name="cancel" class="btn btn-cancel">Cancel</button>
			</div>
		</form>
	</div>
@endsection