<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th>Name</th>
				<th>Partial</th>
				<th>Vendor</th>
				<th>Tech</th>
				<th><abbr title="Main Symbol">MS</abbr></th>
				<th><abbr title="Main Threshold">MT</abbr></th>
				<th><abbr title="Main Aggregate Threshold">MAT</abbr></th>
				<th><abbr title="Second Symbol">SS</abbr></th>
				<th><abbr title="Second Threshold">ST</abbr></th>
				<th><abbr title="Second Aggregate Threshold">SAT</abbr></th>
				<th>Monitoring</th>
				<th class="custom-kpi-table-action-field">Actions</th>
			</tr>
		</thead>
		<tbody>
		<!--
			<tr v-show="filteredRows.length === 0">
				<td class="text-centre" colspan="15">No Results</td>
			</tr>
			-->

			@foreach ($kpis as $row)
				<tr id="kpi-row-{{ $row->id }}">
					<td>{{ $row->name }}</td>
					<td>{{ $row->type == 'prt' ? 'p' + $row->id : '-' }}</td>
					<td>{{ $row->vendor == null ? '-' : $row->vendor }}</td>
					<td>{{ $row->tech == null ? '-' : $row->tech }}</td>

					<td>{{ $row->symbol_red == '' ? '-' : $row->symbol_red }}</td>

					<td>{{ $row->threshold_red == '' ? '-' : $row->threshold_red }}</td>
					<td>{{ $row->threshold_aggregate_red == '' ? '-' : $row->threshold_aggregate_red }}</td>
					<td>{{ $row->symbol_yellow == '' ? '-' : $row->symbol_yellow }}</td>
					<td>{{ $row->threshold_yellow == '' ? '-' : $row->threshold_yellow }}</td>
					<td>{{ $row->threshold_aggregate_yellow == '' ? '-' : $row->threshold_aggregate_yellow }}</td>

				</tr>
			@endforeach
		</tbody>
	</table>
</div>