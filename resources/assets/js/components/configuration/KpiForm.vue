<template id="kpi-form-template">
<div id="kpi-form" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">{{ action }} KPI</h4>
			</div>

			<div class="modal-body">

				<ul id="kpi-form-tabs" class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#kpi-threshold">Threshold</a></li>
					<li><a data-toggle="tab" href="#kpi-equation">Equation</a></li>
				</ul>
				 
				<div class="tab-content" style="border: solid 1px #ddd;" @keydown="errors.clear($event.target.name)">

						<div id="kpi-threshold" class="tab-pane active">

							<div class="row">
								<div class="form-group col-xs-12 col-sm-6" :class="{'has-error': errors.has('name') }">
									<label class="control-label">Name</label>
									<input name="name"
										   type="text"
										   placeholder="Text"
										   autocomplete="off"
										   class="form-control input-sm"
										   v-model="kpi.name">
								</div>

								<div class="form-group col-xs-12 col-sm-2">
									<label>Type</label>
									<select class="form-control input-sm" v-model="kpi.type" v-on:change="updateType">
										<option value="std">Kpi</option>
										<option value="tech">Dual</option>
										<option value="vnd">Vendor</option>
										<option value="prt">Partial</option>
									</select>
								</div>

								<div class="form-group col-xs-12 col-sm-2" v-show="kpi.type!='tech'">
									<label>Technology</label>
									<select class="form-control input-sm" v-model="kpi.tech" v-on:change="updateTech">
										<option value="2g">2G</option>
										<option value="3g">3G</option>
										<option value="4g">4G</option>
									</select>
								</div>

								<div class="form-group col-xs-12 col-sm-2" v-show="kpi.type!='vnd'">
									<label>Vendor</label>
									<select class="form-control input-sm" v-model="kpi.vendor" v-on:change="fetchPartial">
										<option value="eri">ERI</option>
										<option value="hua">HUA</option>
									</select>
								</div>
							</div>

							<span v-show="kpi.type!='prt'">
								<hr>
								<!-- Main threshold -->
								<div class="row">
									<div class="form-group col-sm-4 col-xs-12">
										<label>Main Symbol</label>
										<select class="form-control input-sm" v-model="kpi.symbol_red">
											<option value="">-</option>
											<option value="==">Equal</option>
											<option value="!=">Not Equal</option>
											<option value="<">Less</option>
											<option value=">">Greater</option>
											<option value="<=">Less Than or Equal</option>
											<option value=">=">Greater Than or Equal</option>
										</select>
									</div>

									<div class="form-group col-sm-4 col-xs-12"
										:class="{'has-error': errors.has('threshold_red') }">
										
										<label class="control-label">Main Th.</label>
										<input name="threshold_red"
											   type="number"
											   placeholder="Number"
											   autocomplete="off"
											   :disabled="kpi.symbol_red==''"
											   class="form-control input-sm"
											   v-model="kpi.threshold_red">
									</div>

									<div class="form-group col-sm-4 col-xs-12"
										:class="{'has-error': errors.has('threshold_aggregate_red') }">
										
										<label class="control-label">Main Aggregate Th.</label>
										<input name="threshold_aggregate_red"
											   type="number"
											   placeholder="Number"
											   autocomplete="off"
											   :disabled="kpi.symbol_red==''"
											   class="form-control input-sm"
											   v-model="kpi.threshold_aggregate_red">
									</div>
								</div>

								<!-- Second threshold -->
								<div class="row">
									<div class="form-group col-sm-4 col-xs-12">
										<label>Second Symbol</label>
										<select class="form-control input-sm" v-model="kpi.symbol_yellow">
											<option value="">-</option>
											<option value="==">Equal</option>
											<option value="!=">Not Equal</option>
											<option value="<">Less</option>
											<option value=">">Greater</option>
											<option value="<=">Less Than or Equal</option>
											<option value=">=">Greater Than or Equal</option>
										</select>
									</div>

									<div class="form-group col-sm-4 col-xs-12"
										:class="{'has-error': errors.has('threshold_yellow') }">
										
										<label class="control-label">Second Th.</label>
										<input name="threshold_yellow"
											   type="number"
											   placeholder="Number"
											   autocomplete="off"
											   :disabled="kpi.symbol_yellow==''"
											   class="form-control input-sm"
											   v-model="kpi.threshold_yellow">
									</div>

									<div class="form-group col-sm-4 col-xs-12"
										:class="{'has-error': errors.has('threshold_aggregate_yellow') }">
										
										<label class="control-label">Second Aggregate Th.</label>
										<input name="threshold_aggregate_yellow"
											   type="number"
											   placeholder="Number"
											   autocomplete="off"
											   :disabled="kpi.symbol_yellow==''"
											   class="form-control input-sm"
											   v-model="kpi.threshold_aggregate_yellow">
									</div>
								</div>

								<span v-show="kpi.type=='std'">

									<!-- Relative threshold -->
									<!-- ******************************************************************************************* -->
									<div class="row">
										<div class="checkbox col-sm-4 col-xs-12">
											<label>
												<input type="checkbox" v-model="hasRelativeTh"> Relative KPI
											</label>
										</div>
									</div>

									<div class="custom-panel" v-show="hasRelativeTh">
										<div class="row">
											<div class="form-group col-xs-12 col-sm-3"
												:class="{'has-error': errors.has('threshold_aggregate_relative') }">
												
												<label class="control-label">Aggregate Th.</label>
												<input name="threshold_aggregate_relative"
													   type="number"
													   placeholder="Number"
													   autocomplete="off"
													   class="form-control input-sm"
													   v-model="kpi.threshold_aggregate_relative">
											</div>

											<div class="form-group col-xs-12 col-sm-3">
												<label>N Rops</label>
												<select class="form-control input-sm"
														v-model="kpi.threshold_aggregate_relative_n"
														:disabled="kpi.threshold_aggregate_relative == '' ? true : false">
													<option v-for="number in numbers" :value="number">{{ number }}</option>
												</select>
											</div>
											
											<div class="form-group col-xs-12 col-sm-3"
												:class="{'has-error': errors.has('threshold_relative') }">
												
												<label class="control-label">Threshold</label>
												<input name="threshold_relative"
													   type="number"
													   placeholder="Number"
													   autocomplete="off"
													   class="form-control input-sm"
													   v-model="kpi.threshold_relative">
											</div>

											<div class="form-group col-xs-12 col-sm-3">
												<label>N Rops</label>
												<select class="form-control input-sm"
														v-model="kpi.threshold_relative_n"
														:disabled="kpi.threshold_relative == '' ? true : false">
													<option v-for="number in numbers" :value="number">{{ number }}</option>
												</select>
											</div>
										</div>

										<div class="row">
										
											<div class="form-group col-xs-12 col-sm-3 col-sm-offset-6"
												:class="{'has-error': errors.has('threshold_relative_condition') }">
												
												<label class="control-label">Conditional Th.</label>
												<input name="threshold_relative_condition"
													   type="number"
													   placeholder="Number"
													   autocomplete="off"
													   class="form-control input-sm"
													   v-model="kpi.threshold_relative_condition"
													   :disabled="kpi.threshold_relative == '' ? true : false">
											</div>

											<div class="form-group col-xs-12 col-sm-3">
												<label>Kpi Condition</label>
												<select class="form-control input-sm"
														v-model="kpi.threshold_relative_condition_kpi"
														:disabled="kpi.threshold_relative_condition == '' ? true : false">
													<option v-for="kpi in kpiOptions" :value="kpi.id">{{ kpi.name }}</option>
												</select>
											</div>
										</div>
									</div>
									

									<!-- Absolute threshold -->
									<!-- ******************************************************************************************* -->
									<div class="row">
										<div class="checkbox col-sm-4 col-xs-12">
											<label>
												<input type="checkbox" v-model="hasAbsoluteTh"> Absolute KPI
											</label>
										</div>
									</div>

									<div class="custom-panel" v-show="hasAbsoluteTh">
										<div class="row">
											<div class="form-group col-xs-12 col-sm-3" 
												:class="{'has-error': errors.has('threshold_aggregate_absolute') }">
												
												<label class="control-label">Aggregate Th.</label>
												<input name="threshold_aggregate_absolute"
													   type="number"
													   placeholder="Number"
													   autocomplete="off"
													   class="form-control input-sm"
													   v-model="kpi.threshold_aggregate_absolute">
											</div>

											<div class="form-group col-xs-12 col-sm-3">
												<label>N Rops</label>
												<select class="form-control input-sm"
														v-model="kpi.threshold_aggregate_absolute_n"
														:disabled="kpi.threshold_aggregate_absolute == '' ? true : false">
													<option v-for="number in numbers" :value="number">{{ number }}</option>
												</select>
											</div>
										</div>
									</div>
								</span>
							</span>

						</div>

						<div id="kpi-equation" class="tab-pane">
							<!-- Equation -->
							<!-- ******************************************************************************************* -->
							<div class="form-group" :class="{'has-error': errors.has('equation') }">
								<label for="inEquation" class="control-label">Equation</label>
								<textarea id="inEquation"
										  name="equation"
										  class="form-control"
										  autocomplete="off"
										  placeholder="Equation"
										  rows="10"
										  v-model="kpi.equation"></textarea>
								<!--<span class="text-danger" v-if="errors.has('equation')" v-text="errors.get('equation')"></span>-->
							</div>
						</div>


				</div>
			</div>

			<div class="modal-footer">
				<button type="button"
						class="btn btn-block btn-success"
						@click.prevent="onSubmit">
						{{ action }}
				</button>
			</div>

		</div>
	</div>

	<pre>
	@{{ $props }}
	</pre>
