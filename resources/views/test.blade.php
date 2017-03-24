<!DOCTYPE html>
<html>
<head>
	<title>Test</title>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.2.4/vue.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.15.3/axios.min.js"></script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<style>
		body { padding-top: 50px; font-size: 16px; }
	</style>
</head>
<body>

	<div class="container" id="app">

		<div class="form-group">
			<label>Technology</label>
			<select class="form-control input-sm" v-model="tech">
				<option value="2g">2G</option>
				<option value="3g">3G</option>
				<option value="4g">4G</option>
			</select>
		</div>

		<div class="form-group">
			<label>Vendor</label>
			<select class="form-control input-sm" v-model="vendor">
				<option value="eri">ERI</option>
				<option value="hua">HUA</option>
			</select>
		</div>

		<textarea id="inEquation"
				  name="equation"
				  class="form-control"
				  autocomplete="off"
				  placeholder="Equation"
				  rows="5"
				  v-model="equation"></textarea>

		<button class="btn btn-default" v-on:click="translateDbToNet">Translate Database To Network</button>
		<hr>

		<textarea id="inEquation"
				  name="equation"
				  class="form-control"
				  autocomplete="off"
				  placeholder="Equation"
				  rows="5"
				  v-model="translated"></textarea>
		<button class="btn btn-default" v-on:click="translateNetToDb">Translate Network To Database</button>
		
		<hr>

		<pre>@{{ $data }}</pre>

	</div>






<script>
const app = new Vue({
	el: '#app',

	data: {
		tech: '2g',
		vendor: 'eri',
		availableCounters: {},
		equation: '2*(c3+c1)',
		translated: '',
	},

	computed: {
		databaseToNetwork() {
			let array = {};
			this.availableCounters[this.vendor][this.tech].forEach( (item) => {
				array[item['db_name']] = item['oss_name'];
			});

			return array;
		},

		networkToDatabase() {
			let array = {};
			this.availableCounters[this.vendor][this.tech].forEach( (item) => {
				array[item['oss_name']] = item['db_name'];
			});

			return array;
		}
	},

	mounted() {
		let vm = this;

		axios.all([axios.get('api/counter')])
		.then(axios.spread(function (counter) {
			vm.availableCounters = counter.data.data;
		}));

	},

	methods: {
		translateDbToNet() {

			this.equation: '2*(c3+c1)',
			translated: '',

		}

		translateNetToDb() {

		}
	},
})
</script>
</body>
</html>



