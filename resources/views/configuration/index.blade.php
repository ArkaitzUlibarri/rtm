@extends('layouts.master')

@section('content')

<div class="col-xs-12">

	<div class="panel panel-default">

		<div class="panel-body">

			@include ('configuration.filter')

			<ul id="home-tabs" class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#kpi-std">Standard</a></li>
				<li><a data-toggle="tab" href="#kpi-tech">Dual</a></li>
				<li><a data-toggle="tab" href="#kpi-vendor">Vendor</a></li>
			</ul>

			<div class="tab-content custom-tab-content" style="min-height: 400px; border: solid 1px #ddd;">
				<div id="kpi-std" class="tab-pane fade active" style="display:none"></div>
				<div id="kpi-vendor" class="tab-pane fade" style="display:none"></div>
				<div id="kpi-tech" class="tab-pane fade" style="display:none"></div>

				<div style="padding: 1em;">
					<kpi-table :rows="kpis"
							   :type="filter.type"
							   :tech="filter.tech"
							   :vendor="filter.vendor">
					</kpi-table>
				</div>

			</div>

		</div>
	</div>

	<kpi-form :available-counters="availableCounters"></kpi-form>
	<kpi-delete></kpi-delete>

</div>

@endsection


@push('bottom')

	<script src="{{ asset('js/configuration.js') }}"></script>

@endpush