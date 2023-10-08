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

	#branchDropdown .vs__actions button {
		display: none;
	}

	#branchDropdown .vs__actions .open-indicator {
		height: 15px;
		margin-top: 7px;
	}

	label.control-label.col-sm-3,
	label.control-label.col-sm-4 {
		font-size: 13px;
	}
</style>

<div id="sales" class="row">
	<div class="col-sm-12 col-sm-12 col-lg-12" style="border-bottom:1px #ccc solid;margin-bottom:5px;">
		<div class="row">
			<div class="form-group">
				<label class="col-sm-1 control-label no-padding-right"> বিল নং </label>
				<div class="col-sm-2">
					<input type="text" id="invoiceNo" class="form-control" v-model="sales.invoiceNo" readonly />
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-1 control-label no-padding-right"> বিক্রয় বাই </label>
				<div class="col-sm-3">
					<v-select v-bind:options="employees" v-model="selectedEmployee" label="Employee_Name" placeholder="Select Employee"></v-select>
				</div>
			</div>

			<!-- <div class="form-group">
				<label class="col-sm-1 control-label no-padding-right"> বিক্রয় ব্রাঞ্চ </label>
				<div class="col-sm-2">
					<v-select id="branchDropdown" v-bind:options="branches" label="Brunch_name" v-model="selectedBranch" disabled></v-select>
				</div>
			</div> -->

			<div class="form-group">
				<label class="col-sm-1 control-label no-padding-right"> বিক্রয় তারিখ </label>
				<div class="col-sm-4">
					<input class="form-control" id="salesDate" type="date" v-model="sales.salesDate" v-bind:disabled="userType == 'u' ? true : false" />
				</div>
			</div>
		</div>
	</div>


	<div class="col-sm-12 col-sm-9 col-lg-9">
		<div class="widget-box">
			<div class="widget-header">
				<h4 class="widget-title">বিক্রয় তথ্য</h4>
				<div class="widget-toolbar">
					<a href="#" data-action="collapse">
						<i class="ace-icon fa fa-chevron-up"></i>
					</a>

					<a href="#" data-action="close">
						<i class="ace-icon fa fa-times"></i>
					</a>
				</div>
			</div>

			<div class="widget-body">
				<div class="widget-main">

					<div class="row">
						<div class="col-sm-5">
							<div class="form-group clearfix" style="margin-bottom: 8px;">
								<label class="col-sm-4 control-label no-padding-right"> ক্রেতার ধরন </label>
								<div class="col-sm-8">
									<input type="radio" name="salesType" value="retail" v-model="sales.salesType" v-on:change="onSalesTypeChange"> খুচরা &nbsp;
									<input type="radio" name="salesType" value="wholesale" v-model="sales.salesType" v-on:change="onSalesTypeChange"> পাইকারি
								</div>
							</div>
							<div class="form-group clearfix">
								<label class="col-sm-4 control-label no-padding-right"> ক্রেতা </label>
								<div class="col-sm-7">
									<v-select v-bind:options="customers" label="display_name" v-model="selectedCustomer" v-on:input="customerOnChange"></v-select>
								</div>
								<div class="col-sm-1" style="padding: 0;">
									<a href="<?= base_url('customer') ?>" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank" title="Add New Customer"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
								</div>
							</div>

							<div class="form-group clearfix" style="display:none;" v-bind:style="{display: selectedCustomer.Customer_Type == 'G' ? '' : 'none'}">
								<label class="col-sm-4 control-label no-padding-right"> নাম </label>
								<div class="col-sm-8">
									<input type="text" id="customerName" placeholder="Customer Name" class="form-control" v-model="selectedCustomer.Customer_Name" v-bind:disabled="selectedCustomer.Customer_Type == 'G' ? false : true" />
								</div>
							</div>

							<div class="form-group clearfix">
								<label class="col-sm-4 control-label no-padding-right">মোবাইল নং </label>
								<div class="col-sm-8">
									<input type="text" id="mobileNo" placeholder="Mobile No" class="form-control" v-model="selectedCustomer.Customer_Mobile" v-bind:disabled="selectedCustomer.Customer_Type == 'G' ? false : true" />
								</div>
							</div>

							<div class="form-group clearfix">
								<label class="col-sm-4 control-label no-padding-right"> ঠিকানা </label>
								<div class="col-sm-8">
									<textarea id="address" placeholder="Address" class="form-control" v-model="selectedCustomer.Customer_Address" v-bind:disabled="selectedCustomer.Customer_Type == 'G' ? false : true"></textarea>
								</div>
							</div>
							<div class="form-group clearfix" style=" margin-top:10px;display:none;" :style="{display: selectedCustomer.Customer_Type == 'retail' ? '' : 'none'}">
								<label class="col-sm-4 control-label no-padding-right"> </label>
								<div class="col-sm-8 text-center">
									<label> কাস্টমার পয়েন্ট</label><br>
									<label for="" style="font-size: 20px;font-weight: 600;"> {{ selectedCustomer.Customer_Point }}</label>
								</div>
							</div>
						</div>

						<div class="col-sm-5">
							<form v-on:submit.prevent="addToCart">

								<div class="form-group clearfix">
									<label class="control-label col-sm-3 no-padding-right">বিক্রয় ধরন</label>
									<div class="col-sm-8">
										<input type="radio" id="serial" v-model="isSerial" value="true">
										<label for="serial" style="font-size: 13px;">বারকোড</label>
										<input style="margin-left: 15px;" id="non-serial" type="radio" v-model="isSerial" value="false">
										<label for="non-serial" style="font-size: 13px;">নন বারকোড</label>
									</div>
								</div>
								<div class="form-group" style="display: none;" :style="{display: isSerial == 'false' ? '' : 'none'}">
									<label class="col-sm-3 control-label no-padding-right"> পণ্যের নাম </label>
									<div class="col-sm-8">
										<v-select v-bind:options="products" v-model="selectedProduct" label="display_text" v-on:input="productOnChange" ref="product" id="product"></v-select>
									</div>
									<div class="col-sm-1" style="padding: 0;">
										<a href="<?= base_url('product') ?>" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank" title="Add New Product"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
									</div>
								</div>

								<div class="form-group" style="display: none;" :style="{display: isSerial == 'true' ? '' : 'none'}">
									<label class="col-sm-3 control-label no-padding-right"> বারকোড </label>

									<div class="col-sm-9">
										<input type="text" ref="barcode" id="barcode" class="form-control" v-model="serial_input" placeholder="Barcode no">
										<!-- <v-select v-bind:options="serials" v-model="serial" label="ps_serial_number"></v-select> -->
									</div>
								</div>



								<!-- <div class="form-group">
									<label class="col-sm-3 control-label no-padding-right"> পণ্যের নাম </label>
									<div class="col-sm-8">
										<v-select v-bind:options="products" v-model="selectedProduct" label="display_text" v-on:input="productOnChange"></v-select>
									</div>
									<div class="col-sm-1" style="padding: 0;">
										<a href="<?= base_url('product') ?>" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank" title="Add New Product"><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
									</div>
								</div> -->

								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right"> সাইজ </label>
									<div class="col-sm-9">
										<v-select v-bind:options="pSizes" v-model="selectedSize" ref="pSize" id="pSize" label="display_size" v-on:input="sizeOnChange"></v-select>
									</div>
								</div>
								<div class="form-group" style="display: none;">
									<label class="col-sm-3 control-label no-padding-right"> Brand </label>
									<div class="col-sm-9">
										<input type="text" id="brand" placeholder="Group" class="form-control" />
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right"> MRP টাকা </label>
									<div class="col-sm-9">
										<input type="number" id="salesRate" placeholder="Rate" step="0.01" class="form-control" v-model="selectedProduct.Product_SellingPrice" v-on:input="productTotal" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right"> পরিমাণ </label>
									<div class="col-sm-9">
										<input type="number" step="0.01" id="quantity" placeholder="Qty" class="form-control" ref="quantity" v-model="selectedProduct.quantity" v-on:input="productTotal" autocomplete="off" required />
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right"> ডিসকাউন্ট</label>
									<div class="col-sm-4">
										<input type="number" id="p_d_percent" placeholder="%" ref="p_d_percent" step="0.01" min="0.00" class="form-control" v-model="discount_percent" readonly />
									</div>
									<label class="col-sm-1 control-label no-padding"> টাকা</label>
									<div class="col-sm-4">
										<input type="number" id="p_d_percent_taka" placeholder="Taka" ref="p_d_percent_taka" step="0.01" min="0.00" class="form-control" v-model="selectedProduct.Product_SaleDiscount" readonly />
									</div>
								</div>

								<!-- <div class="form-group" style="display:none;">
									<label class="col-sm-3 control-label no-padding-right"> Discount</label>
									<div class="col-sm-9">
										<span>(%)</span>
										<input type="text" id="productDiscount" placeholder="Discount" class="form-control" style="display: inline-block; width: 90%" />
									</div>
								</div> -->
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right">সর্বমোট </label>
									<div class="col-sm-9">
										<input type="text" id="productTotal" placeholder="Amount" class="form-control" v-model="selectedProduct.total" readonly />
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right"> </label>
									<div class="col-sm-9">
										<button type="submit" class="btn btn-default pull-right">Add to Cart</button>
									</div>
								</div>
							</form>

						</div>
						<div class="col-sm-2">
							<div style="display:none;" v-bind:style="{display:sales.isService == 'true' ? 'none' : ''}">
								<div class="text-center" style="display:none;" v-bind:style="{color: productStock > 0 ? 'green' : 'red', display: selectedProduct.Product_SlNo == '' ? 'none' : ''}">{{ productStockText }}</div class="text-center">

								<input type="text" id="productStock" v-model="productStock" readonly style="border:none;font-size:20px;width:100%;text-align:center;color:green"><br>
								<input type="text" id="stockUnit" v-model="selectedProduct.Unit_Name" readonly style="border:none;font-size:12px;width:100%;text-align: center;"><br><br>
							</div>
							<input type="password" ref="productPurchaseRate" v-model="selectedProduct.Product_Purchase_Rate" v-on:mousedown="toggleProductPurchaseRate" v-on:mouseup="toggleProductPurchaseRate" readonly title="Purchase rate (click & hold)" style="font-size:12px;width:100%;text-align: center;">


							<div style="margin-top:15px;">
								<input type="checkbox" id="sms" name="sendSms" value="true" v-model="sales.sendSms">
								<label for="sms">SMS পাঠান</label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


		<div class="col-sm-12 col-sm-12 col-lg-12" style="padding-left: 0px;padding-right: 0px;">
			<div class="table-responsive">
				<table class="table table-bordered" style="color:#000;margin-bottom: 5px;">
					<thead>
						<tr class="">
							<th style="width:10%;color:#000;">Sl</th>
							<th style="width:15%;color:#000;">কোড</th>
							<th style="width:20%;color:#000;">আর্টিকেল নাম</th>
							<th style="width:20%;color:#000;">সাইজ</th>
							<th style="width:15%;color:#000;">শ্রেণী</th>
							<th style="width:7%;color:#000;">পরিমাণ</th>
							<th style="width:8%;color:#000;">দর</th>
							<th style="width:8%;color:#000;">ডিসকাউন্ট </th>
							<th style="width:15%;color:#000;">সর্বমোট টাকা</th>
							<th style="width:10%;color:#000;">Action</th>
						</tr>
					</thead>
					<tbody style="display:none;" v-bind:style="{display: cart.length > 0 ? '' : 'none'}">
						<tr v-for="(product, sl) in cart">
							<td>{{ sl + 1 }}</td>
							<td>{{ product.productCode }}</td>
							<td>{{ product.name }}</td>
							<td>{{ product.size }}</td>
							<td>{{ product.categoryName }}</td>
							<td>{{ product.quantity }}</td>
							<td>{{ product.salesRate }}</td>
							<td>{{ product.discountTotal }}</td>
							<td>{{ product.total }}</td>
							<td><a href="" v-on:click.prevent="removeFromCart(sl)"><i class="fa fa-trash"></i></a></td>
						</tr>

						<tr>
							<th colspan="5" style="text-align: right;">Total</th>
							<th>{{ cart.reduce((p,c)=>{return +p + +c.quantity},0) }}</th>
							<th></th>
							<th>{{ cart.reduce((p,c)=>{return +p + +c.discountTotal},0) }}</th>
							<th>{{ cart.reduce((p,c)=>{return +p + +c.total},0) }}</th>
							<th></th>
						</tr>
						<tr>
							<td colspan="10"></td>
						</tr>

						<tr style="font-weight: bold;">
							<td colspan="5">Note</td>
							<td colspan="4">Total</td>
						</tr>

						<tr>
							<td colspan="5"><textarea style="width: 100%;font-size:13px;" placeholder="Note" v-model="sales.note"></textarea></td>
							<td colspan="4" style="padding-top: 15px;font-size:18px;">{{ sales.total }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>


	<div class="col-sm-12 col-sm-3 col-lg-3">
		<div class="widget-box">
			<div class="widget-header">
				<h4 class="widget-title">পরিমাণ বিবরণ</h4>
				<div class="widget-toolbar">
					<a href="#" data-action="collapse">
						<i class="ace-icon fa fa-chevron-up"></i>
					</a>

					<a href="#" data-action="close">
						<i class="ace-icon fa fa-times"></i>
					</a>
				</div>
			</div>

			<div class="widget-body">
				<div class="widget-main">
					<div class="row">
						<div class="col-sm-12">
							<div class="table-responsive">
								<table style="color:#000;margin-bottom: 0px;border-collapse: collapse;">
									<tr>
										<td>
											<div class="form-group">
												<label class="col-sm-5 control-label no-padding">মোট টাকা</label>
												<div class="col-sm-7 no-padding-right">
													<input type="number" id="subTotal" class="form-control" v-model="sales.subTotal" readonly />
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-sm-5 control-label no-padding"> ভ্যাট টাকা</label>
												<div class="col-sm-7 no-padding-right">
													<input type="number" id="vat" readonly="" class="form-control" v-model="sales.vat" />
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-sm-5 control-label no-padding">ডিসকাউন্ট %</label>

												<div class="col-sm-7 no-padding-right">
													<input type="number" id="discountPercent" class="form-control" v-model="discountPercent" v-on:input="calculateTotal" />
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group">
												<label class="col-sm-5 control-label no-padding">ডিসকাউন্ট টাকা</label>

												<div class="col-sm-7 no-padding-right">
													<input type="number" id="discount" class="form-control" v-model="sales.discount" v-on:input="calculateTotal" />
												</div>

											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-sm-5 control-label no-padding">পরিবহন খরচ</label>
												<div class="col-sm-7 no-padding-right">
													<input type="number" class="form-control" v-model="sales.transportCost" v-on:input="calculateTotal" />
												</div>
											</div>
										</td>
									</tr>

									<tr style="display:none;">
										<td>
											<div class="form-group">
												<label class="col-sm-5 control-label no-padding">Round Of</label>
												<div class="col-sm-7 no-padding-right">
													<input type="number" id="roundOf" class="form-control" />
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-sm-5 control-label no-padding" style="font-size: 18px;font-weight: bold;">সর্বমোট</label>
												<div class="col-sm-7 no-padding-right">
													<input style="font-size: 18px;font-weight: bold;" type="number" id="total" class="form-control" v-model="sales.total" readonly />
												</div>
											</div>
										</td>
									</tr>

									<tr style="display: none;" :style="{display: selectedCustomer.Customer_Type == 'retail' && selectedCustomer.Customer_Point > 0 ? '' : 'none'}">
										<td>
											<div class="form-group">
												<label class="col-sm-5 control-label no-padding" style="font-size: 18px;font-weight: bold;">পয়েন্ট</label>
												<div class="col-sm-7 no-padding-right">
													<input style="font-size: 18px;font-weight: bold;" type="number" id="point" class="form-control" v-model="sales.point" v-on:input="calculateTotal" />
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-sm-5 control-label no-padding" style="font-size: 18px;font-weight: bold;">নগদ প্রদান</label>
												<div class="col-sm-7 no-padding-right">
													<input style="font-size: 18px;font-weight: bold;" type="number" id="paid" class="form-control" v-model="sales.paid" v-on:input="calculateTotal" />
												</div>
											</div>
										</td>
									</tr>

									<tr>
										<td>
											<div class="form-group">
												<label class="col-sm-5 control-label no-padding" style="font-size: 18px;font-weight: bold;">ফেরত</label>
												<div class="col-sm-7 no-padding-right">
													<input style="font-size: 18px;font-weight: bold;color: red !important;" type="number" class="form-control" v-model="sales.return" v-on:input="calculateTotal" v-bind:disabled="true" />
												</div>
											</div>
										</td>
									</tr>

									<!-- <tr>
										<td>
											<div class="form-group">
												<label class="col-sm-12 control-label">Due</label>
												<div class="col-sm-6">
													<input type="number" id="due" class="form-control" v-model="sales.due" readonly />
												</div>
												<div class="col-sm-6">
													<input type="number" id="previousDue" class="form-control" v-model="sales.previousDue" readonly style="color:red;" />
												</div>
											</div>
										</td>
									</tr> -->

									<tr>
										<td>
											<div class="form-group">
												<div class="col-sm-5"></div>
												<div class="col-sm-7 no-padding-right" style="padding-top: 10px;">
													<input type="button" class="btn btn-primary btn-sm" value="বিক্রয়" v-on:click="saveSales" v-bind:disabled="saleOnProgress ? true : false" style="color: white!important;margin-top: 0px;width:100%;padding:10px;font-weight:bold;border:none">
												</div>
												<!-- <div class="col-sm-6">
													<a class="btn btn-info btn-sm" v-bind:href="`/sales/${sales.isService == 'true' ? 'service' : 'product'}`" style="color: black!important;margin-top: 0px;width:100%;padding:5px;font-weight:bold;">New Sale</a>
												</div> -->
											</div>
										</td>
									</tr>

								</table>
							</div>
						</div>
					</div>
				</div>
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
		el: '#sales',
		data() {
			return {
				sales: {
					salesId: parseInt('<?php echo $salesId; ?>'),
					invoiceNo: '<?php echo $invoice; ?>',
					salesBy: '<?php echo $this->session->userdata("FullName"); ?>',
					salesType: 'retail',
					salesFrom: '',
					salesDate: '',
					customerId: '',
					employeeId: null,
					subTotal: 0.00,
					discount: 0.00,
					vat: 0.00,
					transportCost: 0.00,
					total: 0.00,
					point: 0.00,
					paid: 0.00,
					pointTaka: 0.00,
					return: 0.00,
					previousDue: 0.00,
					due: 0.00,
					isService: '<?php echo $isService; ?>',
					note: '',
					sendSms: false
				},
				serial_input: '',
				isSerial: 'false',
				discount_percent: 0,
				vatPercent: 0,
				discountPercent: 0,
				cart: [],
				employees: [],
				selectedEmployee: null,
				branches: [],
				selectedBranch: {
					brunch_id: "<?php echo $this->session->userdata('BRANCHid'); ?>",
					Brunch_name: "<?php echo $this->session->userdata('Brunch_name'); ?>"
				},
				pSizes: [],
				selectedSize: {
					Product_SlNo: '',
					display_size: 'Select'
				},
				customers: [],
				selectedCustomer: {
					Customer_SlNo: '',
					Customer_Code: '',
					Customer_Name: '',
					display_name: 'Select Customer',
					Customer_Mobile: '',
					Customer_Address: '',
					Customer_Type: ''
				},
				// sizes: [],
				// selectedSize: {
				// 	size_sl: '',
				// 	size_name: 'Select'
				// },
				oldCustomerId: null,
				oldPreviousDue: 0,
				products: [],
				selectedProduct: {
					Product_SlNo: '',
					display_text: 'Select Product',
					Product_Name: '',
					Unit_Name: '',
					quantity: 0,
					Product_Purchase_Rate: '',
					Product_SellingPrice: 0.00,
					vat: 0.00,
					total: 0.00
				},
				productPurchaseRate: '',
				productStockText: '',
				productStock: '',
				saleOnProgress: false,
				sales_due_on_update: 0,
				userType: '<?php echo $this->session->userdata("accountType"); ?>'
			}
		},
		async created() {
			this.sales.salesDate = moment().format('YYYY-MM-DD');
			await this.getEmployees();
			await this.getBranches();
			await this.getCustomers();
			this.getProducts();

			if (this.sales.salesId != 0) {
				await this.getSales();
			}
		},
		watch: {
			isSerial(value) {
				if (value == 'true') {
					this.selectedProduct = {
						Product_SlNo: '',
						display_text: 'Select Product',
						Product_Name: '',
						Unit_Name: '',
						quantity: 0,
						Product_Purchase_Rate: '',
						Product_SellingPrice: 0.00,
						vat: 0.00,
						total: 0.00
					}
				}
			},
			serial_input(sl) {
				if (sl.length == 6) {
					this.selectedProduct = this.products.find(p => p.Product_Code == sl);
					this.serial_input = this.selectedProduct.display_text;
					this.getSize();
				}
			},

		},
		methods: {
			getSize() {
				if (this.selectedProduct.Product_SlNo == '') return;
				axios.post('/get_product_sizes', {
					productId: this.selectedProduct.Product_SlNo
				}).then(res => {
					this.pSizes = res.data.map(s => {
						s.display_size = 'Size: ' +
							s.product_size + ' = Stock: ' + s.stock;
						return s;
					});

				})
				document.querySelector('#pSize input[type="search"]').focus();
				// this.$ref.pSize.focus();
				// $('#pSize').focus();
			},
			getEmployees() {
				axios.get('/get_employees').then(res => {
					this.employees = res.data;
				})
			},
			getBranches() {
				axios.get('/get_branches').then(res => {
					this.branches = res.data;
				})
			},
			async getCustomers() {
				await axios.post('/get_customers', {
					customerType: this.sales.salesType
				}).then(res => {
					this.customers = res.data;
					this.customers.unshift({
						Customer_SlNo: 'C01',
						Customer_Code: '',
						Customer_Name: 'Cash Customer',
						display_name: 'Cash Customer',
						Customer_Mobile: '01',
						Customer_Address: 'NA',
						Customer_Type: 'G'
					})
					this.selectedCustomer = {
						Customer_SlNo: 'C01',
						Customer_Code: '',
						Customer_Name: 'Cash Customer',
						display_name: 'Cash Customer',
						Customer_Mobile: '01',
						Customer_Address: 'NA',
						Customer_Type: 'G'
					}
				})
			},
			sizeOnChange() {
				if (this.selectedSize.Product_SlNo == '') return;
				this.productStock = this.selectedSize.stock;
				this.$refs.quantity.focus();
			},
			getProducts() {
				axios.post('/get_products', {
					isService: this.sales.isService
				}).then(res => {
					if (this.sales.salesType == 'wholesale') {
						this.products = res.data.filter((product) => product.Product_WholesaleRate > 0);
						this.products.map((product) => {
							return product.Product_SellingPrice = product.Product_WholesaleRate;
						})
					} else {
						this.products = res.data;
					}
				})
			},
			productTotal() {
				// this.selectedProduct.total = (parseFloat(this.selectedProduct.quantity) * parseFloat(this.selectedProduct.Product_SellingPrice)).toFixed(2);

				// if (event.target.id == 'p_d_percent') {
				// 	this.selectedProduct.discount = ((parseFloat(this.selectedProduct.Product_SellingPrice) * parseFloat(this.discount_percent)) / 100).toFixed(2);
				// } else {
				// 	this.discount_percent = ((parseFloat(this.selectedProduct.discount) * 100) / parseFloat(this.selectedProduct.Product_SellingPrice)).toFixed(2)
				// }

				// if (!this.selectedProduct.hasOwnProperty('discount')) {
				// 	this.discount_percent = 0;
				// 	this.selectedProduct.discount = 0
				// }

				// this.selectedProduct.total = ((parseFloat(this.selectedProduct.Product_SellingPrice) * parseFloat(this.selectedProduct.quantity)) - (parseFloat(this.selectedProduct.discount) * parseFloat(this.selectedProduct.quantity))).toFixed(2)
				if (this.selectedProduct.Product_SlNo == '') return
				this.selectedProduct.total = (parseFloat(this.selectedProduct.Product_SellingPrice - this.selectedProduct.Product_SaleDiscount) * parseFloat(this.selectedProduct.quantity)).toFixed(2)

			},
			onSalesTypeChange() {
				this.selectedCustomer = {
					Customer_SlNo: '',
					Customer_Code: '',
					Customer_Name: 'Cash Customer',
					display_name: 'Cash Customer',
					Customer_Mobile: '01',
					Customer_Address: 'NA',
					Customer_Type: ''
				}
				this.getCustomers();

				this.clearProduct();
				this.getProducts();
			},
			async customerOnChange() {
				if (this.selectedCustomer.Customer_SlNo == '') {
					return;
				}

				if (event.type == 'readystatechange') {
					return;
				}

				if (this.sales.salesId != 0 && this.oldCustomerId != parseInt(this.selectedCustomer.Customer_SlNo)) {
					let changeConfirm = confirm('Changing customer will set previous due to current due amount. Do you really want to change customer?');
					if (changeConfirm == false) {
						return;
					}
				} else if (this.sales.salesId != 0 && this.oldCustomerId == parseInt(this.selectedCustomer.Customer_SlNo)) {
					this.sales.previousDue = this.oldPreviousDue;
					return;
				}

				await this.getCustomerDue();

				this.calculateTotal();
			},
			async getCustomerDue() {
				await axios.post('/get_customer_due', {
					customerId: this.selectedCustomer.Customer_SlNo
				}).then(res => {
					if (res.data.length > 0) {
						this.sales.previousDue = res.data[0].dueAmount;
					} else {
						this.sales.previousDue = 0;
					}
				})
			},
			async productOnChange() {
				if ((this.selectedProduct.Product_SlNo != '' || this.selectedProduct.Product_SlNo != 0) && this.sales.isService == 'false') {
					this.productStock = await axios.post('/get_product_stock', {
						productId: this.selectedProduct.Product_SlNo
					}).then(res => {
						return res.data;
					})

					this.productStockText = this.productStock > 0 ? "Available Stock" : "Stock Unavailable";
				}

				this.discount_percent = parseFloat(this.selectedProduct.Product_SaleDiscount * 100 / this.selectedProduct.Product_SellingPrice).toFixed(2);

				this.selectedProduct.quantity = 1;
				this.productTotal();
				this.getSize();

				// this.$refs.quantity.focus();
			},
			toggleProductPurchaseRate() {
				//this.productPurchaseRate = this.productPurchaseRate == '' ? this.selectedProduct.Product_Purchase_Rate : '';
				this.$refs.productPurchaseRate.type = this.$refs.productPurchaseRate.type == 'text' ? 'password' : 'text';
			},
			addToCart() {
				let product = {
					productId: this.selectedProduct.Product_SlNo,
					productCode: this.selectedProduct.Product_Code,
					categoryName: this.selectedProduct.ProductCategory_Name,
					name: this.selectedProduct.Product_Article,
					size: this.selectedSize.product_size,
					salesRate: this.selectedProduct.Product_SellingPrice,
					vat: this.selectedProduct.vat,
					quantity: this.selectedProduct.quantity,
					discount: this.selectedProduct.Product_SaleDiscount,
					discountTotal: parseFloat(this.selectedProduct.Product_SaleDiscount * this.selectedProduct.quantity).toFixed(2),
					Commission_amount: this.selectedProduct.Product_SaleCommission,
					total: this.selectedProduct.total,
					purchaseRate: this.selectedProduct.Product_Purchase_Rate,
					productPoint: this.selectedProduct.Product_Point
				}

				if (product.productId == '') {
					alert('Select Product');
					return;
				}

				if (product.quantity == 0 || product.quantity == '') {
					alert('Enter quantity');
					return;
				}

				if (product.salesRate == 0 || product.salesRate == '') {
					alert('Enter sales rate');
					return;
				}

				if (+product.quantity > +this.selectedSize.stock && this.sales.isService == 'false') {
					alert('Stock unavailable');
					return;
				}

				let cartInd = this.cart.findIndex(p => p.productId == product.productId && p.size == product.size);
				if (cartInd > -1) {
					this.cart.splice(cartInd, 1);
				}

				this.cart.unshift(product);
				this.calculateTotal();
				this.clearProduct();

				// document.querySelector('#product input[type="search"]').focus();
			},
			removeFromCart(ind) {
				this.cart.splice(ind, 1);
				this.calculateTotal();
			},
			clearProduct() {
				this.selectedProduct = {
					Product_SlNo: '',
					display_text: 'Select Product',
					Product_Name: '',
					Unit_Name: '',
					quantity: 0,
					Product_Purchase_Rate: '',
					Product_SellingPrice: 0.00,
					vat: 0.00,
					total: 0.00
				}
				this.productStock = '';
				this.productStockText = '';
				this.serial_input = '';
				this.selectedSize = {
					Product_SlNo: '',
					display_size: 'Select'
				}

				// document.querySelector('#barcode input[type="text"]').focus();
				this.$refs.barcode.focus();
			},
			calculateTotal() {
				if (this.selectedCustomer.Customer_Point < this.sales.point) {
					alert('Point exceed');
					this.sales.point = this.selectedCustomer.Customer_Point;
					return;
				}
				this.sales.subTotal = this.cart.reduce((prev, curr) => {
					return prev + parseFloat(curr.total)
				}, 0).toFixed(2);
				this.sales.vat = this.cart.reduce((prev, curr) => {
					return +prev + +(curr.total * (curr.vat / 100))
				}, 0);
				if (event.target.id == 'discountPercent') {
					this.sales.discount = ((parseFloat(this.sales.subTotal) * parseFloat(this.discountPercent)) / 100).toFixed(2);
				} else {
					this.discountPercent = (parseFloat(this.sales.discount) / parseFloat(this.sales.subTotal) * 100).toFixed(2);
				}
				this.sales.total = ((parseFloat(this.sales.subTotal) + parseFloat(this.sales.vat) + parseFloat(this.sales.transportCost)) - parseFloat(this.sales.discount)).toFixed(2);

				if (this.selectedCustomer.Customer_Type == 'G') {
					if (event.target.id != 'paid') {
						this.sales.paid = this.sales.total;
						this.sales.return = 0;
						this.sales.due = 0;
					} else {
						if (+this.sales.paid > +this.sales.total) {
							this.sales.return = parseFloat(+this.sales.paid - +this.sales.total).toFixed(2);
							this.sales.due = 0;
						} else {
							this.sales.return = parseFloat(this.sales.total - +this.sales.paid).toFixed(2);
							this.sales.due = parseFloat(this.sales.total - +this.sales.paid).toFixed(2);
						}
						// this.sales.return = parseFloat(this.sales.total - this.sales.paid).toFixed(2);
					}
					// if (+this.sales.paid > +this.sales.total) {
					// 	this.sales.return = parseFloat(this.sales.paid - this.sales.total).toFixed(2);
					// 	this.sales.due = 0;
					// } else {
					// this.sales.return = 0;
					// 	this.sales.due = (parseFloat(this.sales.total) - parseFloat(+this.sales.paid + +this.sales.return)).toFixed(2);
					// }

				} else {
					if (event.target.id != 'paid') {
						this.sales.paid = this.sales.total - this.sales.point;
						this.sales.return = 0;
						this.sales.due = this.sales.total;
					} else {
						if (+this.sales.paid > +this.sales.total) {
							this.sales.return = parseFloat(+this.sales.paid - +this.sales.total).toFixed(2);
							this.sales.due = 0;
						} else {
							this.sales.due = parseFloat(+this.sales.total - +this.sales.paid).toFixed(2);
						}
					}
					// if (+this.sales.paid > +this.sales.total) {
					// this.sales.return = this.sales.total;
					// this.sales.return = parseFloat(this.sales.paid - this.sales.total).toFixed(2);
					// 	this.sales.due = 0;
					// } else {
					// 	this.sales.return = 0;
					// 	this.sales.due = (parseFloat(this.sales.total) - parseFloat(+this.sales.paid + +this.sales.return)).toFixed(2);
					// }

				}
			},
			async saveSales() {
				if (this.selectedCustomer.Customer_SlNo == '') {
					alert('Select Customer');
					return;
				}
				if (this.selectedCustomer.Customer_Type == 'G' && this.selectedCustomer.Customer_Name == '') {
					alert('Customer Name is empty');
					return;
				}
				// if (this.selectedCustomer.Customer_Type == 'G' && this.selectedCustomer.Customer_Mobile == '') {
				// 	alert('Customer Mobile is empty');
				// 	return;
				// }
				// if (this.selectedCustomer.Customer_Type == 'G' && this.selectedCustomer.Customer_Address == '') {
				// 	alert('Customer Address is empty');
				// 	return;
				// }
				if (this.cart.length == 0) {
					alert('Cart is empty');
					return;
				}
				if (this.selectedCustomer.Customer_Type == 'G') {
					if (this.sales.due > 0) {
						alert('General Customer Due Founded!');
						return;
					}
				}

				// this.saleOnProgress = true;

				await this.getCustomerDue();

				let url = "/add_sales";
				if (this.sales.salesId != 0) {
					url = "/update_sales";
					this.sales.previousDue = parseFloat((this.sales.previousDue - this.sales_due_on_update)).toFixed(2);
				}

				// if (parseFloat(this.selectedCustomer.Customer_Credit_Limit) < (parseFloat(this.sales.due) + parseFloat(this.sales.previousDue))) {
				// 	alert(`Customer credit limit (${this.selectedCustomer.Customer_Credit_Limit}) exceeded`);
				// 	this.saleOnProgress = false;
				// 	return;
				// }

				if (this.selectedEmployee != null && this.selectedEmployee.Employee_SlNo != null) {
					this.sales.employeeId = this.selectedEmployee.Employee_SlNo;
				} else {
					this.sales.employeeId = null;
				}

				this.sales.customerId = this.selectedCustomer.Customer_SlNo;
				this.sales.salesFrom = this.selectedBranch.brunch_id;

				let data = {
					sales: this.sales,
					cart: this.cart
				}

				if (this.selectedCustomer.Customer_Type == 'G') {
					data.customer = this.selectedCustomer;
				}

				// console.log(data);
				// return

				axios.post(url, data).then(async res => {
					let r = res.data;
					if (r.success) {
						// window.location = "/sales/product";
						// let conf = confirm('Sale success, Do you want to view invoice?');
						// if (conf) {
						// window.open('/sale_invoice_print/' + r.salesId, '_blank');

						window.open('/sale_invoice_print_auto/' + r.salesId, '_blank');
						await new Promise(r => setTimeout(r, 1000));
						window.location = this.sales.isService == 'false' ? '/sales/product' : '/sales/service';
						// } else {
						// window.location = this.sales.isService == 'false' ? '/sales/product' : '/sales/service';
						// }
					} else {
						alert(r.message);
						this.saleOnProgress = false;
					}
				})
			},
			async getSales() {
				await axios.post('/get_sales', {
					salesId: this.sales.salesId
				}).then(res => {
					let r = res.data;
					let sales = r.sales[0];
					this.sales.salesBy = sales.AddBy;
					this.sales.salesFrom = sales.SaleMaster_branchid;
					this.sales.salesDate = sales.SaleMaster_SaleDate;
					this.sales.salesType = sales.SaleMaster_SaleType;
					this.sales.customerId = sales.SalseCustomer_IDNo;
					this.sales.employeeId = sales.Employee_SlNo;
					this.sales.subTotal = sales.SaleMaster_SubTotalAmount;
					this.sales.discount = sales.SaleMaster_TotalDiscountAmount;
					this.sales.vat = sales.SaleMaster_TaxAmount;
					this.sales.transportCost = sales.SaleMaster_Freight;
					this.sales.total = sales.SaleMaster_TotalSaleAmount;
					this.sales.paid = sales.SaleMaster_PaidAmount;
					this.sales.previousDue = sales.SaleMaster_Previous_Due;
					this.sales.due = sales.SaleMaster_DueAmount;
					this.sales.note = sales.SaleMaster_Description;
					this.sales.point = sales.point;

					this.oldCustomerId = sales.SalseCustomer_IDNo;
					this.oldPreviousDue = sales.SaleMaster_Previous_Due;
					this.sales_due_on_update = sales.SaleMaster_DueAmount;

					this.vatPercent = parseFloat(this.sales.vat) * 100 / parseFloat(this.sales.subTotal);
					this.discountPercent = parseFloat(this.sales.discount) * 100 / parseFloat(this.sales.subTotal);

					this.selectedEmployee = {
						Employee_SlNo: sales.employee_id,
						Employee_Name: sales.Employee_Name
					}

					this.selectedCustomer = this.customers.find(c => c.Customer_SlNo == sales.SalseCustomer_IDNo)

					let curretnSalePoint = r.saleDetails.reduce((prev, curr) => {
						return +prev + (+curr.productPoint * +curr.SaleDetails_TotalQuantity)
					}, 0)

					this.selectedCustomer.Customer_Point = (+this.selectedCustomer.Customer_Point + +sales.point) - +curretnSalePoint;

					// this.selectedCustomer = {
					// 	Customer_SlNo: sales.SalseCustomer_IDNo,
					// 	Customer_Code: sales.Customer_Code,
					// 	Customer_Name: sales.Customer_Name,
					// 	display_name: sales.Customer_Type == 'G' ? 'General Customer' : `${sales.Customer_Code} - ${sales.Customer_Name}`,
					// 	Customer_Mobile: sales.Customer_Mobile,
					// 	Customer_Address: sales.Customer_Address,
					// 	Customer_Type: sales.Customer_Type,
					// 	Customer_Point: sales.point + ,
					// }

					r.saleDetails.forEach(product => {
						let cartProduct = {
							productCode: product.Product_Code,
							productId: product.Product_IDNo,
							categoryName: product.ProductCategory_Name,
							name: product.Product_Article,
							size: product.product_size,
							salesRate: product.SaleDetails_Rate,
							vat: product.SaleDetails_Tax,
							quantity: product.SaleDetails_TotalQuantity,
							discount: product.SaleDetails_Discount,
							discountTotal: product.Discount_amount,
							total: product.SaleDetails_TotalAmount,
							purchaseRate: product.Purchase_Rate,
							Commission_amount: product.Commission_amount,
							productPoint: product.productPoint
						}

						this.cart.push(cartProduct);
					})

					let gCustomerInd = this.customers.findIndex(c => c.Customer_Type == 'G');
					this.customers.splice(gCustomerInd, 1);
				})
			}
		}
	})
</script>