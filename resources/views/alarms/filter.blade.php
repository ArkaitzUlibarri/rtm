<div class="form-group">
	<label>Alarm Type</label>
	<select id="type" class="form-control" v-model="filter.type">
		<option value="node">Node</option>
		<option value="archive">Archive</option>
	</select>
</div>

<div class="form-group">
	<label>End Date</label>
	<div class='input-group date' id='dtpToDate'>
		<input type='text' class="form-control" placeholder="yyyy-mm-dd hh:mm"/>
		<span class="input-group-addon">
			<span class="glyphicon glyphicon-calendar"></span>
		</span>
	</div>
</div>

<div class="form-group">
	<label>Last</label>
	<select id="for" class="form-control" v-model="filter.for">
		@foreach(config('filter.for') as $key => $item)
			<option value="{{ $key }}">{{ $item['name'] }}</option>
		@endforeach
	</select>
</div>

<div class="form-group">
	<label>Tech</label>
	<select class="form-control" v-model="filter.tech" :disabled="filter.values!=''">
		@foreach(config('filter.technologies') as $tech)
			<option value="{{ $tech }}">{{ strtoupper($tech) }}</option>
		@endforeach
	</select>
</div>

<div class="form-group">
	<label>Vendor</label>
	<select class="form-control" v-model="filter.vendor" :disabled="filter.values!=''">
		@foreach(config('filter.vendor') as $vendor)
			<option value="{{ $vendor }}">{{ strtoupper($vendor) }}</option>
		@endforeach
	</select>
</div>

<div class="form-group">
	<label>Items</label>
	<input type="text" class="form-control" id="values" v-model="filter.values" placeholder="Search...">
</div>

<p>
	<small class="text-danger">Node Type: Node, BSC (2G), RNC (3G)</small>
</p>
<p>
	<small class="text-danger">Archive Type: Cells, BSC (2G), RNC (3G), 4G Province (4G)</small>
</p>

<hr>

<button class="btn btn-primary btn-block"
		v-on:click="fetchData"
		type="button">Filter
</button>

<a href="{{ url('alarms/download') }}" class="btn btn-success btn-block" role="button">
	<span class="glyphicon glyphicon-download-alt"></span> Download
</a>