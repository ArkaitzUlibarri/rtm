
require('../bootstrap');

/**
 * Registro los componentes necesarios.
 */
Vue.component('alarm-table', require('../components/AlarmTable.vue'));

/**
 * Archivos de configuracion.
 */
var FILTER = require('../config/filter');


const app = new Vue({
	el: '#app',

	data: {
		filter: {
			type: 'node',	// Tipo de alarma, nodo/historico (celda/controlador)			
			for: 'last6h',	// Periodo
			tech: '2g',
			vendor: 'eri',
			values:''	// Elementos a filtar (celda/nodo/controlador)
		},

		// Campos disponibles para visualizar en la tabla
		headers: [],

		// Datos de las alarmas
		data: [],
	},


	computed: {
/*		showAggregateOption: function() {
			return (this.filter.by == 'node' || this.filter.by == 'province')
				? true
				: false;
		},*/
	},

	methods: {

		fetchData() {
			var vm = this;

			vm.cleanData();

			let url = 'api/alarms' + '?' + this.getAllQueryParams();
			console.log('http://rtm.app:8000/' + url);

			axios.get(url)
				.then(function (response) {
					if(response.data.length == 0) {
						toastr.info("There are no items to show with current filter.");
						return;
					}

					vm.data = response.data;
					vm.headers = vm.setHeaders(vm.data[0]);
				})
				.catch(function (error) {
					console.log(error);
					if(Array.isArray(error.response.data)) {
						error.response.data.forEach( (error) => {
							toastr.error(error);
						})
					}
					else {
						toastr.error(error.response.data);
					}
				});
		},

		/**
		 * Concateno los parametros del filtro separados por "&" para crear la url de filtrado.
		 */
		getAllQueryParams() {
			var params = [
				'type=' + this.filter.type,
				'end_date=' + document.getElementById('dtpToDate').children[0].value,
				'for=' + this.filter.for
			].join('&');

			if(this.filter.values == '') {
				params += '&vendor=' + this.filter.vendor;
				params += '&tech=' + this.filter.tech;
			}
			else {
				params += '&values=' + this.getInputArray(this.filter.values);
			}

			return params
		},

		/**
		 * Creo un string de elementos separados por ",".
		 */
		getInputArray(input) {
			// Elimino espacios
			input = input.replace(/[ ]+/g, "");

			// Cambios caracteres de separación por ","
			return input.replace(/[-;:/|]+/g, ",");
		},

		/**
		 * Extraigo los campos del objeto para crear la cabecera de la tabla de alarmas.
		 */
		setHeaders(obj) {
			let headers = [];

			let properties = Object.keys(obj);
			for(let key in properties) {
				headers.push(properties[key]);
			}

			return headers;
		},

		/**
		 * Reseteo las variables de la tabla.
		 */
		cleanData() {
			this.headers = [];
			this.data = [];
		},
	},
})

/**
 * Inicializo la fecha y hora del filtro.
 */
$('#dtpToDate').datetimepicker({
	format: "YYYY-MM-DD HH:mm",
	maxDate: 'now'
});
$('#dtpToDate').data("DateTimePicker").date(moment().format('YYYY-MM-DD HH:mm'));
