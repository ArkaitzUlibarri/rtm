
require('../bootstrap');

const app = new Vue({
	el: '#app',

	components: {
		'kpi-form': require('../components/configuration/KpiForm.vue'),
		'kpi-delete': require('../components/configuration/KpiModalDelete.vue'),
		'kpi-table': require('../components/configuration/KpiTable.vue')
	},

	data: {
		// Kpis
		kpis: [],

		// Traduccion de nombres de campos con nombre
		availableCounters: {},

		// Filters
		filter: { type: 'std', tech: '2g', vendor: 'eri' },

		// Item's ID to remove and the verification text
		rowToDelete: { id: -1, input: '', validation: '', type: '' },

	},

	computed: {
		/**
		 * Filtro los parciales por vendor y tecnologia
		 * cuando si estamos en kpis estandar.
		 */
		partials() {
			if(this.filter.type != 'std') return [];

			let partials = [];
			this.kpis.forEach( (item) => {
				if( item.type == 'prt' &&
					item.vendor == this.filter.vendor &&
					item.tech == this.filter.tech) {
					partials.push({id: item.id, name: item.name});
				}
			})

			return partials;
		},
	},

	mounted() {
		let vm = this;

		axios.all([
			axios.get('api/counter'),
			axios.get('api/kpi', { params: { type: vm.filter.type }}),
		])
		.then(axios.spread(function (counter, kpi) {
			vm.availableCounters = counter.data.data;
			vm.kpis = kpi.data.data;
		}));

	},

	created() {
		/**
		 * Refresco 
		 */
		Event.$on('LoadKpis', () => {
			this.fetchKpi();
		});

		/**
		 * Muestro el formulario modal para editar el kpi.
		 */
		Event.$on('ShowFormModal', (row) => {
			if(this.availableCounters == []) {
				console.log("Campos no cargados");
			}

			Event.$emit('InitializeKpiForm', 'update', row, this.partials);
		});

		/**
		 * Muestro el formulario modal para borrar el kpi.
		 */
		Event.$on('ShowDeleteModal', (row) => {
			Event.$emit('InitializeKpiDelete', row);
		});

		/**
		 * Elimino el kpi del array de kpis
		 */
		Event.$on('RemoveItemFromArray', (id) => {    
			for (var i = this.kpis.length - 1; i >= 0; i--) {
				if(this.kpis[i].id === id) {
					this.kpis.splice(i, 1);
					return;
				}
			}
		});
	},

	methods: {
		/**
		 * Show the modal box to create a new kpi
		 */
		showCreateModal() {
			if(this.availableCounters == []) {
				console.log("Campos no cargados");
			}

			Event.$emit(
				'InitializeKpiForm', 'new',	{
					'tech': this.filter.tech,
					'vendor': this.filter.vendor,
					'type': this.filter.type
				},
				this.partials
			);
		},

		/**
		 * Get the kpis for the current group.
		 */
		fetchKpi() {
			let vm = this;
			vm.kpis = [];

			axios.get('api/kpi', {
					params: {
						type: vm.filter.type,
					}
				})
				.then(function (response) {
					vm.kpis = response.data.data;
				})
				.catch(function (error) {
					console.log(error);
				});
		},
	},
})


/**
 * Update the kpi type to filter
 */
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
	let target = $(e.target).text().toLowerCase();

	if(target == 'standard') {
		app.filter.type = 'std';
	} else if (target == 'dual') {
		app.filter.type = 'tech';
	} else if (target == 'vendor') {
		app.filter.type = 'vnd';
	}

	// Hay pestañas en el formulario de kpis, por lo que hay
	// que excluir la ejecucion de "fetchKpi" cuando se usen
	if(['standard', 'dual', 'vendor'].includes(target)) {
		app.fetchKpi();
	}
});
