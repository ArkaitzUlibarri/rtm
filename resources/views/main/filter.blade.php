<div class="form-group">
	<label for="filter_by">Filter</label>
	<select id="filter_by" class="form-control" v-model="filter.by" v-on:change="updateFilter">
		@foreach(config('filter.by') as $key => $item)
			<option value="{{ $key }}">{{ $item['name'] }}</option>
		@endforeach
	</select>
</div>

<div class="form-group" v-show="showTechFilter">
	<label for="tech">Tech</label>
	<select id="tech" class="form-control" v-model="filter.tech" v-on:change="updateTech">
		@foreach(config('filter.technologies') as $tech)
			<option value="{{ $tech }}">{{ strtoupper($tech) }}</option>
		@endforeach
		<option v-show="showAggregateOption" value="aggregate">Aggregate</option>
	</select>
</div>

<div class="form-group" v-show="showVendorFilter">
	<label for="vendor">Vendor</label>
	<select id="vendor" class="form-control" v-model="filter.vendor">
		@foreach(config('filter.vendor') as $vendor)
			<option value="{{ $vendor }}">{{ strtoupper($vendor) }}</option>
		@endforeach
		<option v-show="showAggregateOption" value="aggregate">Aggregate</option>
	</select>
</div>

<div class="form-group">
	<label for="dtpToDate">End Date</label>
	<div class='input-group date' id='dtpToDate'>
		<input type='text' class="form-control" placeholder="yyyy-mm-dd hh:mm"/>
		<span class="input-group-addon">
			<span class="glyphicon glyphicon-calendar"></span>
		</span>
	</div>
</div>

<div class="form-group">
	<label for="for">Last</label>
	<select id="for" class="form-control" v-model="filter.for">
		@foreach(config('filter.for') as $key => $item)
			<option value="{{ $key }}">{{ $item['name'] }}</option>
		@endforeach
	</select>
</div>

<div class="form-group">
	<label for="resolution">Resolution</label>
	<select id="resolution" class="form-control" v-model="filter.resolution" :disabled="resolutionOptions.length==1">
		<option v-for="option in resolutionOptions" v-bind:value="option.value">@{{ option.name }}</option>
	</select>
</div>

<span v-show="isZoneOption">
	<div class="form-group">
		<label for="zone">Zone</label>
		<select id="zone" class="form-control" v-model="filter.zone">
			@foreach(config('filter.zones') as $zone)
				<option value="{{ $zone['value'] }}">{{ $zone['name'] }}</option>
			@endforeach
		</select>
	</div>

	<div class="form-group">
		<label for="zone_aggregate">Aggregate</label>
		<select id="zone_aggregate" class="form-control" v-model="filter.zone_aggregate">
			<option value="controller" v-show="filter.tech != '4g'">Controller</option>
			<option value="province">Province</option>
		</select>
	</div>
</span>

<div class="form-group" v-show="! isZoneOption">
	<label for="values">Items</label>
	<input type="text" class="form-control" id="values" v-model="filter.values" placeholder="Search...">
</div>

<button class="btn btn-primary btn-block"
		v-on:click="fetchData"
		type="button">Filter
</button>
<!--
<pre>
@{{ $data }}
</pre>
-->