@extends('layouts.master')

@section('content')

<div class="col-xs-12">
	<div class="panel panel-default">
		<div class="panel-heading">Edit User</div>
		<div class="panel-body">

			<td>{{ $user->role }}</td>

			<form class="form-horizontal" role="form" method="POST" action="{{ route('users.update', $user) }}">

				{{ method_field('PATCH') }}
				{{ csrf_field() }}

				<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
					<label for="name" class="col-md-4 control-label">Name</label>

					<div class="col-md-6">
						<input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required autofocus>

						@if ($errors->has('name'))
							<span class="help-block">
								<strong>{{ $errors->first('name') }}</strong>
							</span>
						@endif
					</div>
				</div>

				<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
					<label for="email" class="col-md-4 control-label">E-Mail Address</label>

					<div class="col-md-6">
						<input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" required>
						@if ($errors->has('email'))
							<span class="help-block">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
						@endif
					</div>
				</div>

				<div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
					<label for="role" class="col-md-4 control-label">Role</label>

					<div class="col-md-6">
						<select id="role" name="role" class="form-control" value="{{ $user->role }}" required>
							@foreach (config('filter.roles') as $role)
								<option value="{{ $role }}">{{ strtoupper($role) }}</option>
							@endforeach
						</select>

						@if ($errors->has('role'))
							<span class="help-block">
								<strong>{{ $errors->first('role') }}</strong>
							</span>
						@endif
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-6 col-md-offset-4">
						<button type="submit" class="btn btn-primary">Update</button>
					</div>
				</div>
			</form>

		</div>
	</div>
</div>

@endsection