</div>
</template>


<script>

import Errors from '../../core/Errors.js';

export default {
	template: '#kpi-form-template',

	props: ['availableCounters'],
/*
	props: {
		counters: {
			type: Array,
			default: function () {
				return []
			}
		},
	},
*/
	data() {
		return {
			action: '',
			hasRelativeTh: false,
			hasAbsoluteTh: false,
			numbers: [1, 2, 3, 4, 5, 6, 7, 8],
			kpiOptions: [],
			errors: new Errors(),
			kpi: {
				id: '',
				name: '',
				tech: '',
				vendor: '',
				type: '',
				equation: '',
				symbol_red: '',
				threshold_red: '',
				threshold_aggregate_red: '',
				symbol_yellow: '',
				threshold_yellow: '',
				threshold_aggregate_yellow: '',
				threshold_relative: '',
				threshold_relative_n: 4,
				threshold_relative_condition: '',
				threshold_relative_condition_kpi: '',
				threshold_aggregate_relative: '',
				threshold_aggregate_relative_n: 4,
				threshold_aggregate_absolute: '',
				threshold_aggregate_absolute_n: 4
			}
		}
	},

	created() {
		/**
		 * Inicializo las variables del kpi
		 */
		Event.$on('InitializeKpiForm', (action, properties, partials) => {

			console.log(this.availableCounters);

			this.action = action;
			this.kpiOptions = partials;
			this.hasRelativeTh = false;
			this.hasAbsoluteTh = false;
			this.errors.record({});

			// Establezco todos los valores a ""
			for (let key in this.kpi) {
				this.kpi[key] = '';
			}

			if(action == 'new') {
				this.kpi.threshold_relative_n = 4;
				this.kpi.threshold_aggregate_relative_n = 4;
				this.kpi.threshold_aggregate_absolute_n = 4;
			}

			// Completo los campos pasados por argumento
			for (let key in properties) {
				this.kpi[key] = properties[key];
			}

			$('#kpi-form').modal('show');
		});
	},

	methods: {
		/**
		 * Ejecuto la accion del formulario.
		 */
		onSubmit() {
			this.errors.record(
				this.validateForm()
			);

			if(this.errors.any()) {
				return;
			}

			let vm = this;

			axios.put('api/kpi/' + vm.kpi.id, vm.kpi)
				.then(function (response) {
					$('#kpi-form').modal('hide');
					Event.$emit('LoadKpis');
				})
				.catch(function (error) {
					console.log(error);
				});
		},


		/**
		 * Obtengo los parciales disponibles para la tecnologia
		 * y vendor actual cuando insertamos un kpi estandar.
		 */
		fetchPartial() {
			if(this.kpi.type != 'std') {
				return;
			}

			let vm = this;
			vm.kpiOptions = [];

			axios.get('api/partials', {
					params: {
						vendor: vm.kpi.vendor,
						tech: vm.kpi.tech,
					}
				})
				.then(function (response) {
					vm.kpiOptions = response.data.data;
				})
				.catch(function (error) {
					console.log(error);
				});
		},

		/**
		 * Valido el formulario.
		 */
		validateForm() {
			var symbols = ['==', '!=', '<', '>', '<=', '>='];
			var list = {};

			if(this.kpi.name == '' || this.kpi.name.length <= 2 || this.kpi.name.length > 50) {
				list['name'] = 'Valid name required.';
			}

			if(this.kpi.equation == '') {
				list['equation'] = 'Valid equation required.';
			}   

			// He seleccionado un simbolo para el threshold principal
			if(symbols.indexOf(this.kpi.symbol_red) !== -1) {
				if( ! this.isNumeric(this.kpi.threshold_red)) {
					list['threshold_red'] = 'Must be a number';
				}
				if( ! this.isNumeric(this.kpi.threshold_aggregate_red)) {
					list['threshold_aggregate_red'] = 'Must be a number';
				}
			}

			// He seleccionado un simbolo para el threshold secundario
			if(symbols.indexOf(this.kpi.symbol_yellow) !== -1) {
				if( ! this.isNumeric(this.kpi.threshold_yellow)) {
					list['threshold_yellow'] = 'Must be a number';
				}
				if( ! this.isNumeric(this.kpi.threshold_aggregate_yellow)) {
					list['threshold_aggregate_yellow'] = 'Must be a number';
				}
			}

			if(this.hasRelativeTh) {
				if( ! this.isNumeric(this.kpi.threshold_relative)) {
					list['threshold_relative'] = 'Must be a number';
				}

				if(this.kpi.tech != '4g') {
					if( ! this.isNumeric(this.kpi.threshold_aggregate_relative)) {
						list['threshold_aggregate_relative'] = 'Must be a number';
					}
				}
			}

			if(this.hasAbsoluteTh) {
				if(this.kpi.tech != '4g') {
					if( ! this.isNumeric(this.kpi.threshold_aggregate_absolute)) {
						list['threshold_aggregate_absolute'] = 'Must be a number';
					}
				}
			}

			return list;
		},

		/**
		 * Compruebo que el texto sea un numero.
		 */
		isNumeric: function(n) {
			return !isNaN(parseFloat(n)) && isFinite(n);
		},

		/**
		 * Refresco el formulario cuando cambio el tipo.
		 */
		updateType() {
			this.errors.record({});

			if(this.kpi.type == 'std') {
				return;
			}

			if(this.kpi.type == 'prt') {
				this.kpi.symbol_red = '';
				this.kpi.threshold_red = '';
				this.kpi.threshold_aggregate_red = '';
				this.kpi.symbol_yellow = '';
				this.kpi.threshold_yellow = '';
				this.kpi.threshold_aggregate_yellow = '';
			}

			this.kpi.threshold_relative = '';
			this.kpi.threshold_relative_n = 4;
			this.kpi.threshold_aggregate_relative = '';
			this.kpi.threshold_aggregate_relative_n = 4;
			this.kpi.threshold_aggregate_absolute = '';
			this.kpi.threshold_aggregate_absolute_n = 4;
		},

		/**
		 * Refresco el fomulario cuando actualizo la tecnologia.
		 */
		updateTech() {
			this.fetchPartial();

			if(this.kpi.tech == '4g') {
				this.kpi.threshold_aggregate_relative = '';
				this.kpi.threshold_aggregate_relative_n = 4;
				this.kpi.threshold_aggregate_absolute = '';
				this.kpi.threshold_aggregate_absolute_n = 4;

				this.errors.clear('threshold_aggregate_relative');
				this.errors.clear('threshold_aggregate_absolute');
			}
		},
	}
}
</script>

<style>

.create-modal-panel {
	color: #33691e;
	background-color: #dcedc8;
	padding: 15px;
}

.custom-panel {
    border: 1px solid #d3e0e9;
    margin-bottom: .7em;
    padding: .7em;
}

</style>
