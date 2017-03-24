@extends('layouts.master')

@section('content')

<div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">

	<div class="panel panel-default">
		<div class="panel-body">  
			@include ('main.filter')
		</div>
	</div>

</div>

<div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">

	<div class="panel panel-default">

		<div class="panel-body">

			<ul id="home-tabs" class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#main-details">MAIN</a></li>
				<li><a data-toggle="tab" href="#main-graphs">GRAPHS</a></li>
			</ul>

			<div class="tab-content " style="min-height: 400px; border: solid 1px #ddd;">

				<div id="main-details" class="tab-pane active">
					@include ('main.tabs.filter')
				</div>

				<div id="main-graphs" class="tab-pane">
					@include ('main.tabs.graphs')
				</div>

			</div>
		</div>
	</div>
</div>

@endsection


@push('head')

@endpush


@push('bottom')

	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script src="{{ asset('js/main.js') }}"></script>

@endpush