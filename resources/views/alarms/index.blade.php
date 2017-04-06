@extends('layouts.master')

@section('content')

<div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">

	<div class="panel panel-default">
		<div class="panel-body">  
			@include ('alarms.filter')
		</div>
	</div>

</div>

<div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">

	<div class="panel panel-default">

		<div class="panel-body" style="min-height: 400px;">

			<alarm-table :rows="data"
					   :headers="headers">
			</alarm-table>

		</div>
	</div>
</div>

@endsection


@push('head')

@endpush


@push('bottom')

	<script src="{{ asset('js/alarms.js') }}"></script>

@endpush