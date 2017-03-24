<template id="kpi-table-template">
	<span>
		<div class="table-responsive" v-show="rows.length > 0">
			<table class="table table-condensed table-hover kpi-table">
				<thead>
					<tr>
						<th v-for="header in headers">{{ header }}</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="row in rows">
						 <td  v-for="header in headers" v-bind:class="backgroundColor(header, row[header])">
							{{ row[header] }}
						</td>  
					</tr>
				</tbody>
			</table>
		</div>
		<div  style="text-align: center; margin-top: 200px" v-show="rows.length==0">
			No data available.
		</div> 
	</span>
</template>


<script>
	export default {

		template: '#kpi-table-template',

		props: {
			thresholdPercentage: {
				type: Number,
				default: 90
			},
			rows: {
				type: Array,
				default: function () {
					return []
				}
			},
			equations: {
				type: Object,
			},
			headers: {
				type: Array,
				default: function () {
					return []
				}
			}
		},

		methods: {

			showAlarms(id) {
				Event.$emit('showAlarmsByNode', id);
			},

			backgroundColor(field, value) {
				if(! (field in this.equations)) {
					return '';
				}
				
				value = parseFloat(value);
				var thresholdRed = parseFloat(this.equations[field].threshold_red);
				var symbolRed = this.equations[field].symbol_red;
				var thresholdYellow = parseFloat(this.equations[field].threshold_yellow);
				var symbolYellow = this.equations[field].symbol_yellow;

				if( symbolRed != null ) {
					if(eval( value + symbolRed + thresholdRed)) {
						return 'red';
					}
				}

				if( symbolYellow != null ) {
					if(eval( value + symbolYellow + thresholdYellow)) {
						return 'yellow';
					}
				}
			}
			
		}
	}
</script>

<style>
	.kpi-table {
		max-height: 750px;
		//border-collapse: collapse; 
		//overflow-y: auto;
		//display: block;
	}
	.kpi-table td {
		//text-align: center;
	}
	.kpi-table tr {
		cursor: pointer;
	}
	.kpi-table td.red {
		background: #ffa0a0;
	}
	.kpi-table td.yellow {
		background: #fffda1;
	}
	.kpi-table td.nan {
		background: #cfd8dc;
	}
</style>
