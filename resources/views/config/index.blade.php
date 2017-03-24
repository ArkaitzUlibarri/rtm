@extends('layouts.master')

@section('content')

<div class="col-xs-12">

	<div class="panel panel-default">

		<div class="panel-body">

			@include ('config.filter')
			@include ('config.table')

		</div>
	</div>

</div>

@endsection


@push('bottom')

	<script src="{{ asset('js/config.js') }}"></script>

@endpush