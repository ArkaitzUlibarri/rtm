<template id="chart-template">
	<div v-bind:id="id" style="width:100%; min-height:400px; margin-bottom:1em;"></div>
</template>


<script>
	export default {

		template: '#chart-template',

		props: {

			title: {
				type: String,
				required: true
			},

			rows: {
				type: Array,
				default: function () {
					return []
				}
			}

		},

		data: function () {
			return {
				id: 'chart_' + this.title.replace(/\s/g, "_").toLowerCase(),
				chart: null
			}
		},

		watch: {
			rows: function () {
				this.drawChart();
			},
		},

		methods: {
			drawChart() {
				if( ! this.canAccessGoogleVisualization || this.rows.length == 0) {
					return;
				}

				let options = {
					title: this.title,
					hAxis: {title: 'Date Time',  titleTextStyle: {color: '#333'}},
					legend: { position: 'right' },
					backgroundColor : { strokeWidth: 1 }
				};

				this.chart.draw(
					google.visualization.arrayToDataTable(this.rows),
					options
				);
			},

			canAccessGoogleVisualization: function() {
				if ((typeof google === 'undefined') || (typeof google.visualization === 'undefined')) {
					return false;
				}

				return true;
			},

		},

		mounted() {
			this.chart = new google.visualization.LineChart(document.getElementById(this.id));

			if (window.addEventListener) {
				window.addEventListener('resize', this.drawChart, false);
			}
			else if (window.attachEvent) {
				window.attachEvent('onresize', this.drawChart);
			}
		},

	}
</script>