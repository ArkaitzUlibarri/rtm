<template id="kpi-table-template">
<span>
	<div class="table-responsive">
		<table class="table">
			<thead>
				<tr>
					<th>Name</th>
					<th>Partial</th>
					<th>Vendor</th>
					<th>Tech</th>
					<th>Absolute</th>
					<th>Relative</th>
					<th><abbr title="Main Symbol">MS</abbr></th>
					<th><abbr title="Main Threshold">MT</abbr></th>
					<th><abbr title="Main Aggregate Threshold">MAT</abbr></th>
					<th><abbr title="Second Symbol">SS</abbr></th>
					<th><abbr title="Second Threshold">ST</abbr></th>
					<th><abbr title="Second Aggregate Threshold">SAT</abbr></th>
					<th class="custom-table-action-th">Actions</th>
				</tr>
			</thead>
			<tbody>
				<tr v-show="filteredRows.length === 0">
					<td class="text-centre" colspan="13">No Results</td>
				</tr>
				
				<tr v-show="filteredRows.length !== 0"
					v-for="row in filteredRows"
					:id="setRowId( row.id )">

					<td>{{ row.name }}</td>
					<td>{{ row.type == 'prt' ? 'p' + row.id : '-' }}</td>
					<td>{{ row.vendor == null ? '-' : row.vendor }}</td>
					<td>{{ row.tech == null ? '-' : row.tech }}</td>

					<td style="font-weight:bold;color:#27ae60">{{ row.threshold_aggregate_absolute == null ? '' : '&#x2714;' }}</td>
					<td style="font-weight:bold;color:#27ae60">{{ row.threshold_aggregate_relative == null ? '' : '&#x2714;' }}</td>

					<td>{{ isPartial(row.type, row.symbol_red) }}</td>
					<td>{{ isPartial(row.type, row.threshold_red) }}</td>
					<td>{{ isPartial(row.type, row.threshold_aggregate_red) }}</td>
					<td>{{ isPartial(row.type, row.symbol_yellow) }}</td>
					<td>{{ isPartial(row.type, row.threshold_yellow) }}</td>
					<td>{{ isPartial(row.type, row.threshold_aggregate_yellow) }}</td>

					<td>
						<a href="#"
						   class="btn btn-primary btn-sm custom-table-action-btn"
						   role="button"
						   v-on:click.prevent="editKpi(row)">
						   <span class="glyphicon glyphicon-edit"></span> Edit
						</a>

						<a href="#"
						   class="btn btn-danger btn-sm custom-table-action-btn"
						   role="button"
						   v-on:click.prevent="deleteKpi(row)">
						   <span class="glyphicon glyphicon-trash"></span> Delete
						</a> 
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</span>
</template>


<script>
export default {

	template: '#kpi-table-template',

	props: {
		rows: { type: Array },
		type: { type: String },
		tech: { type: String },
		vendor: { type: String },
		url: { type: String }
	},

	computed: {
		filteredRows: function() {
			if(this.type == 'vnd') {
				return this.rows.filter(row => row.tech == this.tech);
			}
			else if(this.type == 'tech') {
				return this.rows.filter(row => row.vendor == this.vendor);
			}
			
			return this.rows.filter(row => 
				row.tech == this.tech && 
				row.vendor == this.vendor
			);
		},
	},

	methods: {

		isPartial: function(type, value) {
			if (type == 'prt') {
				return '-';
			}
			return value == null ? '-' : value;
		},

		/**
		 * Set the kpi row ID
		 */
		setRowId: function(id) {
			return "kpi-row-" + id;
		},

		/**
		 * Fire the event to show edit modal
		 */
		editKpi: function(row) {
			Event.$emit('ShowFormModal', row);
		},

		/**
		 * Fire the event to show delete modal
		 */
		deleteKpi: function(row) {
			Event.$emit('ShowDeleteModal', row);
		},
	}
}
</script>


<style>

</style>