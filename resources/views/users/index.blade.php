@extends('layouts.master')

@section('content')

<div class="col-xs-12">
	<div class="panel panel-default">
		<div class="panel-heading">Users</div>
		<div class="panel-body">

			<div class="table-responsive">
				<table class="table table-condensed table-hover">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Email</th>
							<th>Role</th>
							<th>Actions</th>
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
										class="btn btn-primary btn-sm"
										role="button">
										<span class="glyphicon glyphicon-edit"></span> Edit
									</a>
									<a href="#"
										class="btn btn-danger btn-sm"
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

		</div>
	</div>
</div>

@endsection