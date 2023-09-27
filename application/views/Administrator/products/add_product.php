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

	#products label {
		font-size: 13px;
	}

	#products select {
		border-radius: 3px;
	}

	#products .add-button {
		padding: 2.5px;
		width: 28px;
		background-color: #298db4;
		display: block;
		text-align: center;
		color: white;
	}

	#products .add-button:hover {
		background-color: #41add6;
		color: white;
	}

	.v-select .selected-tag {
		position: relative;
	}
</style>
<div id="products">
	<form @submit.prevent="saveProduct">
		<div class="row" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom: 15px;">
			<div class="col-md-6">
				<div class="form-group clearfix">
					<label class="control-label col-md-4">পণ্য আইডি:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="product.Product_Code">
					</div>
				</div>


				<div class="form-group clearfix">
					<label class="control-label col-md-4">পণ্য নাম :</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="product.Product_Name" required>
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4"> আর্টিকেল নং :</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="product.Product_Article" required>
					</div>
				</div>
				<!-- <div class="form-group clearfix">
					<label class="control-label col-md-4">Size:</label>
					<div class="col-md-7">
						<v-select multiple v-bind:options="sizes" v-model="selectedSize" label="size_name"></v-select>
					</div>
					<div class="col-md-1" style="padding:0;margin-left: -15px;"><a href="/add_size" target="_blank" class="add-button"><i class="fa fa-plus"></i></a></div>
				</div> -->

				<div class="form-group clearfix">
					<label class="control-label col-md-4">প্রতিষ্ঠান:</label>
					<div class="col-md-7">
						<v-select v-bind:options="companies" v-model="selectedCompany" label="company_name"></v-select>
					</div>
					<div class="col-md-1" style="padding:0;margin-left: -15px;"><a href="/company" target="_blank" class="add-button"><i class="fa fa-plus"></i></a></div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">ক্যাটাগরি:</label>
					<div class="col-md-7">
						<select class="form-control" v-if="categories.length == 0"></select>
						<v-select v-bind:options="categories" v-model="selectedCategory" label="ProductCategory_Name" v-if="categories.length > 0"></v-select>
					</div>
					<div class="col-md-1" style="padding:0;margin-left: -15px;"><a href="/category" target="_blank" class="add-button"><i class="fa fa-plus"></i></a></div>
				</div>



				<!-- <div class="form-group clearfix" style="display:none;">
					<label class="control-label col-md-4">Brand:</label>
					<div class="col-md-7">
						<select class="form-control" v-if="brands.length == 0"></select>
						<v-select v-bind:options="brands" v-model="selectedBrand" label="brand_name" v-if="brands.length > 0"></v-select>
					</div>
					<div class="col-md-1" style="padding:0;margin-left: -15px;"><a href="" class="add-button"><i class="fa fa-plus"></i></a></div>
				</div> -->

				<div class="form-group clearfix">
					<label class="control-label col-md-4">ইউনিট:</label>
					<div class="col-md-7">
						<select class="form-control" v-if="units.length == 0"></select>
						<v-select v-bind:options="units" v-model="selectedUnit" label="Unit_Name" v-if="units.length > 0"></v-select>
					</div>
					<div class="col-md-1" style="padding:0;margin-left: -15px;"><a href="/unit" target="_blank" class="add-button"><i class="fa fa-plus"></i></a></div>
				</div>
				<div class="form-group clearfix">
					<label class="control-label col-md-4">ভ্যাট:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="product.vat">
					</div>
				</div>
			</div>

			<div class="col-md-6">
				<div class="form-group clearfix">
					<label class="control-label col-md-4">পুনঃ ওডার স্তর:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="product.Product_ReOrederLevel" required>
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">ক্রয় হার:</label>
					<div class="col-md-7">
						<input type="text" id="purchase_rate" class="form-control" v-model="product.Product_Purchase_Rate" required v-bind:disabled="product.is_service ? true : false">
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">MRP হার:</label>
					<div class="col-md-7">
						<input type="number" step="0.01" class="form-control" v-model="product.Product_SellingPrice" v-on:input="onChangePercent();onChangeDisPercent()" required>
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">বিক্রয় ডিসকাউন্ট:</label>
					<div class="col-md-7">
						<!-- <input type="number" class="form-control" v-model="product.Product_SaleCommission" required> -->
						<div class="row">
							<div class="col-md-2">
								<label class="control-label col-md-4 no-padding-left">শতাংশ:</label>
							</div>
							<div class="col-md-4">
								<input v-bind:disabled="product.Product_SellingPrice == 0 ? true : false" type="number" step="0.01" class="form-control" v-model="SaleDiscountPercent" v-on:input="onChangeDisPercent" id="DisPercent">
							</div>
							<div class="col-md-2">
								<label class="control-label col-md-4">টাকা:</label>
							</div>
							<div class="col-md-4">
								<input v-bind:disabled="product.Product_SellingPrice == 0 ? true : false" type="number" step="0.01" class="form-control" v-model="product.Product_SaleDiscount" v-on:input="onChangeDisPercent">
							</div>
						</div>
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">ডিসকাউন্ট পরে:</label>
					<div class="col-md-7">
						<input type="number" step="0.01" class="form-control" v-model="product.Product_after_discount" requiredb readonly>
					</div>
				</div>
				<div class="form-group clearfix">
					<label class="control-label col-md-4">পণ্যের পয়েন্ট:</label>
					<div class="col-md-7">
						<input type="number" step="0.01" class="form-control" v-model="product.Product_Point" required>
					</div>
				</div>




				<div class="form-group clearfix">
					<label class="control-label col-md-4">বিক্রয় কমিশন:</label>
					<div class="col-md-7">
						<!-- <input type="number" class="form-control" v-model="product.Product_SaleCommission" required> -->
						<div class="row">
							<div class="col-md-2">
								<label class="control-label col-md-4 no-padding-left">শতাংশ:</label>
							</div>
							<div class="col-md-4">
								<input v-bind:disabled="product.Product_SellingPrice == 0 ? true : false" type="number" step="0.01" class="form-control" v-model="SaleCommissionPercent" v-on:input="onChangePercent" id="percent">
							</div>
							<div class="col-md-2">
								<label class="control-label col-md-4">টাকা:</label>
							</div>
							<div class="col-md-4">
								<input v-bind:disabled="product.Product_SellingPrice == 0 ? true : false" type="number" step="0.01" class="form-control" v-model="product.Product_SaleCommission" v-on:input="onChangePercent">
							</div>
						</div>
					</div>
				</div>


				<div class="form-group clearfix">
					<label class="control-label col-md-4">ইস সার্ভিস:</label>
					<div class="col-md-7">
						<input type="checkbox" v-model="product.is_service" @change="changeIsService">
					</div>
				</div>

				<div class="form-group clearfix">
					<div class="col-md-7 col-md-offset-4">
						<input type="submit" class="btn btn-success btn-sm" value="সেভ">
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
				<datatable :columns="columns" :data="products" :filter-by="filter">
					<template scope="{ row }">
						<tr>
							<td>{{ row.Product_Code }}</td>
							<td>{{ row.Product_Name }}</td>
							<td>{{ row.company_name }}</td>
							<td>{{ row.ProductCategory_Name }}</td>
							<td>{{ row.Product_Article }}</td>
							<td>{{ row.Product_Purchase_Rate }}</td>
							<td>{{ row.Product_SellingPrice }}</td>
							<td>{{ row.Product_after_discount }}</td>
							<td>{{ row.Product_SaleCommission }}</td>
							<td>{{ row.Product_Point }}</td>
							<td>{{ row.vat }}</td>
							<td>{{ row.is_service }}</td>
							<td>{{ row.Unit_Name }}</td>
							<td>
								<?php if ($this->session->userdata('accountType') != 'u') { ?>
									<button type="button" class="button edit" @click="editProduct(row)">
										<i class="fa fa-pencil"></i>
									</button>
									<button type="button" class="button" @click="deleteProduct(row.Product_SlNo)">
										<i class="fa fa-trash"></i>
									</button>
								<?php } ?>
								<button type="button" class="button" @click="window.location = `/Administrator/products/barcodeGenerate/${row.Product_SlNo}`">
									<i class="fa fa-barcode"></i>
								</button>
							</td>
						</tr>
					</template>
				</datatable>
				<datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
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
		el: '#products',
		data() {
			return {
				product: {
					Product_SlNo: '',
					Product_Code: "<?php echo $productCode; ?>",
					Product_Name: '',
					Product_Company: '',
					ProductCategory_ID: '',
					Product_Article: '',
					Product_ReOrederLevel: '',
					Product_Purchase_Rate: '',
					Product_SellingPrice: 0,
					Product_after_discount: 0,
					Product_Point: 0,
					Product_SaleCommission: 0,
					Product_SaleDiscount: 0,
					Unit_ID: '',
					vat: 0,
					is_service: false
				},
				SaleCommissionPercent: 0,
				SaleDiscountPercent: 0,
				products: [],
				companies: [],
				selectedCompany: null,
				categories: [],
				selectedCategory: null,
				brands: [],
				selectedBrand: null,
				units: [],
				selectedUnit: null,
				sizes: [],
				selectedSize: null,

				columns: [{
						label: 'পণ্য আইডি',
						field: 'Product_Code',
						align: 'center',
						filterable: false
					},
					{
						label: 'পণ্য নাম',
						field: 'Product_Name',
						align: 'center'
					},
					{
						label: 'প্রতিষ্ঠানের নাম ',
						field: 'company_name',
						align: 'center'
					},
					{
						label: 'ক্যাটাগরি',
						field: 'ProductCategory_Name',
						align: 'center'
					},
					{
						label: 'আর্টিকেল নং',
						field: 'Product_Article',
						align: 'center'
					},
					{
						label: 'Pur. দাম',
						field: 'Product_Purchase_Rate',
						align: 'center'
					},
					{
						label: 'MRP দাম',
						field: 'Product_SellingPrice',
						align: 'center'
					},
					{
						label: 'ডিসকাউন্টের পরে মূল্য',
						field: 'Product_after_discount',
						align: 'center'
					},
					{
						label: 'কমিশন',
						field: 'Product_SaleCommission',
						align: 'center'
					},
					{
						label: 'পণ্য পয়েন্ট',
						field: 'Product_Point',
						align: 'center'
					},
					{
						label: 'ভ্যাট',
						field: 'vat',
						align: 'center'
					},
					{
						label: 'ইস সার্ভিস', 
						field: 'is_service',
						align: 'center'
					},
					{
						label: 'ইউনিট',
						field: 'Unit_Name',
						align: 'center'
					},
					{
						label: 'কর্ম',
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
			this.getCompanies();
			this.getCategories();
			this.getBrands();
			this.getUnits();
			this.getProducts();
			this.getSizes();
		},
		methods: {
			getSizes() {
				axios.get('/get_sizes').then(res => {
					this.sizes = res.data;
				})
			},
			getCompanies() {
				axios.get('/get_companies').then(res => {
					this.companies = res.data;
				})
			},
			changeIsService() {
				if (this.product.is_service) {
					this.product.Product_Purchase_Rate = 0;
				}
			},
			getCategories() {
				axios.get('/get_categories').then(res => {
					this.categories = res.data;
				})
			},
			getBrands() {
				axios.get('/get_brands').then(res => {
					this.brands = res.data;
				})
			},
			getUnits() {
				axios.get('/get_units').then(res => {
					this.units = res.data;
				})
			},
			getProducts() {
				axios.get('/get_products').then(res => {
					this.products = res.data;
				})
			},
			onChangePercent() {
				if (event.target.id == 'percent') {
					this.product.Product_SaleCommission = parseFloat((this.product.Product_SellingPrice - this.product.Product_SaleDiscount) * this.SaleCommissionPercent / 100).toFixed(2);
				} else {
					this.SaleCommissionPercent = parseFloat(this.product.Product_SaleCommission * 100 / (this.product.Product_SellingPrice - this.product.Product_SaleDiscount)).toFixed(2);
				}
			},
			onChangeDisPercent() {
				if (event.target.id == 'DisPercent') {
					this.product.Product_SaleDiscount = parseFloat(this.product.Product_SellingPrice * this.SaleDiscountPercent / 100).toFixed(2);
				} else {
					this.SaleDiscountPercent = parseFloat(this.product.Product_SaleDiscount * 100 / this.product.Product_SellingPrice).toFixed(2);
				}

				this.product.Product_after_discount = this.product.Product_SellingPrice - this.product.Product_SaleDiscount;
			},
			saveProduct() {
				if (this.selectedCompany == null) {
					alert('Select a company');
					return;
				}
				if (this.selectedCategory == null) {
					alert('Select a category');
					return;
				}
				if (this.selectedUnit == null) {
					alert('Select an unit');
					return;
				}
				if (this.selectedBrand != null) {
					this.product.brand = this.selectedBrand.brand_SiNo;
				}

				this.product.ProductCategory_ID = this.selectedCategory.ProductCategory_SlNo;
				this.product.Unit_ID = this.selectedUnit.Unit_SlNo;
				this.product.Product_Company = this.selectedCompany.company_id;

				let url = '/add_product';
				if (this.product.Product_SlNo != 0) {
					url = '/update_product';
				}
				// console.log(this.product);
				// return;
				axios.post(url, this.product)
					.then(res => {
						let r = res.data;
						alert(r.message);
						if (r.success) {
							this.clearForm();
							this.product.Product_Code = r.productId;
							this.getProducts();
						}
					})

			},
			editProduct(product) {
				let keys = Object.keys(this.product);
				keys.forEach(key => {
					this.product[key] = product[key];
				})

				this.product.is_service = product.is_service == 'true' ? true : false;

				this.selectedCategory = {
					ProductCategory_SlNo: product.ProductCategory_ID,
					ProductCategory_Name: product.ProductCategory_Name
				}

				this.selectedUnit = {
					Unit_SlNo: product.Unit_ID,
					Unit_Name: product.Unit_Name
				}

				this.selectedCompany = {
					company_id: product.Product_Company,
					company_name: product.company_name
				}

				this.onChangePercent();
				this.onChangeDisPercent();
			},
			deleteProduct(productId) {
				let deleteConfirm = confirm('Are you sure?');
				if (deleteConfirm == false) {
					return;
				}
				axios.post('/delete_product', {
					productId: productId
				}).then(res => {
					let r = res.data;
					alert(r.message);
					if (r.success) {
						this.getProducts();
					}
				})
			},
			clearForm() {
				let keys = Object.keys(this.product);
				keys.forEach(key => {
					if (typeof(this.product[key]) == "string") {
						this.product[key] = '';
					} else if (typeof(this.product[key]) == "number") {
						this.product[key] = 0;
					}
				})

				this.selectedCompany = null;
				this.selectedCategory = null;
				this.selectedUnit = null;

				this.SaleCommissionPercent = 0.00;
			}
		}
	})
</script>