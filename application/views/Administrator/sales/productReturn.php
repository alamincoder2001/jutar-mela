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

	#cashTransaction label {
		font-size: 13px;
	}

	#cashTransaction select {
		border-radius: 3px;
		padding: 0;
	}

	#cashTransaction .add-button {
		padding: 2.5px;
		width: 28px;
		background-color: #298db4;
		display: block;
		text-align: center;
		color: white;
	}

	#cashTransaction .add-button:hover {
		background-color: #41add6;
		color: white;
	}
</style>
<div id="cashTransaction">
	<div class="row" style="border-bottom: 1px solid #ccc;padding-bottom: 15px;margin-bottom: 15px;">
		<div class="col-md-12">
			<form @submit.prevent="addProductReturn">
				<div class="row">
					<div class="col-md-5 col-md-offset-1">
						<div class="form-group">
							<label class="col-md-4 control-label">তারিখ</label>
							<label class="col-md-1">:</label>
							<div class="col-md-7">
								<input type="date" class="form-control" required v-model="inputField.ReturnDate" v-bind:disabled="userType == 'u' ? true : false">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">কাস্টমার নাম</label>
							<label class="col-md-1">:</label>
							<div class="col-md-7 col-xs-11">
								<v-select v-bind:options="customers" v-model="selectedCustomer" label="display_name"></v-select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">বিবরণ</label>
							<label class="col-md-1">:</label>
							<div class="col-md-7">
								<textarea class="form-control" v-model="inputField.Description" cols="30" rows="2"></textarea>
							</div>
						</div>
					</div>

					<div class="col-md-5">
						<div class="form-group">
							<label class="col-md-4 control-label">আর্টিকেল নাম</label>
							<label class="col-md-1">:</label>
							<div class="col-md-7 col-xs-11">
								<v-select v-bind:options="products" v-model="selectedProduct" label="display_text" v-on:input="getTotal();productOnChange()"></v-select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label no-padding-right"> সাইজ </label>
							<label class="col-md-1">:</label>
							<div class="col-sm-7">
								<v-select v-bind:options="pSizes" v-model="selectedSize" label="product_size"></v-select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label"> পরিমাণ</label>
							<label class="col-md-1">:</label>
							<div class="col-md-7">
								<div class="row">
									<div class="col-md-5">
										<input type="number" class="form-control" required v-model="inputField.ProductQty" v-on:input="getTotal">
									</div>
									<div class="col-md-2">
										<label class="col-md-4 control-label"> মূল্য</label>
									</div>
									<div class="col-md-5">
										<input type="number" class="form-control" step="0.01" required v-model="selectedProduct.Product_after_discount" v-on:input="getTotal">
									</div>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label"> মোট টাকা</label>
							<label class="col-md-1">:</label>
							<div class="col-md-7">
								<input type="number" class="form-control" step="0.01" required v-model="inputField.ReturnAmount" readonly>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-7 col-md-offset-5">
								<input type="submit" class="btn btn-success btn-sm" value="সেভ">
								<input type="button" class="btn btn-danger btn-sm" value="বাতিল" @click="resetForm">
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12 form-inline">
			<div class="form-group">
				<label for="filter" class="sr-only">Filter</label>
				<input type="text" class="form-control" v-model="filter" placeholder="Filter">
			</div>
		</div>
		<div class="col-md-12">
			<div class="table-responsive">
				<datatable :columns="columns" :data="allReturns" :filter-by="filter" style="margin-bottom: 5px;">
					<template scope="{ row }">
						<tr>
							<td>{{ row.ProductReturn_SlNo }}</td>
							<td>{{ row.ReturnDate }}</td>
							<td>{{ row.Customer_Name }}</td>
							<td>{{ row.Product_Article }}</td>
							<td>{{ row.product_size }}</td>
							<td>{{ row.ProductQty }}</td>
							<td>{{ row.ReturnRate }}</td>
							<td>{{ row.ReturnAmount }}</td>
							<td>{{ row.Description }}</td>
							<td>{{ row.AddBy }}</td>
							<td>
								<?php if ($this->session->userdata('accountType') != 'u') { ?>
									<button type="button" class="button edit" @click="editTransaction(row)">
										<i class="fa fa-pencil"></i>
									</button>
									<button type="button" class="button" @click="deleteTransaction(row.ProductReturn_SlNo)">
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
		el: '#cashTransaction',
		data() {
			return {
				inputField: {
					ProductReturn_SlNo: '',
					ReturnDate: moment().format('YYYY-MM-DD'),
					ProductQty: 1,
					ReturnRate: 0.00,
					ReturnAmount: 0.00,
					Description: '',
				},
				customers: [],
				selectedCustomer: {
					Customer_SlNo: '',
					display_name: 'Select',
				},
				products: [],
				selectedProduct: {
					Product_SlNo: '',
					display_text: 'Select',
				},
				pSizes: [],
				selectedSize: {
					Product_SlNo: '',
					product_size: 'Select'
				},

				allReturns: [],
				accounts: [],
				selectedAccount: null,
				userType: '<?php echo $this->session->userdata("accountType"); ?>',

				columns: [{
						label: 'নং',
						field: 'ProductReturn_SlNo',
						align: 'center'
					},
					{
						label: 'তারিখ',
						field: 'ReturnDate',
						align: 'center'
					},
					{
						label: 'কাস্টমার নাম',
						field: 'Customer_Name',
						align: 'center'
					},
					{
						label: 'আর্টিকেল নাম',
						field: 'Product_Article',
						align: 'center'
					},
					{
						label: 'সাইজ',
						field: 'product_size',
						align: 'center'
					},
					{
						label: 'পরিমাণ',
						field: 'ProductQty',
						align: 'center'
					},
					{
						label: 'পণ্যের দর',
						field: 'ReturnRate',
						align: 'center'
					},
					{
						label: 'মোট টাকা',
						field: 'ReturnAmount',
						align: 'center'
					},
					{
						label: 'বিবরণ',
						field: 'Description',
						align: 'center'
					},
					{
						label: 'সেভ বাই',
						field: 'AddBy',
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
			// this.getTransactionCode();
			// this.getAccounts();
			this.getAllReturns();
			this.getCustomers();
			this.getProducts();
		},
		methods: {
			getCustomers() {
				axios.get('/get_customers').then(res => {
					this.customers = res.data;
					this.customers.unshift({
						Customer_SlNo: 'C01',
						Customer_Code: '',
						Customer_Name: '',
						display_name: 'General Customer',
						Customer_Mobile: '',
						Customer_Address: '',
						Customer_Type: 'G'
					})
				})
			},
			getProducts() {
				axios.get('/get_products').then(res => {
					this.products = res.data;
				})
			},
			getTotal() {
				if (this.selectedProduct.Product_SlNo == '') return;
				let total = parseFloat(+this.selectedProduct.Product_after_discount * +this.inputField.ProductQty).toFixed(2)
				this.inputField.ReturnAmount = total;
			},
			productOnChange() {
				this.getSize();
			},
			getSize() {
				if (this.selectedProduct.Product_SlNo == '') return;
				axios.post('/get_product_sizes', {
					productId: this.selectedProduct.Product_SlNo
				}).then(res => {
					this.pSizes = res.data;

				})
				// document.querySelector('#pSize input[type="search"]').focus();
			},



			getAllReturns() {
				// let data = {
				// 	dateFrom: this.inputField.ReturnDate,
				// 	dateTo: this.inputField.Tr_date
				// }

				axios.get('/get_product_return').then(res => {
					this.allReturns = res.data;
				})
			},
			addProductReturn() {
				if (this.selectedCustomer.Customer_SlNo == '') {
					alert('Select a customer');
					return;
				}
				if (this.selectedProduct.Product_SlNo == '') {
					alert('Select a product');
					return;
				}
				if (this.selectedSize.Product_SlNo == '') {
					alert('Select a size');
					return;
				}
				if (+this.inputField.ProductQty <= 0) {
					alert('product Qty not valid');
					return;
				}
				if (+this.selectedProduct.Product_after_discount <= 0) {
					alert('product Rate is not valie');
					return;
				}

				this.inputField.customer_id = this.selectedCustomer.Customer_SlNo;
				this.inputField.product_id = this.selectedProduct.Product_SlNo;
				this.inputField.ReturnRate = this.selectedProduct.Product_after_discount;
				this.inputField.product_size = this.selectedSize.product_size;

				let url = '/add_product_return';
				if (this.inputField.ProductReturn_SlNo != '') {
					url = '/update_product_return';
				}
				// console.log(this.inputField);
				// return

				axios.post(url, this.inputField).then(res => {
					let r = res.data;
					alert(r.message);
					if (r.success) {
						this.resetForm();
						this.getAllReturns();
					}
				})
			},
			editTransaction(inputdata) {
				this.inputField.ProductReturn_SlNo = inputdata.ProductReturn_SlNo;
				this.inputField.ReturnDate = inputdata.ReturnDate;
				this.inputField.ProductQty = inputdata.ProductQty;
				this.inputField.Description = inputdata.Description;

				this.selectedCustomer = {
					Customer_SlNo: inputdata.customer_id,
					display_name: inputdata.display_name,
				};
				this.selectedProduct = {
					Product_SlNo: inputdata.product_id,
					display_text: inputdata.display_text,
					Product_after_discount: inputdata.ReturnRate,
				}
				this.selectedSize = {
					Product_SlNo: inputdata.product_id,
					product_size: inputdata.product_size
				}

			},
			deleteTransaction(transactionId) {
				let conf = confirm('Are you sure to delete');
				if (!conf) return;
				axios.post('/delete_product_return', {
					prId: transactionId
				}).then(res => {
					let r = res.data;
					alert(r.message);
					if (r.success) {
						this.getAllReturns();
					}
				})
			},
			resetForm() {
				this.inputField.ProductReturn_SlNo = '';
				this.inputField.ReturnDate = moment().format('YYYY-MM-DD');
				this.inputField.ProductQty = 1;
				this.inputField.ReturnRate = 0.00;
				this.inputField.ReturnAmount = 0.00;
				this.inputField.Description = '';
				this.selectedCustomer = {
					Customer_SlNo: '',
					display_name: 'Select',
				};
				this.selectedProduct = {
					Product_SlNo: '',
					Product_Article: 'Select',
				}
			}
		}
	})
</script>