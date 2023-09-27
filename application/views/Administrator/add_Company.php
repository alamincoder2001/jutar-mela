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

<div id="company">
	<form @submit.prevent="saveCompany">
		<div class="row" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom:15px;">
			<div class="col-md-5 col-md-offset-1">
				<div class="form-group clearfix">
					<label class="control-label col-md-4">Company Name:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="company.company_name" placeholder="Company name" required>
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Address:</label>
					<div class="col-md-7">
						<textarea class="form-control" placeholder="Company Address" v-model="company.company_address" cols="30" rows="3"></textarea>
					</div>
				</div>
			</div>

			<div class="col-md-5">

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Mobile:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="company.mobile" placeholder="Mobile" required>
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Previous Due:</label>
					<div class="col-md-7">
						<input type="number" class="form-control" v-model="company.previous_due" required>
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Credit Limit:</label>
					<div class="col-md-7">
						<input type="number" class="form-control" v-model="company.credit_limit" required>
					</div>
				</div>

				<div class="form-group clearfix">
					<div class="col-md-7 col-md-offset-4">
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
				<datatable :columns="columns" :data="companies" :filter-by="filter" style="margin-bottom: 5px;">
					<template scope="{ row }">
						<tr>
							<td>{{ row.company_id }}</td>
							<td>{{ row.company_name }}</td>
							<td>{{ row.company_address }}</td>
							<td>{{ row.mobile }}</td>
							<td>{{ row.credit_limit }}</td>
							<td>{{ row.previous_due }}</td>
							<td>
								<?php if ($this->session->userdata('accountType') != 'u') { ?>
									<button type="button" class="button edit" @click="editCompany(row)">
										<i class="fa fa-pencil"></i>
									</button>
									<button type="button" class="button" @click="deleteCompany(row.company_id)">
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
		el: '#company',
		data() {
			return {
				company: {
					company_id: '',
					company_name: '',
					company_address: '',
					mobile: '',
					credit_limit: 0.00,
					previous_due: 0.00
				},
				companies: [],

				columns: [{
						label: 'company Id',
						field: 'company_id',
						align: 'center',
						filterable: false
					},
					{
						label: 'Company Name',
						field: 'company_name',
						align: 'center'
					},
					{
						label: 'Company Address',
						field: 'company_address',
						align: 'center'
					},
					{
						label: 'Mobile',
						field: 'mobile',
						align: 'center'
					},
					{
						label: 'Credit Limit',
						field: 'credit_limit',
						align: 'center'
					},
					{
						label: 'Previous Due',
						field: 'previous_due',
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
		filters: {
			dateOnly(datetime, format) {
				return moment(datetime).format(format);
			}
		},
		created() {
			this.getCompanies();
		},
		methods: {
			getCompanies() {
				axios.get('/get_companies').then(res => {
					this.companies = res.data;
				})
			},
			saveCompany() {

				let url = '/save_company';
				if (this.company.company_id != '') {
					url = '/update_company';
				}

				axios.post(url, this.company).then(res => {
					let r = res.data;
					alert(r.message);
					if (r.success) {
						this.resetForm();
						this.getCompanies();
					}
				})
			},
			editCompany(company) {
				let keys = Object.keys(this.company);
				keys.forEach(key => {
					this.company[key] = company[key];
				})
			},
			deleteCustomer(companyId) {
				let deleteConfirm = confirm('Are you sure?');
				if (deleteConfirm == false) {
					return;
				}
				axios.post('/delete_company', {
					companyId: companyId
				}).then(res => {
					let r = res.data;
					alert(r.message);
					if (r.success) {
						this.getCompanies();
					}
				})
			},
			resetForm() {
				let keys = Object.keys(this.company);
				keys.forEach(key => {
					if (typeof(this.company[key]) == 'string') {
						this.company[key] = '';
					} else if (typeof(this.company[key]) == 'number') {
						this.company[key] = 0;
					}
				})
			}
		}
	})
</script>