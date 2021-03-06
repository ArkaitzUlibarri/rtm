@extends('layouts.master')

@section('content')

<div class="col-xs-12 col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">
	<div class="panel panel-default">
		<div class="panel-heading">Edit User</div>
		<div class="panel-body">

			<form role="form" method="POST" action="{{ route('users.update', $user) }}">

				{{ method_field('PATCH') }}
				{{ csrf_field() }}

				<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
					<label for="name" >Name</label>
					<input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required autofocus>
					@if ($errors->has('name'))
						<span class="help-block">
							<strong>{{ $errors->first('name') }}</strong>
						</span>
					@endif
				</div>

				<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
					<label for="email">E-Mail Address</label>
					<input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" required>
					@if ($errors->has('email'))
						<span class="help-block">
							<strong>{{ $errors->first('email') }}</strong>
						</span>
					@endif
				</div>

				<div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
					<label for="role">Role</label>
					<select id="role" name="role" class="form-control" value="{{ $user->role }}" required>
						@foreach (config('filter.roles') as $role)
							<option value="{{ $role }}"
									{{$user->role==$role ? 'selected' : ''}}>
									{{ ucfirst($role) }}
							</option>
						@endforeach
					</select>

					@if ($errors->has('role'))
						<span class="help-block">
							<strong>{{ $errors->first('role') }}</strong>
						</span>
					@endif
				</div>
				
				<hr>

				<div class="form-group">
					<div class="pull-right">
						<button type="submit" class="btn btn-success">Update</button>
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