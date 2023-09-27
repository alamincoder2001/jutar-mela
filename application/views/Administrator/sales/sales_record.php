<style>
	.v-select {
		margin-top: -2.5px;
		float: right;
		min-width: 180px;
		margin-left: 5px;
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

	#searchForm select {
		padding: 0;
		border-radius: 4px;
	}

	#searchForm .form-group {
		margin-right: 5px;
	}

	#searchForm * {
		font-size: 13px;
	}

	.record-table {
		width: 100%;
		border-collapse: collapse;
	}

	.record-table thead {
		background-color: #0097df;
		color: white;
	}

	.record-table th,
	.record-table td {
		padding: 3px;
		border: 1px solid #454545;
	}

	.record-table th {
		text-align: center;
	}
</style>
<div id="salesRecord">
	<div class="row" style="border-bottom: 1px solid #ccc;padding: 3px 0;">
		<div class="col-md-12">
			<form class="form-inline" id="searchForm" @submit.prevent="getSearchResult">
				<div class="form-group">
					<label>সার্চ টাইপ</label>
					<select class="form-control" v-model="searchType" @change="onChangeSearchType">
						<option value="">All</option>
						<option value="customer">By Customer</option>
						<option value="employee">By Employee</option>
						<option value="category">By Category</option>
						<option value="quantity">By Quantity</option>
						<option value="user">By User</option>
						<option value="company">By Company</option>
					</select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'company' && companies.length > 0 ? '' : 'none'}">
					<label>প্রতিষ্ঠান</label>
					<v-select v-bind:options="companies" v-model="selectedCompany" label="company_name" @input="getCompanyProduct"></v-select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'customer' && customers.length > 0 ? '' : 'none'}">
					<label>ক্রেতা</label>
					<v-select v-bind:options="customers" v-model="selectedCustomer" label="display_name"></v-select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'employee' && employees.length > 0 ? '' : 'none'}">
					<label>কর্মচারী</label>
					<v-select v-bind:options="employees" v-model="selectedEmployee" label="Employee_Name"></v-select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'quantity' || searchType == 'company'? '' : 'none'}">
					<label>পণ্য</label>
					<v-select v-bind:options="products" v-model="selectedProduct" label="display_text" @input="sales = []"></v-select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'category' && categories.length > 0 ? '' : 'none'}">
					<label>ক্যাটাগরি</label>
					<v-select v-bind:options="categories" v-model="selectedCategory" label="ProductCategory_Name"></v-select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'user' && users.length > 0 ? '' : 'none'}">
					<label> ইউজার</label>
					<v-select v-bind:options="users" v-model="selectedUser" label="FullName"></v-select>
				</div>

				<div class="form-group" v-bind:style="{display: searchTypesForRecord.includes(searchType) ? '' : 'none'}">
					<label>রেকর্ড টাইপ</label>
					<select class="form-control" v-model="recordType" @change="sales = []">
						<option value="without_details">Without Details</option>
						<option value="with_details">With Details</option>
					</select>
				</div>

				<div class="form-group">
					<input type="date" class="form-control" v-model="dateFrom">
				</div>

				<div class="form-group">
					<input type="date" class="form-control" v-model="dateTo">
				</div>

				<div class="form-group" style="margin-top: -5px;">
					<input type="submit" value="Search">
				</div>
			</form>
		</div>
	</div>

	<div class="row" style="margin-top:15px;display:none;" v-bind:style="{display: sales.length > 0 ? '' : 'none'}">
		<div class="col-md-12" style="margin-bottom: 10px;">
			<a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
		</div>
		<div class="col-md-12">
			<div class="table-responsive" id="reportContent">
				<table class="record-table" v-if="(searchTypesForRecord.includes(searchType)) && recordType == 'with_details'" style="display:none" v-bind:style="{display: (searchTypesForRecord.includes(searchType)) && recordType == 'with_details' ? '' : 'none'}">
					<thead>
						<tr>
							<th>চালান নং</th>
							<th>তারিখ</th>
							<th>ক্রেতার নাম</th>
							<th>কর্মকর্তার নাম</th>
							<th>অ্যাড করেছন</th>
							<th>পণ্যের নাম</th>
							<th>দাম</th>
							<th>পরিমাণ</th>
							<th>ছাড়</th>
							<th>স্টাফ কমিশন</th>
							<th>মোট</th>
							<th>কর্ম</th>
						</tr>
					</thead>
					<tbody>
						<template v-for="sale in sales">
							<tr>
								<td>{{ sale.SaleMaster_InvoiceNo }}</td>
								<td>{{ sale.SaleMaster_SaleDate }}</td>
								<td>{{ sale.Customer_Name }}</td>
								<td>{{ sale.Employee_Name }}</td>
								<td>{{ sale.AddBy }}</td>
								<td>{{ sale.saleDetails[0].Product_Name }}</td>
								<td style="text-align:right;">{{ sale.saleDetails[0].SaleDetails_Rate }}</td>
								<td style="text-align:center;">{{ sale.saleDetails[0].SaleDetails_TotalQuantity }}</td>
								<td style="text-align:center;">{{ sale.saleDetails[0].Discount_amount }}</td>
								<td style="text-align:center;">{{ parseFloat(sale.saleDetails[0].Commission_amount * sale.saleDetails[0].SaleDetails_TotalQuantity).toFixed(2) }}</td>
								<td style="text-align:right;">{{ sale.saleDetails[0].SaleDetails_TotalAmount }}</td>
								<td style="text-align:center;">
									<a href="" title="Sale Invoice" v-bind:href="`/sale_invoice_print/${sale.SaleMaster_SlNo}`" target="_blank"><i class="fa fa-file"></i></a>
									<a href="" title="Chalan" v-bind:href="`/chalan/${sale.SaleMaster_SlNo}`" target="_blank"><i class="fa fa-file-o"></i></a>
									<?php if ($this->session->userdata('accountType') != 'u') { ?>
										<a href="javascript:" title="Edit Sale" @click="checkReturnAndEdit(sale)"><i class="fa fa-edit"></i></a>
										<a href="" title="Delete Sale" @click.prevent="deleteSale(sale.SaleMaster_SlNo)"><i class="fa fa-trash"></i></a>
									<?php } ?>
								</td>
							</tr>
							<tr v-for="(product, sl) in sale.saleDetails.slice(1)">
								<td colspan="5" v-bind:rowspan="sale.saleDetails.length - 1" v-if="sl == 0"></td>
								<td>{{ product.Product_Name }}</td>
								<td style="text-align:right;">{{ product.SaleDetails_Rate }}</td>
								<td style="text-align:center;">{{ product.SaleDetails_TotalQuantity }}</td>
								<td style="text-align:center;">{{ product.Discount_amount }}</td>
								<td style="text-align:center;">{{ parseFloat(product.Commission_amount * product.SaleDetails_TotalQuantity).toFixed(2) }}</td>
								<td style="text-align:right;">{{ product.SaleDetails_TotalAmount }}</td>
								<td></td>
							</tr>
							<tr style="font-weight:bold;">
								<td colspan="7" style="font-weight:normal;"><strong>Note: </strong>{{ sale.SaleMaster_Description }}</td>
								<td style="text-align:center;">Total Qty<br>{{ sale.saleDetails.reduce((prev, curr) => {return prev + parseFloat(curr.SaleDetails_TotalQuantity)}, 0) }}</td>
								<td style="text-align:center;">Total Discount<br>{{ sale.saleDetails.reduce((prev, curr) => {return prev + parseFloat(curr.Discount_amount)}, 0) }}</td>
								<td style="text-align:center;">Total Commission<br>{{ sale.saleDetails.reduce((prev, curr) => {return prev + (parseFloat(curr.Commission_amount) * parseFloat(curr.SaleDetails_TotalQuantity))}, 0).toFixed(2) }}</td>
								<td style="text-align:right;">
									Total: {{ sale.SaleMaster_TotalSaleAmount }}<br>
									Paid: {{ sale.SaleMaster_PaidAmount }}<br>
									Due: {{ sale.SaleMaster_DueAmount }}
								</td>
								<td></td>
							</tr>

						</template>
						<tr style="font-weight:bold; background:#ddd">
							<td colspan="7" style="font-weight:bold;text-align:right;">Total: </td>
							<td style="font-weight:bold;text-align:center;">{{ (sales.reduce((prev, curr) => {return prev + parseFloat(curr.saleDetails.reduce((prev2, curr2) => {return prev2 + parseFloat(curr2.SaleDetails_TotalQuantity)}, 0))}, 0)) }} </td>
							<td style="font-weight:bold;text-align:center;">{{ (sales.reduce((prev, curr) => {return prev + parseFloat(curr.saleDetails.reduce((prev2, curr2) => {return prev2 + parseFloat(curr2.Discount_amount)}, 0))}, 0)).toFixed(2) }} </td>
							<td style="font-weight:bold;text-align:center;">{{ (sales.reduce((prev, curr) => {return prev + parseFloat(curr.saleDetails.reduce((prev2, curr2) => {return prev2 + (parseFloat(curr2.Commission_amount) * parseFloat(curr2.SaleDetails_TotalQuantity))}, 0))}, 0)).toFixed(2) }} </td>
							<td></td>
							<td></td>
						</tr>
					</tbody>
				</table>

				<table class="record-table" v-if="(searchTypesForRecord.includes(searchType)) && recordType == 'without_details'" style="display:none" v-bind:style="{display: (searchTypesForRecord.includes(searchType)) && recordType == 'without_details' ? '' : 'none'}">
					<thead>
						<tr>
						    <th>চালান নং</th>
						    <th>তারিখ</th>
							<th>ক্রেতার নাম</th>
							<th>কর্মকর্তার নাম</th>
							<th>অ্যাড করেছন</th>
							<th>সর্বমোট</th>
							<th>ভ্যাট</th>
							<th>ছাড়</th>
							<th>পরিবহন খরচ</th>
							<th>মোট</th>
							<th>পরিশধ</th>
							<th>বাকি</th>
							<th>নোট</th>
							<th>কর্ম</th>

						</tr>
					</thead>
					<tbody>
						<tr v-for="sale in sales">
							<td>{{ sale.SaleMaster_InvoiceNo }}</td>
							<td>{{ sale.SaleMaster_SaleDate }}</td>
							<td>{{ sale.Customer_Name }}</td>
							<td>{{ sale.Employee_Name }}</td>
							<td>{{ sale.AddBy }}</td>
							<td style="text-align:right;">{{ sale.SaleMaster_SubTotalAmount }}</td>
							<td style="text-align:right;">{{ sale.SaleMaster_TaxAmount }}</td>
							<td style="text-align:right;">{{ sale.SaleMaster_TotalDiscountAmount }}</td>
							<td style="text-align:right;">{{ sale.SaleMaster_Freight }}</td>
							<td style="text-align:right;">{{ sale.SaleMaster_TotalSaleAmount }}</td>
							<td style="text-align:right;">{{ sale.SaleMaster_PaidAmount }}</td>
							<td style="text-align:right;">{{ sale.SaleMaster_DueAmount }}</td>
							<td style="text-align:left;">{{ sale.SaleMaster_Description }}</td>
							<td style="text-align:center;">
								<a href="" title="Sale Invoice" v-bind:href="`/sale_invoice_print/${sale.SaleMaster_SlNo}`" target="_blank"><i class="fa fa-file"></i></a>
								<a href="" title="Chalan" v-bind:href="`/chalan/${sale.SaleMaster_SlNo}`" target="_blank"><i class="fa fa-file-o"></i></a>
								<?php if ($this->session->userdata('accountType') != 'u') { ?>
									<a href="javascript:" title="Edit Sale" @click="checkReturnAndEdit(sale)"><i class="fa fa-edit"></i></a>
									<a href="" title="Delete Sale" @click.prevent="deleteSale(sale.SaleMaster_SlNo)"><i class="fa fa-trash"></i></a>
								<?php } ?>
							</td>
						</tr>
					</tbody>
					<tfoot>
						<tr style="font-weight:bold;">
							<td colspan="5" style="text-align:right;">Total</td>
							<td style="text-align:right;">{{ sales.reduce((prev, curr)=>{return prev + parseFloat(curr.SaleMaster_SubTotalAmount)}, 0) }}</td>
							<td style="text-align:right;">{{ sales.reduce((prev, curr)=>{return prev + parseFloat(curr.SaleMaster_TaxAmount)}, 0) }}</td>
							<td style="text-align:right;">{{ sales.reduce((prev, curr)=>{return prev + parseFloat(curr.SaleMaster_TotalDiscountAmount)}, 0) }}</td>
							<td style="text-align:right;">{{ sales.reduce((prev, curr)=>{return prev + parseFloat(curr.SaleMaster_Freight)}, 0) }}</td>
							<td style="text-align:right;">{{ sales.reduce((prev, curr)=>{return prev + parseFloat(curr.SaleMaster_TotalSaleAmount)}, 0) }}</td>
							<td style="text-align:right;">{{ sales.reduce((prev, curr)=>{return prev + parseFloat(curr.SaleMaster_PaidAmount)}, 0) }}</td>
							<td style="text-align:right;">{{ sales.reduce((prev, curr)=>{return prev + parseFloat(curr.SaleMaster_DueAmount)}, 0) }}</td>
							<td></td>
							<td></td>
						</tr>
					</tfoot>
				</table>

				<template v-if="searchTypesForDetails.includes(searchType)" style="display:none;" v-bind:style="{display: searchTypesForDetails.includes(searchType) ? '' : 'none'}">
					<table class="record-table" v-if="selectedProduct != null">
						<thead>
							<tr>
								<th>চালান নং</th>
								<th>তারিখ</th>
								<th>ক্রেতার নাম</th>
								<th>পণ্যের নাম</th>
								<th>বিক্রয় হার</th>
								<th>পরিমাণ</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="sale in sales">
								<td>{{ sale.SaleMaster_InvoiceNo }}</td>
								<td>{{ sale.SaleMaster_SaleDate }}</td>
								<td>{{ sale.Customer_Name }}</td>
								<td>{{ sale.Product_Name }}</td>
								<td style="text-align:right;">{{ sale.SaleDetails_Rate }}</td>
								<td style="text-align:right;">{{ sale.SaleDetails_TotalQuantity }}</td>
							</tr>
						</tbody>
						<tfoot>
							<tr style="font-weight:bold;">
								<td colspan="5" style="text-align:right;">Total Quantity</td>
								<td style="text-align:right;">{{ sales.reduce((prev, curr) => { return prev + parseFloat(curr.SaleDetails_TotalQuantity)}, 0) }}</td>
							</tr>
						</tfoot>
					</table>

					<table class="record-table" v-if="selectedProduct == null">
						<thead>
							<tr>
								<th>পণ্য আইডি</th>
								<th>পণ্যের তথ্য</th>
								<th>পরিমাণ</th>
							</tr>
						</thead>
						<tbody>
							<template v-for="sale in sales">
								<tr>
									<td colspan="3" style="text-align:center;background: #ccc;">{{ sale.category_name }}</td>
								</tr>
								<tr v-for="product in sale.products">
									<td>{{ product.product_code }}</td>
									<td>{{ product.product_name }}</td>
									<td style="text-align:right;">{{ product.quantity }}</td>
								</tr>
							</template>
						</tbody>
					</table>
				</template>

				<div style="margin-top: 20px;display:none;" v-bind:style="{display: sale_returns.length > 0 ? '' : 'none'}">
					<h5 style="margin-bottom: 0px;font-weight:bold">Sale Return</h5>
					<table class="record-table">
						<thead style="background: red;">
							<tr>
								<th>নং.</th>
								<th>ফেরত তারিখ</th>
								<th>ক্রেতার নাম</th>
								<th>পণ্যের নাম</th>
								<th>পণ্যের আকার</th>
								<th>বর্ণনা</th>
								<th>পরিমাণ</th>
								<th>ফেরত তারিখ</th>
								<th>মোট</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(row,sl) in sale_returns">
								<td>{{ sl + 1 }}</td>
								<td>{{ row.ReturnDate }}</td>
								<td>{{ row.Customer_Name }}</td>
								<td>{{ row.Product_Name }}</td>
								<td>{{ row.product_size }}</td>
								<td>{{ row.Description }}</td>
								<td style="text-align:center;">{{ row.ProductQty }}</td>
								<td style="text-align:right;">{{ row.ReturnRate }}</td>
								<td style="text-align:right;">{{ row.ReturnAmount }}</td>
							</tr>
						</tbody>
						<tfoot>
							<tr style="font-weight:bold;">
								<td colspan="6" style="text-align:right;">Total</td>
								<td style="text-align:center;">{{ sale_returns.reduce((prev, curr) => { return prev + parseFloat(curr.ProductQty)}, 0) }}</td>
								<td style="text-align:right;">{{ sale_returns.reduce((prev, curr) => { return prev + parseFloat(curr.ReturnRate)}, 0) }}</td>
								<td style="text-align:right;">{{ sale_returns.reduce((prev, curr) => { return prev + parseFloat(curr.ReturnAmount)}, 0) }}</td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/lodash.min.js"></script>

