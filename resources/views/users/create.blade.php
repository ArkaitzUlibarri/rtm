@extends('layouts.master')

@section('content')

<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
	<div class="panel panel-default">
		<div class="panel-heading">New User</div>
		<div class="panel-body">

			<form role="form" method="POST" action="{{ route('users.store') }}">

				{{ csrf_field() }}

				<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
					<label for="name" >Name</label>
					<input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
					@if ($errors->has('name'))
						<span class="help-block">
							<strong>{{ $errors->first('name') }}</strong>
						</span>
					@endif
				</div>

				<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
					<label for="email">E-Mail Address</label>
					<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
					@if ($errors->has('email'))
						<span class="help-block">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
					@endif
				</div>

				<div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
					<label for="role">Role</label>
					<select id="role" name="role" class="form-control" value="{{ old('role') }}" required>
						@foreach (config('filter.roles') as $role)
							<option value="{{ $role }}">{{ ucfirst($role) }}</option>
						@endforeach
					</select>

					@if ($errors->has('role'))
						<span class="help-block">
							<strong>{{ $errors->first('role') }}</strong>
						</span>
					@endif
				</div>

				<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
					<label for="password">Password</label>
					<input id="password" type="password" class="form-control" name="password" required>
					@if ($errors->has('password'))
						<span class="help-block">
							<strong>{{ $errors->first('password') }}</strong>
						</span>
					@endif
				</div>

				<div class="form-group">
					<label for="password-confirm">Confirm Password</label>
					<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
				</div>

				<hr>

				<div class="form-group">
					<div class="pull-right">
						<button type="submit" class="btn btn-success">Create</button>
						<a href="{{ url('users') }}" class="btn btn-danger" role="button">
							Cancel
						</a> 
					</div>
				</div>
			</form>

		</div>
	</div>
</div>

@endsection

@push('bottom')

	<script src="{{ asset('js/users.js') }}"></script>

@endpush