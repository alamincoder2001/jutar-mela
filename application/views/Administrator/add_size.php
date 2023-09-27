<style>
	.v-select {
		margin-bottom: 5px;
	}

	.v-select.open .dropdown-toggle {
		border-bottom: 1px solid #ccc;
	}

	.v-select .dropdown-toggle {
		padding: 0px;
		height: 25px;
	}

	.v-select input[type=search],
	.v-select input[type=search]:focus {
		margin: 0px;
	}

	.v-select .vs__selected-options {
		overflow: hidden;
		flex-wrap: nowrap;
	}

	.v-select .selected-tag {
		margin: 2px 0px;
		white-space: nowrap;
		position: absolute;
		left: 0px;
	}

	.v-select .vs__actions {
		margin-top: -5px;
	}

	.v-select .dropdown-menu {
		width: auto;
		overflow-y: auto;
	}

	#customers label {
		font-size: 13px;
	}

	#customers select {
		border-radius: 3px;
	}

	#customers .add-button {
		padding: 2.5px;
		width: 28px;
		background-color: #298db4;
		display: block;
		text-align: center;
		color: white;
	}

	#customers .add-button:hover {
		background-color: #41add6;
		color: white;
	}

	#customers input[type="file"] {
		display: none;
	}

	#customers .custom-file-upload {
		border: 1px solid #ccc;
		display: inline-block;
		padding: 5px 12px;
		cursor: pointer;
		margin-top: 5px;
		background-color: #298db4;
		border: none;
		color: white;
	}

	#customers .custom-file-upload:hover {
		background-color: #41add6;
	}

	#customerImage {
		height: 100%;
	}
</style>
<div id="customers">
	<form @submit.prevent="saveSize">
		<div class="row" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom:15px;">
			<div class="col-md-5 col-md-offset-3">

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Size Name:</label>
					<div class="col-md-8">
						<input type="text" class="form-control" v-model="size.size_name" placeholder="Size name" required>
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Description:</label>
					<div class="col-md-8">
						<textarea class="form-control" v-model="size.description" cols="30" rows="2" placeholder="Description"></textarea>
					</div>
				</div>
				<div class="form-group clearfix">
					<div class="col-md-8 col-md-offset-4 text-right">
						<input type="submit" class="btn btn-success btn-sm" value="Save">
					</div>
				</div>
			</div>

		</div>
	</form>

	<div class="row">
		<div class="col-sm-12 form-inline">
			<div class="form-group">
				<label for="filter" class="sr-only">Filter</label>
				<input type="text" class="form-control" v-model="filter" placeholder="Filter">
			</div>
		</div>
		<div class="col-md-12">
			<div class="table-responsive">
				<datatable :columns="columns" :data="allSizes" :filter-by="filter" style="margin-bottom: 5px;">
					<template scope="{ row }">
						<tr>
							<td>{{ row.size_sl }}</td>
							<td>{{ row.size_name }}</td>
							<td>{{ row.description }}</td>
							<td>
								<?php if ($this->session->userdata('accountType') != 'u') { ?>
									<button type="button" class="button edit" @click="editCustomer(row)">
										<i class="fa fa-pencil"></i>
									</button>
									<button type="button" class="button" @click="deleteCustomer(row.size_sl)">
										<i class="fa fa-trash"></i>
									</button>
								<?php } ?>
							</td>
						</tr>
					</template>
				</datatable>
				<datatable-pager v-model="page" type="abbreviated" :per-page="per_page" style="margin-bottom: 50px;"></datatable-pager>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vuejs-datatable.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script>
	Vue.component('v-select', VueSelect.VueSelect);
	new Vue({
		el: '#customers',
		data() {
			return {
				size: {
					size_sl: '',
					size_name: '',
					description: '',
				},
				allSizes: [],

				columns: [{
						label: 'Size No',
						field: 'size_sl',
						align: 'center',
						filterable: false
					},
					{
						label: 'Size Name',
						field: 'size_name',
						align: 'center'
					},
					{
						label: 'Description',
						field: 'description',
						align: 'center'
					},
					{
						label: 'Action',
						align: 'center',
						filterable: false
					}
				],
				page: 1,
				per_page: 10,
				filter: ''
			}
		},
		created() {
			this.getSizes();
		},
		methods: {
			getSizes() {
				axios.get('/get_sizes').then(res => {
					this.allSizes = res.data;
				})
			},

			saveSize() {
				if (this.size.size_name == '') {
					alert('Size name is required');
					return;
				}

				let url = '/save_size';
				if (this.size.size_sl != '') {
					url = '/update_size';
				}

				axios.post(url, this.size).then(res => {
					let r = res.data;
					alert(r.message);
					if (r.success) {
						this.resetForm();
						this.getSizes();
					}
				})
			},
			editCustomer(size) {
				let keys = Object.keys(this.size);
				keys.forEach(key => {
					this.size[key] = size[key];
				})
			},
			deleteCustomer(id) {
				let deleteConfirm = confirm('Are you sure?');
				if (deleteConfirm == false) {
					return;
				}
				axios.post('/delete_size', {
					size_sl: id
				}).then(res => {
					let r = res.data;
					alert(r.message);
					if (r.success) {
						this.getSizes();
					}
				})
			},
			resetForm() {
				let keys = Object.keys(this.size);
				keys.forEach(key => {
					if (typeof(this.size[key]) == 'string') {
						this.size[key] = '';
					} else if (typeof(this.size[key]) == 'number') {
						this.size[key] = 0;
					}
				})
			}
		}
	})
</script>