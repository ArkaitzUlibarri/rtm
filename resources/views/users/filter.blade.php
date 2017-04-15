<div class="row">
	<form class="form-inline pull-right" method="GET" action="{{ route('users.index') }}">

		<input type="text" class="form-control" name="name" placeholder="User name">

		<select name="role" class="form-control">
			<option value="">-</option>
			@foreach (config('filter.roles') as $role)
				<option value="{{ $role }}">{{ ucfirst($role) }}</option>
			@endforeach
		</select>

		<button type="submit" class="btn btn-default">Filter</button>
	</form> 
</div>