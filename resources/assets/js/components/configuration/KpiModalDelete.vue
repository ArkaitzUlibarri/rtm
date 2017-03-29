<template id="delete-kpi-modal-template">
<div id="delete-modal" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Are you ABSOLUTELY sure?</h4>
			</div>

			<div class="delete-alert-panel">
				Unexpected bad things will happen if you don’t read this!
			</div>

			<div class="modal-body">
				<p>This action <strong>CANNOT</strong> be undone. This will permanently delete <strong>{{ validation }}</strong> {{ type == 'prt' ? 'partial' : 'kpi' }}.
				</p>

				<div v-show="kpis.length > 0" class="kpi-delete-list">
					<p>The following kpis will be affected, delete them before continue:</p>
					<ul>
						<li v-for="kpi in kpis">{{ kpi.name }}</li>
					</ul>
				</div>

				<p>Please type in the items's full name to confirm.</p>

				<input type="text" class="form-control" v-model="input">

			</div>

			<div class="modal-footer">
				<button type="button"
						class="btn btn-danger btn-block"
						:disabled="disableButton"
						v-on:click.prevent="deleteItem()">
						Delete
				</button>
			</div>
		</div>
	</div>
</div>
</template>


<script>
	export default {

		template: '#delete-kpi-modal-template',

		data() {
			return {
				id: '',
				type: '',
				validation: '',
				kpis: [],
				input: ''
			}
		},

		computed: {
			/**
			 * Inhabilito el boton de borrando mientras existan kpis
			 * dependientes (borrado de parciales) o el campo de texto
			 * sea diferente al de validacion.
			 */
			disableButton: function() {
				if(this.kpis.length > 0) {
					return true;
				}

				return this.input != this.validation
					? true
					: false;
			},
		},

		created() {
			/**
			 * Inicializo las variables del kpi.
			 */
			Event.$on('InitializeKpiDelete', (row) => {
				this.id = row.id;
				this.type = row.type;
				this.validation = row.name;
				this.kpis = [];
				this.input = '';

				if(row.type == 'prt') {
					this.kpisByPartial('p' + row.id);
				}

				$('#delete-modal').modal('show');
			});
		},

		methods: {
			/**
			 * Borro el kpi, emito el evento para actualizar
			 * la tabla y cierro el formulario.
			 */
			deleteItem: function() {
				if (this.disableButton) return;

				let vm = this;

				axios.delete('api/kpi/' + vm.id)
					.then(function (response) {
						Event.$emit('RemoveItemFromArray', vm.id);
						$('#delete-modal').modal('hide');
					})
					.catch(function (error) {
						toastr.error(error.response.data);
					});
			},

			kpisByPartial(partial) {
				let vm = this;

				axios.get('api/kpi-dependencies', {
						params: {
							partial: partial,
						}
					})
					.then(function (response) {
						vm.kpis = response.data;
					})
					.catch(function (error) {
						toastr.error(error.response.data);
					});
			},

		}
	}
</script>

<style>
.delete-alert-panel {
	color: #796620;
	background-color: #f8eec7;
	padding: 15px;
}


.kpi-delete-list ul {
	border-radius: 0px;
	border: 1px solid #ccd0d2;
	padding: .3em 1em;
	height: 6em;
	overflow: auto;
}

.kpi-delete-list li {
	list-style-type: none;
	padding: .1em 0;
}

</style>
