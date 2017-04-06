<template id="alarm-table-template">
	<span>
		<div class="table-responsive" v-show="rows.length > 0">
			<table class="table table-condensed">
				<thead>
					<tr>
						<th v-for="header in headers">{{ header }}</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="row in rows">
						 <td  v-for="header in headers">
							{{ row[header] != null ? row[header] : '-' }}
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

		template: '#alarm-table-template',

		props: {
			rows: {
				type: Array,
				default: function () {
					return []
				}
			},
			headers: {
				type: Array,
				default: function () {
					return []
				}
			}
		},

		methods: {

			
		}
	}
</script>

<style>

</style>
