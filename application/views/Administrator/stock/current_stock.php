<style>
	.v-select {
		margin-bottom: 5px;
	}

	.v-select .dropdown-toggle {
		padding: 0px;
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
</style>
<div id="stock">
	<div class="row">
		<div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;margin-bottom:5px;">
			<div class="form-group" style="margin-top:10px;">
				<label class="col-sm-1 control-label no-padding-right"> নির্বাচন করুন </label>
				<div class="col-sm-2">
					<v-select v-bind:options="searchTypes" v-model="selectedSearchType" label="text" v-on:input="onChangeSearchType"></v-select>
				</div>
			</div>

			<div class="form-group" style="margin-top:10px;" v-if="selectedSearchType.value == 'category'">
				<div class="col-sm-2" style="margin-left:15px;">
					<v-select v-bind:options="categories" v-model="selectedCategory" label="ProductCategory_Name"></v-select>
				</div>
			</div>

			<div class="form-group" style="margin-top:10px;" v-if="selectedSearchType.value == 'product' || selectedSearchType.value == 'size'">
				<div class="col-sm-2" style="margin-left:15px;">
					<v-select v-bind:options="products" v-model="selectedProduct" label="display_text" v-on:input="productOnChange"></v-select>
				</div>
			</div>

			<div class="form-group" style="margin-top:10px;" v-if="selectedSearchType.value == 'brand'">
				<div class="col-sm-2" style="margin-left:15px;">
					<v-select v-bind:options="brands" v-model="selectedBrand" label="brand_name"></v-select>
				</div>
			</div>

			<div class="form-group" style="margin-top:10px;" v-if="selectedSearchType.value == 'size'">
				<div class="col-sm-2" style="margin-left:15px;">
					<v-select v-bind:options="pSizes" v-model="selectedSize" label="product_size"></v-select>
				</div>
			</div>

			<div class="form-group" style="margin-top:10px;">
				<label class="col-sm-1 control-label"> প্রতিষ্ঠান </label>
				<div class="col-sm-2">
					<v-select v-bind:options="companies" v-model="selectedCompany" label="company_name"></v-select>
				</div>
			</div>

			<div class="form-group" style="margin-top:10px;" v-if="selectedSearchType.value != 'current' && selectedSearchType.value != 'size'">
				<div class="col-sm-2" style="margin-left:15px;">
					<input type="date" class="form-control" v-model="date">
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-1" style="margin-left:15px;">
					<input type="button" class="btn btn-primary" value="রিপোর্ট দেখুন" v-on:click="getStock" style="margin-top:0px;border:0px;height:28px;">
				</div>
			</div>
		</div>
	</div>
	<div class="row" v-if="searchType != null" style="display:none" v-bind:style="{display: searchType == null ? 'none' : ''}">
		<div class="col-md-12">
			<a href="" v-on:click.prevent="print"><i class="fa fa-print"></i> Print</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="table-responsive" id="stockContent">
				<table class="table table-bordered" v-if="searchType == 'current'" style="display:none" v-bind:style="{display: searchType == 'current' ? '' : 'none'}">
					<thead>
						<tr>
							<th>পণ্য আইডি</th>
							<th>পণ্যের নাম</th>
							<th>ক্যাটাগরি</th>
							<th>বর্তমান পরিমাণ</th>
							<th>ক্রয় হার</th>
							<th>স্টক ক্রয় মূল্য</th>
							<th>ছাড় কৃত হার</th>
							<th>ছাড় কৃত বিক্রয় মূল্য</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="product in stock">
							<td>{{ product.Product_Code }}</td>
							<td>{{ product.Product_Name }}</td>
							<td>{{ product.ProductCategory_Name }}</td>
							<td>{{ product.current_quantity }} {{ product.Unit_Name }}</td>
							<td>{{ product.Product_Purchase_Rate | decimal }}</td>
							<td>{{ product.stock_value | decimal }}</td>
							<td>{{ product.Product_after_discount | decimal }}</td>
							<td>{{ product.sale_stock_value | decimal }}</td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<th colspan="3" style="text-align:right;">Total Stock Value</th>
							<th>{{ stock.reduce((prev, curr) => {return +prev + parseFloat(curr.current_quantity)}, 0) | decimal }}</th>
							<th></th>
							<th>{{ totalStockValue | decimal }}</th>
							<th></th>
							<th>{{ (stock.reduce((prev, curr) => {return +prev + parseFloat(curr.sale_stock_value)}, 0)) | decimal }}</th>
						</tr>
					</tfoot>
				</table>

				<table class="table table-bordered" style="display:none;" v-bind:style="{display: searchType != 'current' && searchType != 'size' && searchType != null ? '' : 'none'}">
					<thead>
						<tr>
						    <th>পণ্য আইডি</th>
							<th>পণ্যের নাম</th>
							<th>ক্যাটাগরি</th>
							<th>ক্রয় পরিমাণ</th>
							<th>ক্রয় ফেরত পরিমাণ</th>
							<th>ক্ষতিগ্রস্থ পরিমাণ</th>
							<th>বিক্রির পরিমাণ</th>
							<th>বিক্রয় ফেরত পরিমাণ</th>
							<th>ট্রান্সফার ইন পরিমাণ</th>
							<th>ট্রান্সফার আউট পরিমাণ</th>
							<th>বর্তমান পরিমাণ</th>
							<th>ক্রয় মূল্য</th>
							<th>স্টক ক্রয় মূল্য</th>
							<th>ছাড় কৃত বিক্রয় মূল্য</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="product in stock">
							<td>{{ product.Product_Code }}</td>
							<td>{{ product.Product_Name }}</td>
							<td>{{ product.ProductCategory_Name }}</td>
							<td>{{ product.purchased_quantity }}</td>
							<td>{{ product.purchase_returned_quantity }}</td>
							<td>{{ product.damaged_quantity }}</td>
							<td>{{ product.sold_quantity }}</td>
							<td>{{ product.sales_returned_quantity }}</td>
							<td>{{ product.transferred_to_quantity}}</td>
							<td>{{ product.transferred_from_quantity}}</td>
							<td>{{ product.current_quantity }} {{ product.Unit_Name }}</td>
							<td>{{ product.Product_Purchase_Rate | decimal }}</td>
							<td>{{ product.stock_value | decimal }}</td>
							<td>{{ product.sale_stock_value | decimal }}</td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<th colspan="10" style="text-align:right;">Total Stock Value</th>
							<th>{{ stock.reduce((prev, curr) => {return +prev + parseFloat(curr.current_quantity)}, 0) | decimal }}</th>
							<th></th>
							<th>{{ totalStockValue | decimal }}</th>
							<th>{{ (stock.reduce((prev, curr) => {return +prev + parseFloat(curr.sale_stock_value)}, 0)) | decimal }}</th>
						</tr>
					</tfoot>
				</table>

				<table class="table table-bordered" style="display:none;" v-bind:style="{display: searchType == 'size' ? '' : 'none'}">
					<thead>
						<tr>
							<th>পণ্যের আইডি</th>
							<th>নিবন্ধের নাম</th>
							<th>আকার</th>
							<th>ক্রয়কৃত পরিমাণ</th>
							<th>ক্রয় ফেরত পরিমাণ</th>
							<th>ক্ষতিগ্রস্থ পরিমাণ</th>
							<th>বিক্রির পরিমাণ</th>
							<th>বিক্রয় ফেরত পরিমাণ</th>
							<th>বর্তমান পরিমাণ</th>
							<th>ক্রয় মূল্য</th>
							<th>স্টক ক্রয় মূল্য</th>
							<th>ছাড় কৃত বিক্রয় মূল্য</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="product in stock">
							<td>{{ product.Product_SlNo }}</td>
							<td>{{ product.Product_Article }}</td>
							<td>{{ product.product_size }}</td>
							<td>{{ product.purchased_quantity }}</td>
							<td>{{ product.purchase_returned_quantity }}</td>
							<td>{{ product.damaged_quantity }}</td>
							<td>{{ product.sold_quantity }}</td>
							<td>{{ product.sales_returned_quantity }}</td>
							<td>{{ product.current_quantity }} {{ product.Unit_Name }}</td>
							<td>{{ product.Product_Purchase_Rate | decimal }}</td>
							<td>{{ product.stock_value | decimal }}</td>
							<td>{{ product.sale_stock_value | decimal }}</td>
						</tr>
					</tbody>
					<!-- <tfoot>
						<tr>
							<th colspan="12" style="text-align:right;">Total Stock Value</th>
							<th>{{ totalStockValue | decimal }}</th>
						</tr>
					</tfoot> -->
				</table>
			</div>
		</div>
	</div>
</div>


<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script>
	Vue.component('v-select', VueSelect.VueSelect);
	new Vue({
		el: '#stock',
		data() {
			return {
				searchTypes: [{
						text: 'Current Stock',
						value: 'current'
					},
					{
						text: 'Total Stock',
						value: 'total'
					},
					{
						text: 'Category Wise Stock',
						value: 'category'
					},
					{
						text: 'Product Wise Stock',
						value: 'product'
					},
					{
						text: 'Size Wise Stock',
						value: 'size'
					},
					//{text: 'Brand Wise Stock', value: 'brand'}
				],
				pSizes: [],
				selectedSize: {
					Product_SlNo: '',
					product_size: 'Select Size'
				},
				selectedSearchType: {
					text: 'select',
					value: ''
				},
				companies: [],
				selectedCompany: null,
				searchType: null,
				date: moment().format('YYYY-MM-DD'),
				categories: [],
				selectedCategory: null,
				products: [],
				selectedProduct: null,
				brands: [],
				selectedBrand: null,
				selectionText: '',

				stock: [],
				totalStockValue: 0.00,
			}
		},
		filters: {
			decimal(value) {
				return value == null ? '0.00' : parseFloat(value).toFixed(2);
			}
		},
		created() {
			this.getCompanies();
		},
		methods: {
			productOnChange() {
				this.selectedSize = {
					Product_SlNo: '',
					product_size: 'Select Size'
				}
				this.getSize();
			},
			getSize() {
				if (this.selectedProduct.Product_SlNo == '') return;

				axios.post('/get_product_sizes', {
					productId: this.selectedProduct.Product_SlNo
				}).then(res => {
					this.pSizes = res.data;
				});
			},
			getCompanies() {
				axios.get('/get_companies').then(res => {
					this.companies = res.data;
				})
			},
			getStock() {
				this.searchType = this.selectedSearchType.value;
				let url = '';
				let parameters = {};

				parameters.companyId = this.selectedCompany != null ? this.selectedCompany.company_id : '';

				if (this.searchType == 'current') {
					url = '/get_current_stock';
				} else if (this.searchType == 'size') {
					url = '/get_size_wise_stock';
				} else {
					url = '/get_total_stock';
					parameters.date = this.date;
				}

				this.selectionText = "";

				if (this.searchType == 'category' && this.selectedCategory == null) {
					alert('Select a category');
					return;
				} else if (this.searchType == 'category' && this.selectedCategory != null) {
					parameters.categoryId = this.selectedCategory.ProductCategory_SlNo;
					this.selectionText = "Category: " + this.selectedCategory.ProductCategory_Name;
				}

				if (this.searchType == 'product' && this.selectedProduct == null) {
					alert('Select a product');
					return;
				} else if (this.searchType == 'product' && this.selectedProduct != null) {
					parameters.productId = this.selectedProduct.Product_SlNo;
					this.selectionText = "product: " + this.selectedProduct.display_text;
				}

				if (this.searchType == 'size' && this.selectedProduct != null && this.selectedSize.Product_SlNo == '') {
					alert('Select a size');
					return;
				} else if (this.searchType == 'size') {
					parameters.productId = this.selectedProduct == null ? '' : this.selectedProduct.Product_SlNo;
					parameters.productSize = this.selectedSize.Product_SlNo == '' ? '' : this.selectedSize.product_size;
					// 	this.selectionText = "Size: " + this.selectedSize.product_size;
				}

				// if (this.searchType == 'brand' && this.selectedBrand == null) {
				// 	alert('Select a brand');
				// 	return;
				// } else if (this.searchType == 'brand' && this.selectedBrand != null) {
				// 	parameters.brandId = this.selectedBrand.brand_SiNo;
				// 	this.selectionText = "Brand: " + this.selectedBrand.brand_name;
				// }


				axios.post(url, parameters).then(res => {
					if (this.searchType == 'current') {
						this.stock = res.data.stock.filter((pro) => pro.current_quantity != 0);
					} else if (this.searchType == 'size') {
						this.stock = res.data;
					} else {
						this.stock = res.data.stock;
					}
					this.totalStockValue = res.data.totalValue;
				})
			},
			onChangeSearchType() {
				if (this.selectedSearchType.value == 'category' && this.categories.length == 0) {
					this.getCategories();
				} else if (this.selectedSearchType.value == 'brand' && this.brands.length == 0) {
					this.getBrands();
				} else if (this.selectedSearchType.value == 'product' || this.selectedSearchType.value == 'size' && this.products.length == 0) {
					this.getProducts();
					// this.getSize();
				}
			},
			getCategories() {
				axios.get('/get_categories').then(res => {
					this.categories = res.data;
				})
			},
			getProducts() {
				axios.post('/get_products', {
					isService: 'false'
				}).then(res => {
					this.products = res.data;
				})
			},
			getBrands() {
				axios.get('/get_brands').then(res => {
					this.brands = res.data;
				})
			},
			async print() {
				let reportContent = `
					<div class="container-fluid">
						<h4 style="text-align:center">${this.selectedSearchType.text} Report</h4 style="text-align:center">
						<h6 style="text-align:center">${this.selectionText}</h6>
					</div>
					<div class="container-fluid">
						<div class="row">
							<div class="col-xs-12">
								${document.querySelector('#stockContent').innerHTML}
							</div>
						</div>
					</div>
				`;

				var reportWindow = window.open('', 'PRINT', `height=${screen.height}, width=${screen.width}, left=0, top=0`);
				reportWindow.document.write(`
					<?php $this->load->view('Administrator/reports/reportHeader.php'); ?>
				`);

				reportWindow.document.body.innerHTML += reportContent;

				reportWindow.focus();
				await new Promise(resolve => setTimeout(resolve, 1000));
				reportWindow.print();
				reportWindow.close();
			}
		}
	})
</script>