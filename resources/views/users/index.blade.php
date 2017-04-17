@extends('layouts.master')

@section('content')

<div class="col-xs-12">
	<div class="panel panel-default">
		<div class="panel-heading">Users</div>
		<div class="panel-body">

			@include('users.filter')

			<div class="table-responsive">
				<table class="table table-condensed table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Email</th>
							<th>Role</th>
							<th class="custom-table-action-th">Actions</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($users as $user)
							<tr v-for="row in rows">
								<td>{{ $user->id }}</td>
								<td>{{ $user->name }}</td>
								<td>{{ $user->email }}</td>
								<td>{{ $user->role }}</td>
								<td>
									<a href="{{ route('users.edit', $user) }}"
										class="btn btn-primary btn-sm custom-table-action-btn"
										role="button">
										<span class="glyphicon glyphicon-edit"></span> Edit
									</a>
									<a href="#"
										class="btn btn-danger btn-sm custom-table-action-btn"
										role="button">
										<span class="glyphicon glyphicon-trash"></span> Delete
									</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			{{ $users->links() }}

			<a href="{{ route('users.create') }}" class="btn btn-success" role="button">New User</a>

		</div>
	</div>
</div>

@endsection


@push('bottom')

	<script src="{{ asset('js/users.js') }}"></script>

@endpush