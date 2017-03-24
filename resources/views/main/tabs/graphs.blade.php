<div class="row">

	<!-- <div class="col-xs-12 col-md-9 col-lg-10">-->
	<div class="col-xs-12">
		<v-select multiple :options="chart.items" v-model="selected"></v-select>
	</div>

	<!-- 
	<div class="col-xs-12 col-md-3 col-lg-2" style="margin-bottom: 1em;"> 
		<div class="dropdown">

			<button class="btn btn-default btn-block dropdown-toggle"
					type="button"
					data-toggle="dropdown"
					:disabled="selected.length==0">
				Select Kpis
				<span class="caret"></span>
			</button>

			<ul class="dropdown-menu">
				<li v-for="kpi in chart.kpis">
					<div class="checkbox" style="padding-left: 20px;">
						<label><input type="checkbox" v-on:click="updateChart(kpi)"> @{{ kpi.name }}</label>
					</div>
				</li>
			</ul>
		</div>
	</div>
	-->
</div>

<div class="row">
	<div class="col-xs-12 col-md-6 col-lg-4" v-for="kpi in chart.kpis" v-show="kpi.data.length>0">
		<chart :title="kpi.name" :rows="kpi.data"></chart>
	</div>
</div>


<!--
<div class="row">
	<div class="col-xs-12" v-for="kpi in chart.kpis" v-show="kpi.show">
		<chart :title="kpi.name" :rows="kpi.data"></chart>
	</div>
</div>
-->