<script>
	Vue.component('v-select', VueSelect.VueSelect);
	new Vue({
		el: '#salesRecord',
		data() {
			return {
				searchType: '',
				recordType: 'without_details',
				dateFrom: moment().format('YYYY-MM-DD'),
				dateTo: moment().format('YYYY-MM-DD'),
				customers: [],
				selectedCustomer: null,
				employees: [],
				selectedEmployee: null,
				products: [],
				selectedProduct: null,
				users: [],
				selectedUser: null,
				categories: [],
				selectedCategory: null,
				companies: [],
				selectedCompany: null,
				sales: [],
				sale_returns: [],
				searchTypesForRecord: ['', 'user', 'customer', 'employee'],
				searchTypesForDetails: ['quantity', 'category', 'company']
			}
		},
		methods: {
			getCompanies() {
				axios.get('/get_companies').then(res => {
					this.companies = res.data;
				})
			},
			getCompanyProduct() {
				if (this.selectedCompany != null) {
					axios.post('/get_products', {
						companyId: this.selectedCompany.company_id
					}).then(res => {
						this.products = res.data;
					})
				}
			},
			checkReturnAndEdit(sale) {
				axios.get('/check_sale_return/' + sale.SaleMaster_InvoiceNo).then(res => {
					if (res.data.found) {
						alert('Unable to edit. Sale return found!');
					} else {
						if (sale.is_service == 'true') {
							location.replace('/sales/service/' + sale.SaleMaster_SlNo);
						} else {
							location.replace('/sales/product/' + sale.SaleMaster_SlNo);
						}
					}
				})
			},
			onChangeSearchType() {
				this.sales = [];
				if (this.searchType == 'quantity') {
					this.getProducts();
				} else if (this.searchType == 'user') {
					this.getUsers();
				} else if (this.searchType == 'category') {
					this.getCategories();
				} else if (this.searchType == 'customer') {
					this.getCustomers();
				} else if (this.searchType == 'employee') {
					this.getEmployees();
				} else if (this.searchType == 'company') {
					this.getCompanies();
				}
			},
			getProducts() {
				axios.get('/get_products').then(res => {
					this.products = res.data;
				})
			},
			getCustomers() {
				axios.get('/get_customers').then(res => {
					this.customers = res.data;
				})
			},
			getEmployees() {
				axios.get('/get_employees').then(res => {
					this.employees = res.data;
				})
			},
			getUsers() {
				axios.get('/get_users').then(res => {
					this.users = res.data;
				})
			},
			getCategories() {
				axios.get('/get_categories').then(res => {
					this.categories = res.data;
				})
			},
			getSearchResult() {
				if (this.searchType != 'company') {
					this.selectedCompany = null;
				}

				if (this.searchType != 'customer') {
					this.selectedCustomer = null;
				}

				if (this.searchType != 'employee') {
					this.selectedEmployee = null;
				}

				if (this.searchType != 'quantity' && this.searchType != 'company') {
					this.selectedProduct = null;
				}

				if (this.searchType != 'category') {
					this.selectedCategory = null;
				}

				if (this.searchTypesForRecord.includes(this.searchType)) {
					this.getSalesRecord();
				} else {
					this.getSaleDetails();
				}
			},
			getSalesRecord() {
				let filter = {
					userFullName: this.selectedUser == null || this.selectedUser.FullName == '' ? '' : this.selectedUser.FullName,
					customerId: this.selectedCustomer == null || this.selectedCustomer.Customer_SlNo == '' ? '' : this.selectedCustomer.Customer_SlNo,
					employeeId: this.selectedEmployee == null || this.selectedEmployee.Employee_SlNo == '' ? '' : this.selectedEmployee.Employee_SlNo,
					dateFrom: this.dateFrom,
					dateTo: this.dateTo
				}

				let url = '/get_sales';
				if (this.recordType == 'with_details') {
					url = '/get_sales_record';
				}

				axios.post(url, filter)
					.then(res => {
						if (this.recordType == 'with_details') {
							this.sales = res.data.sales;
							this.sale_returns = res.data.sale_return;
						} else {
							this.sales = res.data.sales;
							this.sale_returns = res.data.sale_return;
						}
					})
					.catch(error => {
						if (error.response) {
							alert(`${error.response.status}, ${error.response.statusText}`);
						}
					})
			},
			getSaleDetails() {
				let filter = {
					companyId: this.selectedCompany == null || this.selectedCompany.company_id == '' ? '' : this.selectedCompany.company_id,
					categoryId: this.selectedCategory == null || this.selectedCategory.ProductCategory_SlNo == '' ? '' : this.selectedCategory.ProductCategory_SlNo,
					productId: this.selectedProduct == null || this.selectedProduct.Product_SlNo == '' ? '' : this.selectedProduct.Product_SlNo,
					dateFrom: this.dateFrom,
					dateTo: this.dateTo
				}

				axios.post('/get_saledetails', filter)
					.then(res => {
						let sales = res.data;

						if (this.selectedProduct == null) {
							sales = _.chain(sales)
								.groupBy('ProductCategory_ID')
								.map(sale => {
									return {
										category_name: sale[0].ProductCategory_Name,
										products: _.chain(sale)
											.groupBy('Product_IDNo')
											.map(product => {
												return {
													product_code: product[0].Product_Code,
													product_name: product[0].Product_Name,
													quantity: _.sumBy(product, item => Number(item.SaleDetails_TotalQuantity))
												}
											})
											.value()
									}
								})
								.value();
						}
						this.sales = sales;
					})
					.catch(error => {
						if (error.response) {
							alert(`${error.response.status}, ${error.response.statusText}`);
						}
					})
			},
			deleteSale(saleId) {
				let deleteConf = confirm('Are you sure?');
				if (deleteConf == false) {
					return;
				}
				axios.post('/delete_sales', {
						saleId: saleId
					})
					.then(res => {
						let r = res.data;
						alert(r.message);
						if (r.success) {
							this.getSalesRecord();
						}
					})
					.catch(error => {
						if (error.response) {
							alert(`${error.response.status}, ${error.response.statusText}`);
						}
					})
			},
			async print() {
				let dateText = '';
				if (this.dateFrom != '' && this.dateTo != '') {
					dateText = `Statement from <strong>${this.dateFrom}</strong> to <strong>${this.dateTo}</strong>`;
				}

				let userText = '';
				if (this.selectedUser != null && this.selectedUser.FullName != '' && this.searchType == 'user') {
					userText = `<strong>Sold by: </strong> ${this.selectedUser.FullName}`;
				}

				let customerText = '';
				if (this.selectedCustomer != null && this.selectedCustomer.Customer_SlNo != '' && this.searchType == 'customer') {
					customerText = `<strong>Customer: </strong> ${this.selectedCustomer.Customer_Name}<br>`;
				}

				let employeeText = '';
				if (this.selectedEmployee != null && this.selectedEmployee.Employee_SlNo != '' && this.searchType == 'employee') {
					employeeText = `<strong>Employee: </strong> ${this.selectedEmployee.Employee_Name}<br>`;
				}

				let productText = '';
				if (this.selectedProduct != null && this.selectedProduct.Product_SlNo != '' && this.searchType == 'quantity') {
					productText = `<strong>Product: </strong> ${this.selectedProduct.Product_Name}`;
				}

				let categoryText = '';
				if (this.selectedCategory != null && this.selectedCategory.ProductCategory_SlNo != '' && this.searchType == 'category') {
					categoryText = `<strong>Category: </strong> ${this.selectedCategory.ProductCategory_Name}`;
				}


				let reportContent = `
					<div class="container">
						<div class="row">
							<div class="col-xs-12 text-center">
								<h3>Sales Record</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								${userText} ${customerText} ${employeeText} ${productText} ${categoryText}
							</div>
							<div class="col-xs-6 text-right">
								${dateText}
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								${document.querySelector('#reportContent').innerHTML}
							</div>
						</div>
					</div>
				`;

				var reportWindow = window.open('', 'PRINT', `height=${screen.height}, width=${screen.width}`);
				reportWindow.document.write(`
					<?php $this->load->view('Administrator/reports/reportHeader.php'); ?>
				`);

				reportWindow.document.head.innerHTML += `
					<style>
						.record-table{
							width: 100%;
							border-collapse: collapse;
						}
						.record-table thead{
							background-color: #0097df;
							color:white;
						}
						.record-table th, .record-table td{
							padding: 3px;
							border: 1px solid #454545;
						}
						.record-table th{
							text-align: center;
						}
					</style>
				`;
				reportWindow.document.body.innerHTML += reportContent;

				if (this.searchType == '' || this.searchType == 'user') {
					let rows = reportWindow.document.querySelectorAll('.record-table tr');
					rows.forEach(row => {
						row.lastChild.remove();
					})
				}


				reportWindow.focus();
				await new Promise(resolve => setTimeout(resolve, 1000));
				reportWindow.print();
				reportWindow.close();
			}
		}
	})
</script>