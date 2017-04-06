
require('../bootstrap');

/**
 * Cargo las graficas de Google Chart que queremos usar.
 */
google.charts.load('current', {'packages':['corechart']});

/**
 * Importo las clases empleadas.
 */
import vSelect from 'vue-select';

/**
 * Registro los componentes necesarios.
 */
Vue.component('filter-table', require('../components/Table.vue'));
Vue.component('chart', require('../components/Chart.vue'));
Vue.component('v-select', vSelect);

/**
 * Archivos de configuracion.
 */
var FILTER = require('../config/filter');


const app = new Vue({
	el: '#app',

	data: {
		filter: {
			by: 'cell',						// Tipo
			tech: '2g',						// Tecnologia
			vendor: 'eri',					// Vendor
			zone: 1,						// Zona
			zone_aggregate: 'controller',	// Tipo de agregado cuando seleccionamos zona
			for: 'last6h',					// Periodo
			resolution: 'rop',				// Resolution (ROP/Hour/Day)
			values:'CE1,CE2,CE3,CE4'					// Elementos a filtar (celda/nodo/controlador/provincia)
		},

		// Campos disponibles para visualizar en la tabla
		headers: [],

		// Kpis devueltos por el filtro actual
		equations: null,

		// Datos procesados para visualizar en la tabla
		data: [],

		// Array de datos para la grafica
		selected: [],	// Items seleccionados
		chart: {
			kpis: {},		// Kpis disponibles con la siguiente estructura: 
							// { name (string), show (bool), data: (array) }
			items: [],		// Array de items disponibles
			
		},
	},

	computed: {
		/**
		 * Actualizo las opciones de resolucion y la resolucion seleccionada
		 * en función del periodo de tiempo seleccionado.
		 */
		resolutionOptions() {
			this.filter.resolution = FILTER.resolutions[this.filter.for][0]['value'];
			return FILTER.resolutions[this.filter.for];
		},

		/**
		 * Muestro el campo tecnologia cuando filtremos por nodo o zona.
		 */
		showTechFilter: function() {
			return (this.filter.by == 'node' || this.filter.by == 'province' || this.filter.by == 'zone')
				? true
				: false;
		},

		showVendorFilter: function() {
			return (this.filter.by == 'province' || this.filter.by == 'zone')
				? true
				: false;
		},

		isZoneOption: function() {
			return (this.filter.by == 'zone')
				? true
				: false;
		},

		showAggregateOption: function() {
			return (this.filter.by == 'node' || this.filter.by == 'province')
				? true
				: false;
		},
	},

	methods: {

		updateFilter() {
			this.filter.tech = '2g';
			this.filter.vendor = 'eri';
			this.filter.zone = 1;
			this.filter.zone_aggregate = 'controller';
		},

		updateTech() {
			this.filter.zone_aggregate = this.filter.tech == '4g'
				? 'province'
				: 'controller';
		},

		fetchData() {
			var vm = this;

			vm.cleanData();

			if(vm.filter.by != 'zone' && vm.filter.values == '') {
				toastr.warning("You must enter a valid name.");
				return;
			};

			let url = 'api/filter-kpis' + '?' + this.getAllQueryParams();
			console.log('http://rtm.app:8000/' + url);

			axios.get(url)
				.then(function (response) {
					if(response.data.data.length == 0) {
						toastr.info("There are no items to show with current filter.");
						return;
					}

					vm.data = response.data.data;
					vm.headers = vm.setHeaders(vm.data[0]);
					vm.equations = response.data.kpis;
					vm.updateChartOptions();
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
				'by=' + this.filter.by,
				'end_date=' + document.getElementById('dtpToDate').children[0].value,
				'for=' + this.filter.for,
				'resolution=' + this.filter.resolution,
			].join('&');
			
			if(this.filter.by == 'node') {
				params += '&tech=' + this.filter.tech;
			}

			if(this.filter.by == 'province') {
				params += '&vendor=' + this.filter.vendor;
				params += '&tech=' + this.filter.tech;
			}

			if(this.filter.by == 'zone') {
				params += '&vendor=' + this.filter.vendor;
				params += '&tech=' + this.filter.tech;
				params += '&zone=' + this.filter.zone;
				params += '&zone_aggregate=' + this.filter.zone_aggregate;
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
		 * Establezco los campos de la cabecera para la tabla de kpis.
		 */
		setHeaders(obj) {
			// En el orden que se desea que aparezcan, 
			// los kpis apareceran segun el orden devuelto.
			let fields = ['item', 'date', 'time', 'province', 'controller', 'node'];
			var headers = fields;

			// Elimino del array de "headers" los campos que no existan en el objecto.
			for (let key = fields.length - 1; key >= 0; key--) {
				if (! (fields[key] in obj)) {
					headers.splice(headers.indexOf(fields[key]), 1);
				}
			}

			// Añado los kpis al array de campos principales.
			let properties = Object.keys(obj);
			for(let key in properties) {
				if(	headers.indexOf(properties[key]) == -1 ) {
					headers.push(properties[key]);
				}
			}

			return headers;
		},

		/**
		 * Reseteo las variables de la tabla y graficas.
		 */
		cleanData() {
			this.headers = [];
			this.equations = null;
			this.data = [];
			this.chart.kpis = {};
			this.chart.items = [];
			this.selected = [];
		},

		/**
		 * Actualizo las opciones de visualizacion de graficas.
		 */
		updateChartOptions() {
			// Completo el listado de kpis disponibles.
			let properties = Object.keys(this.equations);
			for (let i = properties.length - 1; i >= 0; i--) {
				this.chart.kpis[properties[i]] = { name: properties[i], show: true, data: [] };
			}

			// Completo el listado de items disponibles.
			for (let key in this.data) {

				// En el caso de agregado en nodo no tenemos el campo item.
				if(! ('item' in this.data[key])) {
					this.chart.items.push('Aggregate');
					break;
				};

				if(	this.chart.items.indexOf(this.data[key].item) == -1 ) {
					this.chart.items.push(this.data[key].item);
				}
				else {
					break;
				}
			}
		},

		getChartData() {
			if(this.selected.length == 0) {
				return;
			}

			// Creo un array de kpis disponibles
			// ['CSSR', 'DCR', ...]
			let kpis = Object.keys(this.chart.kpis);
			let countKpis = kpis.length;

			// Creo un array asociado para almacenar los datos de cada kpi
			// { 'CSSR': [], 'DCR': [], ... }
			let arrayTemp = {}
			for (let i = countKpis - 1; i >= 0; i--) {
				arrayTemp[kpis[i]] = [];
			}

			// Creo un array de campos usados para la leyenda de las graficas
			// ['Time', 'Item1', 'Item2', 'Item3', ...]
			let fields =  this.selected.slice(0);
			fields.unshift('Time');
			let countFields = fields.length;

			// Creo un array asociado con la posicion de los campos en el array
			// { 'Time': 0, 'Item1': 1, 'Item2': 2, ... }
			let idxFields = {};
			for (let i = fields.length - 1; i >= 0; i--) {
				idxFields[fields[i]] = i;
			}

			// Recorro las lineas de datos resultantes del filtro
			for (let key in this.data) {
				let entry = this.data[key];
				let itemName = ! ('item' in entry) ? 'Aggregate' : entry.item ;

				// Si el elemento actual no esta en el array de posiciones lo descartamos
				if(! (itemName in idxFields)) continue;

				// Doy formato al periodo temporal
				let dateTime = this.shortDateTime(entry.date, entry.time);

				// Recorro los kpis disponibles
				for (let i = countKpis - 1; i >= 0; i--) {
					let kpi = kpis[i];

					// Si no existe el periodo de tiempo para el kpi actual lo creamos
					if(! (dateTime in arrayTemp[kpi])) {
						let array = new Array(countFields).fill(null);
						array[idxFields['Time']] = dateTime;
						array[idxFields[itemName]] = entry[kpi];
						arrayTemp[kpi][dateTime] = array;
						continue;
					}

					// Completamos el valor del kpi para el item actual si ya existia el registro
					arrayTemp[kpi][dateTime][idxFields[itemName]] = entry[kpi];
				}			
			}

			// Completo el array de salida con los datos del array asociado
			for (let i = 0; i < countKpis; i++) {
				this.chart.kpis[kpis[i]].data.push(fields);

				for (let key in arrayTemp[kpis[i]]) {
					this.chart.kpis[kpis[i]].data.push(
						arrayTemp[kpis[i]][key]
					);
				}
			}
		},

		/**
		 * Extraigo el mes y dia de la fecha completa
		 * 2017-03-14 -> 14/03
		 */
		shortDateTime(date, time) {
			if(this.filter.resolution == 'day') {
				return date.substring(8, 10) + '/' + date.substring(5, 7)
			}

			return date.substring(8, 10) + '/' + date.substring(5, 7) + ' ' + time
		}

	},

	watch: {
		/**
		 * Cuando se modifique el campo de items para visualizar
		 * en las graficas elimino los datos calculados previamente
		 * y proceso los datos con los nuevos items disponibles.
		 */
		selected: function(currentValue) {
			for (let key in this.chart.kpis) {
				this.chart.kpis[key].data = [];
			}

			this.getChartData();
		}

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