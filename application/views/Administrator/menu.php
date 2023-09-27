<style>
	.module_title {
		background-color: #00BE67 !important;
		text-align: center;
		font-size: 18px !important;
		font-weight: bold;
		font-style: italic;
		color: #fff !important;
	}

	.module_title span {
		font-size: 18px !important;
	}
</style>

<?php
// print_r($this->session->userdata()); die();
$userID =  $this->session->userdata('userId');
$CheckSuperAdmin = $this->db->where('UserType', 'm')->where('User_SlNo', $userID)->get('tbl_user')->row();

$CheckAdmin = $this->db->where('UserType', 'a')->where('User_SlNo', $userID)->get('tbl_user')->row();

$userAccessQuery = $this->db->where('user_id', $userID)->get('tbl_user_access');
$access = [];
if ($userAccessQuery->num_rows() != 0) {
	$userAccess = $userAccessQuery->row();
	$access = json_decode($userAccess->access);
}

$module = $this->session->userdata('module');
if ($module == 'dashboard' or $module == '') {
?>
	<ul class="nav nav-list">
		<li class="active">
			<!-- module/dashboard -->
			<a href="<?php echo base_url(); ?>">
				<i class="menu-icon fa fa-tachometer"></i>
				<span class="menu-text"> ড্যাসবোর্ড </span>
			</a>
			<b class="arrow"></b>
		</li>

		<li class="">
			<a href="<?php echo base_url(); ?>module/SalesModule">
				<i class="menu-icon fa fa-usd"></i>
				<span class="menu-text"> বিক্রয় মডিউল </span>
			</a>
			<b class="arrow"></b>
		</li>

		<li class="">
			<a href="<?php echo base_url(); ?>module/PurchaseModule">
				<i class="menu-icon fa fa-cart-plus"></i>
				<span class="menu-text"> ক্রয় মডিউল </span>
			</a>
			<b class="arrow"></b>
		</li>

		<li class="">
			<!--  -->
			<a href="<?php echo base_url(); ?>module/AccountsModule">
				<i class="menu-icon fa fa-clipboard"></i>
				<span class="menu-text"> একাউন্ট মডিউল </span>
			</a>
			<b class="arrow"></b>
		</li>

		<li class="">
			<!-- module/HRPayroll -->
			<a href="<?php echo base_url(); ?>module/HRPayroll">
				<i class="menu-icon fa fa-users"></i>
				<span class="menu-text"> পেরল মডিউল </span>
			</a>
			<b class="arrow"></b>
		</li>

		<li class="">
			<!-- module/ReportsModule -->
			<a href="<?php echo base_url(); ?>module/ReportsModule">
				<i class="menu-icon fa fa-calendar-check-o"></i>
				<span class="menu-text"> রিপোর্ট মডিউল </span>
			</a>
			<b class="arrow"></b>
		</li>

		<li class="">
			<a href="<?php echo base_url(); ?>module/Administration">
				<i class="menu-icon fa fa-cogs"></i>
				<span class="menu-text"> এডমিনিস্টেশন </span>
			</a>
			<b class="arrow"></b>
		</li>

		<li class="">
			<a href="<?php echo base_url(); ?>graph">
				<i class="menu-icon fa fa-bar-chart"></i>
				<span class="menu-text"> বিসনেস মনিটর </span>
			</a>
			<b class="arrow"></b>
		</li>
	</ul>
<?php } elseif ($module == 'Administration') { ?>
	<ul class="nav nav-list">
		<li class="active">
			<a href="<?php echo base_url(); ?>module/dashboard">
				<i class="menu-icon fa fa-tachometer"></i>
				<span class="menu-text"> ড্যাসবোর্ড </span>
			</a>
			<b class="arrow"></b>
		</li>
		<li>
			<a href="<?php echo base_url(); ?>module/Administration" class="module_title">
				<span>এডমিনিস্টেশন</span>
			</a>
		</li>

		<?php if (array_search("sms", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>sms">
					<i class="menu-icon fa fa-mobile"></i>
					<span class="menu-text"> এসএমএস পাঠান </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

		<?php if (
			array_search("product", $access) > -1
			|| array_search("productlist", $access) > -1
			|| array_search("product_ledger", $access) > -1
			|| isset($CheckSuperAdmin)
			|| isset($CheckAdmin)
		) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>" class="dropdown-toggle">
					<i class="menu-icon fa fa-product-hunt"></i>
					<span class="menu-text"> পণ্যর বিবরণ </span>

					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">

					<?php if (array_search("product", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>product">
								<i class="menu-icon fa fa-caret-right"></i>
								পণ্য এন্ট্রি
							</a>

							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("productlist", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>productlist" target="_blank">
								<i class="menu-icon fa fa-caret-right"></i>
								পণ্য তালিকা
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("product_ledger", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>product_ledger">
								<i class="menu-icon fa fa-caret-right"></i>
								পণ্য লেজার
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>
				</ul>
			</li>
		<?php endif; ?>
		<?php if (
			array_search("damageEntry", $access) > -1
			|| array_search("damageList", $access) > -1
			|| isset($CheckSuperAdmin) || isset($CheckAdmin)
		) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>" class="dropdown-toggle">
					<i class="menu-icon fa fa-list"></i>
					<span class="menu-text"> ডেমজ বিবরণ </span>
					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">

					<?php if (array_search("damageEntry", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>damageEntry">
								<i class="menu-icon fa fa-caret-right"></i>
								ডেমজ এন্ট্রি
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("damageList", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>damageList">
								<i class="menu-icon fa fa-caret-right"></i>
								ডেমজ তালিকা
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

				</ul>
			</li>
		<?php endif; ?>

		<!-- <?php if (
					array_search("product_transfer", $access) > -1
					|| array_search("transfer_list", $access) > -1
					|| array_search("received_list", $access) > -1
					|| isset($CheckSuperAdmin) || isset($CheckAdmin)
				) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>" class="dropdown-toggle">
					<i class="menu-icon fa fa-exchange"></i>
					<span class="menu-text"> Product Transfer </span>
					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">

					<?php if (array_search("product_transfer", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>product_transfer">
								<i class="menu-icon fa fa-caret-right"></i>
								Product Transfer
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>
					<?php if (array_search("transfer_list", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>transfer_list">
								<i class="menu-icon fa fa-caret-right"></i>
								Transfer List
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("received_list", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>received_list">
								<i class="menu-icon fa fa-caret-right"></i>
								<span class="menu-text"> Received List</span>
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

				</ul>
			</li>
		<?php endif; ?> -->

		<?php if (
			array_search("customer", $access) > -1
			|| array_search("supplier", $access) > -1
			|| array_search("brunch", $access) > -1
			|| array_search("category", $access) > -1
			|| array_search("unit", $access) > -1
			|| array_search("area", $access) > -1
			|| isset($CheckSuperAdmin) || isset($CheckAdmin)
		) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>" class="dropdown-toggle">
					<i class="menu-icon fa fa-cog"></i>
					<span class="menu-text"> সেটিংস </span>

					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">
					<?php if (array_search("customer", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>customer">
								<i class="menu-icon fa fa-caret-right"></i>
							
								গ্রাহক এন্ট্রি
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("supplier", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>supplier">
								<i class="menu-icon fa fa-caret-right"></i>
								
								সাপ্লায়ার এন্ট্রি
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<!-- <?php if (array_search("brunch", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
					<li class="">
						<a href="<?php echo base_url(); ?>brunch">
							<i class="menu-icon fa fa-caret-right"></i>
							Add Branch
						</a>
						<b class="arrow"></b>
					</li>
				<?php endif; ?> -->

					<?php if (array_search("category", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>category">
								<i class="menu-icon fa fa-caret-right"></i>
								ক্যাটাগরি এন্ট্রি

							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("unit", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>unit">
								<i class="menu-icon fa fa-caret-right"></i>
								ইউনিট এন্ট্রি
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("area", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>area">
								<i class="menu-icon fa fa-caret-right"></i>
								<span class="menu-text"> এলাকা যোগ করুন </span>
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>
				</ul>
			</li>
		<?php endif; ?>

		<?php if ($this->session->userdata('BRANCHid') == 1 && (isset($CheckSuperAdmin) || isset($CheckAdmin))) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>companyProfile">
					<i class="menu-icon fa fa-bank"></i>
					<span class="menu-text"> কোম্পানির প্রোফাইল </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

		<?php if (isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>user">
					<i class="menu-icon fa fa-user-plus"></i>
					<span class="menu-text"> ইউজার এন্ট্রি</span>
				</a>
			</li>
		<?php endif; ?>

		<?php if (isset($CheckSuperAdmin) && $this->session->userdata('BRANCHid') == 1) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>user_activity">
					<i class="menu-icon fa fa-list"></i>
					<span class="menu-text">ইউজার কার্যকলাপ</span>
				</a>
			</li>
		<?php endif; ?>

		<?php if (array_search("database_backup", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>database_backup">
					<i class="menu-icon fa fa-database"></i>
					<span class="menu-text">ডাটাবেস ব্যাক-আপ </span>
				</a>
			</li>
		<?php endif; ?>

	</ul><!-- /.nav-list -->

<?php } elseif ($module == 'SalesModule') { ?>
	<ul class="nav nav-list">

		<li class="active">
			<a href="<?php echo base_url(); ?>module/dashboard">
				<i class="menu-icon fa fa-tachometer"></i>
				<span class="menu-text"> ড্যাসবোর্ড </span>
			</a>

			<b class="arrow"></b>
		</li>
		<li>
			<a href="<?php echo base_url(); ?>module/SalesModule" class="module_title">
				<span> বিক্রয় মডিউল </span>
			</a>
		</li>

		<?php if (array_search("sales/product", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>sales/product">
					<i class="menu-icon fa fa-usd"></i>
					<span class="menu-text"> বিক্রয় এন্ট্রি করুন </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>


		<?php if (array_search("sales/service", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>sales/service">
					<i class="menu-icon fa fa-usd"></i>
					<span class="menu-text">সার্ভিস এন্ট্রি করুণ </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

		<?php if (array_search("salesReturn", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>productReturn">
					<i class="menu-icon fa fa-rotate-left"></i>
					<span class="menu-text"> বিক্রয় ফেরত </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

		<?php if (array_search("salesrecord", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>salesrecord">
					<i class="menu-icon fa fa-list"></i>
					<span class="menu-text"> বিক্রয় রেকর্ড </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

		<?php if (array_search("currentStock", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>currentStock">
					<i class="menu-icon fa fa-th-list"></i>
					<span class="menu-text"> স্টক দেখুন</span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>
		<?php if (array_search("quotation", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>quotation">
					<i class="menu-icon fa fa-plus-square"></i>
					<span class="menu-text"> কোটেশন এন্ট্রি </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

		<?php if (
			array_search("salesinvoice", $access) > -1
			|| array_search("product_return_list", $access) > -1
			|| array_search("sale_return_details", $access) > -1
			|| array_search("customerDue", $access) > -1
			|| array_search("customerPaymentReport", $access) > -1
			|| array_search("customer_payment_history", $access) > -1
			|| array_search("customerlist", $access) > -1
			|| array_search("productwiseSales", $access) > -1
			|| array_search("customerwiseSales", $access) > -1
			|| array_search("invoiceProductDetails", $access) > -1
			|| array_search("price_list", $access) > -1
			|| array_search("quotation_invoice_report", $access) > -1
			|| array_search("quotation_record", $access) > -1
			|| isset($CheckSuperAdmin) || isset($CheckAdmin)
		) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>" class="dropdown-toggle">
					<i class="menu-icon fa fa-file"></i>
					<span class="menu-text"> রিপর্ট </span>
					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">
					<?php if (array_search("salesinvoice", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>salesinvoice">
								<i class="menu-icon fa fa-caret-right"></i>
								বিক্রয় ভাউচার
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("product_return_list", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>product_return_list">
								<i class="menu-icon fa fa-caret-right"></i>
								পণ্য ফেরত তালিকা
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<!-- <?php if (array_search("returnList", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>returnList">
								<i class="menu-icon fa fa-caret-right"></i>
								Sale return list
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?> -->

					<!-- <?php if (array_search("sale_return_details", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>sale_return_details">
								<i class="menu-icon fa fa-caret-right"></i>
								Sale return Details
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?> -->

					<?php if (array_search("customerDue", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>customerDue">
								<i class="menu-icon fa fa-caret-right"></i>
								গ্রাহক বাকি তালিকা
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("customerPaymentReport", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>customerPaymentReport">
								<i class="menu-icon fa fa-caret-right"></i>
								গ্রাহকের পেমেন্ট রিপোর্ট
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("customer_payment_history", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>customer_payment_history">
								<i class="menu-icon fa fa-caret-right"></i>
								গ্রাহকের পেমেন্ট বিবরণ
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("customerlist", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>customerlist">
								<i class="menu-icon fa fa-caret-right"></i>
								গ্রাহক তালিকা
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("price_list", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>price_list">
								<i class="menu-icon fa fa-caret-right"></i>
								পণ্যের মূল্য তালিকা
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("quotation_invoice_report", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>quotation_invoice_report">
								<i class="menu-icon fa fa-caret-right"></i>
								কোটেশন চালান
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("quotation_record", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>quotation_record">
								<i class="menu-icon fa fa-caret-right"></i>
								কোটেশন রেকর্ড
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>


				</ul>
			</li>
		<?php endif; ?>

	</ul><!-- /.nav-list -->

<?php } elseif ($module == 'PurchaseModule') { ?>
	<ul class="nav nav-list">
		<li class="active">
			<a href="<?php echo base_url(); ?>module/dashboard">
				<i class="menu-icon fa fa-tachometer"></i>
				<span class="menu-text"> ড্যাসবোর্ড </span>
			</a>

			<b class="arrow"></b>
		</li>
		<li>
			<a href="<?php echo base_url(); ?>module/PurchaseModule" class="module_title">
				<span> ক্রয় মডিউল </span>
			</a>
		</li>

		<?php if (array_search("purchase", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>purchase">
					<i class="menu-icon fa fa-shopping-cart"></i>
					<span class="menu-text"> ক্রয় এন্ট্রি করুন </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

		<?php if (array_search("purchaseReturns", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>purchaseReturns">
					<i class="menu-icon fa fa-rotate-right"></i>
					<span class="menu-text"> ক্রয় রিটার্ন </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

		<?php if (array_search("purchaseRecord", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>purchaseRecord">
					<i class="menu-icon fa fa-list"></i>
					<span class="menu-text">ক্রয় রেকর্ড</span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

		<?php if (array_search("AssetsEntry", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>AssetsEntry">
					<i class="menu-icon fa fa-shopping-cart"></i>
					<span class="menu-text"> সম্পদের এন্ট্রি </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

		<?php if (
			array_search("purchaseInvoice", $access) > -1
			|| array_search("supplierDue", $access) > -1
			|| array_search("supplierPaymentReport", $access) > -1
			|| array_search("supplierList", $access) > -1
			|| array_search("returnsList", $access) > -1
			|| array_search("purchase_return_details", $access) > -1
			|| array_search("reorder_list", $access) > -1
			|| array_search("assets_report", $access) > -1
			|| isset($CheckSuperAdmin) || isset($CheckAdmin)
		) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>" class="dropdown-toggle">
					<i class="menu-icon fa fa-file"></i>
					<span class="menu-text"> রিপর্ট </span>

					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">

					<?php if (array_search("assets_report", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>assets_report">
								<i class="menu-icon fa fa-caret-right"></i>
								সম্পদের রিপোর্ট
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("purchaseInvoice", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>purchaseInvoice">
								<i class="menu-icon fa fa-caret-right"></i>
								ক্রয় চালান
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>



					<?php if (array_search("supplierDue", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>supplierDue">
								<i class="menu-icon fa fa-caret-right"></i>
								সাপ্লায়ার বাকি রিপোর্ট
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("supplierPaymentReport", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>supplierPaymentReport">
								<i class="menu-icon fa fa-caret-right"></i>
								সাপ্লায়ার পেমেন্ট রিপোর্ট
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("supplierList", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>supplierList" target="_blank">
								<i class="menu-icon fa fa-caret-right"></i>
								<span class="menu-text"> সাপ্লায়ার তালিকা </span>
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("returnsList", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>returnsList">
								<i class="menu-icon fa fa-caret-right"></i>
								ক্রয় ফেরত তালিকা
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("purchase_return_details", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>purchase_return_details">
								<i class="menu-icon fa fa-caret-right"></i>
								ক্রয় ফেরত বিবরণ
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("reorder_list", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>reorder_list">
								<i class="menu-icon fa fa-caret-right"></i>
								<span class="menu-text">পুনঃ ওডার তালিকা</span>
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

				</ul>
			</li>
		<?php endif; ?>
	</ul><!-- /.nav-list -->

<?php } elseif ($module == 'AccountsModule') { ?>
	<ul class="nav nav-list">
		<li class="active">
			<a href="<?php echo base_url(); ?>module/dashboard">
				<i class="menu-icon fa fa-tachometer"></i>
				<span class="menu-text"> ড্যাসবোর্ড </span>
			</a>

			<b class="arrow"></b>
		</li>
		<li>
			<a href="<?php echo base_url(); ?>module/AccountsModule" class="module_title">
				<span> একাউন্ট মডিউল </span>
			</a>
		</li>

		<?php if (array_search("cashTransaction", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>cashTransaction">
					<i class="menu-icon fa fa-medkit"></i>
					<span class="menu-text"> নগদ লেনদেন </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

		<?php if (array_search("bank_transactions", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li>
				<a href="<?php echo base_url(); ?>bank_transactions">
					<i class="menu-icon fa fa-dollar"></i>
					<span class="menu-text"> ব্যাংক লেনদেন </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

		<?php if (array_search("customerPaymentPage", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>customerPaymentPage">
					<i class="menu-icon fa fa-money"></i>
					<span class="menu-text"> গ্রাহক পেমেন্ট </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

		<?php if (array_search("supplierPayment", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>supplierPayment">
					<i class="menu-icon fa fa-money"></i>
					<span class="menu-text"> সাপ্লায়ার পেমেন্ট </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

		<?php if (array_search("cash_view", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>cash_view">
					<i class="menu-icon fa fa-money"></i>
					<span class="menu-text">ক্যাশ ভিউ</span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

		<?php if (
			array_search("loan_transactions", $access) > -1
			|| array_search("loan_view", $access) > -1
			|| array_search("loan_transaction_report", $access) > -1
			|| array_search("loan_ledger", $access) > -1
			|| array_search("loan_accounts", $access) > -1
			|| isset($CheckSuperAdmin) || isset($CheckAdmin)
		) : ?>

			<li class="">
				<a href="<?php echo base_url(); ?>" class="dropdown-toggle">
					<i class="menu-icon fa fa-file"></i>
					<span class="menu-text"> লোন </span>

					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">
					<?php if (array_search("loan_transactions", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>loan_transactions">
								<i class="menu-icon fa fa-caret-right"></i>
								লোন লেনদেন
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("loan_view", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>loan_view">
								<i class="menu-icon fa fa-caret-right"></i>
								লোন দেখুন
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("loan_transaction_report", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>loan_transaction_report">
								<i class="menu-icon fa fa-caret-right"></i>
								লোন লেনদেন রিপর্ট
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("loan_ledger", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>loan_ledger">
								<i class="menu-icon fa fa-caret-right"></i>
								লোন লেজার
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("loan_accounts", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>loan_accounts">
								<i class="menu-icon fa fa-caret-right"></i>
								লোন একাউন্ট </a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>
				</ul>
			</li>
		<?php endif; ?>

		<?php if (
			array_search("investment_transactions", $access) > -1
			|| array_search("investment_transaction_report", $access) > -1
			|| array_search("investment_view", $access) > -1
			|| array_search("investment_ledger", $access) > -1
			|| array_search("investment_account", $access) > -1
			|| isset($CheckSuperAdmin) || isset($CheckAdmin)
		) : ?>

			<li class="">
				<a href="<?php echo base_url(); ?>" class="dropdown-toggle">
					<i class="menu-icon fa fa-file"></i>
					<span class="menu-text"> বিনিয়োগ </span>

					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">
					<?php if (array_search("investment_transactions", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>investment_transactions">
								<i class="menu-icon fa fa-caret-right"></i>
								বিনিয়োগ লেনদেন
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("investment_view", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>investment_view">
								<i class="menu-icon fa fa-caret-right"></i>
								বিনিয়োগ দেখুন
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("investment_transaction_report", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>investment_transaction_report">
								<i class="menu-icon fa fa-caret-right"></i>
								বিনিয়োগ লেনদেন রিপর্ট
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("investment_ledger", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>investment_ledger">
								<i class="menu-icon fa fa-caret-right"></i>
								বিনিয়োগ লেজার
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("investment_account", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>investment_account">
								<i class="menu-icon fa fa-caret-right"></i>
								বিনিয়োগ একাউন্ট
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>
				</ul>
			</li>
		<?php endif; ?>

		<?php if (
			array_search("account", $access) > -1
			|| array_search("bank_accounts", $access) > -1
			|| isset($CheckSuperAdmin) || isset($CheckAdmin)
		) : ?>

			<li>
				<a href="" class="dropdown-toggle">
					<i class="menu-icon fa fa-bank"></i>
					<span class="menu-text"> অ্যাকাউন্ট হেড</span>

					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">
					<?php if (array_search("account", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li>
							<a href="<?php echo base_url(); ?>account">
								<i class="menu-icon fa fa-caret-right"></i>
								লেনদেন হিসাব
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>
					<?php if (array_search("bank_accounts", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li>
							<a href="<?php echo base_url(); ?>bank_accounts">
								<i class="menu-icon fa fa-caret-right"></i>
								ব্যাংক হিসাব
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>
				</ul>
			</li>
		<?php endif; ?>

		<?php if (
			array_search("check/entry", $access) > -1
			|| array_search("check/list", $access) > -1
			|| array_search("check/reminder/list", $access) > -1
			|| array_search("check/pending/list", $access) > -1
			|| array_search("check/dis/list", $access) > -1
			|| array_search("check/paid/list", $access) > -1
			|| isset($CheckSuperAdmin) || isset($CheckAdmin)
		) : ?>

			<li class="">
				<a href="<?php echo base_url(); ?>" class="dropdown-toggle">
					<i class="menu-icon fa fa-file"></i>
					<span class="menu-text"> চেক </span>

					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">
					<?php if (array_search("check/entry", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>check/entry">
								<i class="menu-icon fa fa-caret-right"></i>
								চেক এন্ট্রি করুন
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("check/list", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>check/list">
								<i class="menu-icon fa fa-caret-right"></i>
								চেক তালিকা
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("check/reminder/list", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>check/reminder/list">
								<i class="menu-icon fa fa-caret-right"></i>
								 রিমাইন্ডার চেক তালিকা 
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("check/pending/list", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>check/pending/list">
								<i class="menu-icon fa fa-caret-right"></i>
								পেন্ডিং চেক তালিকা 
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("check/dis/list", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>check/dis/list">
								<i class="menu-icon fa fa-caret-right"></i>
								 ডিসঅর্নাড চেক তালিকা 
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("check/paid/list", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>check/paid/list">
								<i class="menu-icon fa fa-caret-right"></i>
								প্রদত্ত চেক তালিকা
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>
				</ul>
			</li>
		<?php endif; ?>

		<?php if (
			array_search("TransactionReport", $access) > -1
			|| array_search("bank_transaction_report", $access) > -1
			|| array_search("cash_ledger", $access) > -1
			|| array_search("bank_ledger", $access) > -1
			|| array_search("cashStatment", $access) > -1
			|| array_search("BalanceSheet", $access) > -1
			|| array_search("balance_sheet", $access) > -1
			|| array_search("day_book", $access) > -1
			|| isset($CheckSuperAdmin) || isset($CheckAdmin)
		) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>" class="dropdown-toggle">
					<i class="menu-icon fa fa-file"></i>
					<span class="menu-text"> রিপর্ট </span>

					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">
					<?php if (array_search("TransactionReport", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>TransactionReport">
								<i class="menu-icon fa fa-caret-right"></i>
								ক্যাশ লেনদেন রিপোর্ট
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("bank_transaction_report", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>bank_transaction_report">
								<i class="menu-icon fa fa-caret-right"></i>
								ব্যাংক লেনদেন রিপোর্ট
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("cash_ledger", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>cash_ledger">
								<i class="menu-icon fa fa-caret-right"></i>
								ক্যাশ লেজার
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("bank_ledger", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>bank_ledger">
								<i class="menu-icon fa fa-caret-right"></i>
								ব্যাংক লেজার
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("cashStatment", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>cashStatment">
								<i class="menu-icon fa fa-caret-right"></i>
								
								ক্যাশ স্টেটমেন্ট 
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("balance_sheet", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>balance_sheet">
								<i class="menu-icon fa fa-caret-right"></i>
								ব্যালেন্স শীট
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("BalanceSheet", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>BalanceSheet">
								<i class="menu-icon fa fa-caret-right"></i>
								ব্যালেন্স ইন আউট
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("day_book", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>day_book">
								<i class="menu-icon fa fa-caret-right"></i>
								 দৈনিক বই

							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

				</ul>
			</li>
		<?php endif; ?>


	</ul><!-- /.nav-list -->
<?php } elseif ($module == 'HRPayroll') { ?>
	<ul class="nav nav-list">
		<li class="active">
			<a href="<?php echo base_url(); ?>module/dashboard">
				<i class="menu-icon fa fa-tachometer"></i>
				<span class="menu-text"> ড্যাসবোর্ড </span>
			</a>

			<b class="arrow"></b>
		</li>
		<li>
			<a href="<?php echo base_url(); ?>module/HRPayroll" class="module_title">
				<span>HR & Payroll</span>
			</a>
		</li>

		<?php if (array_search("salary_payment", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>salary_payment">
					<i class="menu-icon fa fa-money"></i>
					<span class="menu-text">বেতন প্রদান</span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

		<?php if (array_search("employee", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>employee">
					<i class="menu-icon fa fa-users"></i>
					<span class="menu-text"> কর্মচারী যোগ করুন</span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

		<?php if (array_search("designation", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>designation">
					<i class="menu-icon fa fa-binoculars"></i>
					<span class="menu-text"> পদবী যোগ করুন </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

		<?php if (array_search("depertment", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>depertment">
					<i class="menu-icon fa fa-plus-square"></i>
					<span class="menu-text"> ডিপার্টমেন্ট যোগ করুন</span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

		<?php if (array_search("month", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>month">
					<i class="menu-icon fa fa-calendar"></i>
					<span class="menu-text"> মাস যোগ করুন </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

		<?php if (
			array_search("emplists/all", $access) > -1
			|| array_search("emplists/active", $access) > -1
			|| array_search("emplists/deactive", $access) > -1
			|| array_search("salary_payment_report", $access) > -1
			|| isset($CheckSuperAdmin) || isset($CheckAdmin)
		) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>" class="dropdown-toggle">
					<i class="menu-icon fa fa-file"></i>
					<span class="menu-text"> রিপোর্ট </span>
					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">

					<?php if (array_search("emplists/all", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>emplists/all">
								<i class="menu-icon fa fa-caret-right"></i>
								সমস্ত কর্মচারী তালিকা
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("emplists/active", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>emplists/active">
								<i class="menu-icon fa fa-caret-right"></i>
								
									সক্রিয় কর্মচারী তালিকা
							</a>
							<b class="arrow"></b>
						</li>
						<?php endif; ?><?php if (array_search("emplists/deactive", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>emplists/deactive">
								<i class="menu-icon fa fa-caret-right"></i>
								
								নিষ্ক্রিয়  কর্মচারী তালিকা
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("salary_payment_report", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>salary_payment_report">
								<i class="menu-icon fa fa-caret-right"></i>
								বেতন পেমেন্ট রিপোর্ট
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

				</ul>
			</li>
		<?php endif; ?>

	</ul><!-- /.nav-list -->
<?php } elseif ($module == 'ReportsModule') { ?>
	<ul class="nav nav-list">
		<li class="active">
			<a href="<?php echo base_url(); ?>module/dashboard">
				<i class="menu-icon fa fa-tachometer"></i>
				<span class="menu-text"> ড্যাসবোর্ড </span>
			</a>

			<b class="arrow"></b>
		</li>
		<li>
			<a href="<?php echo base_url(); ?>module/ReportsModule" class="module_title">
				<span>রিপোর্ট মডিউল</span>
			</a>
		</li>

		<?php if (array_search("profitLoss", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>profitLoss">
					<i class="menu-icon fa fa-medkit"></i>
					<span class="menu-text"> লাভ ও ক্ষতি রিপোর্ট </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

		<?php if (array_search("cash_view", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>cash_view">
					<i class="menu-icon fa fa-money"></i>
					<span class="menu-text">ক্যাশ ভিউ</span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>

		<?php if (
			array_search("purchaseInvoice", $access) > -1
			|| array_search("purchaseRecord", $access) > -1
			|| array_search("supplierDue", $access) > -1
			|| array_search("supplierPaymentReport", $access) > -1
			|| array_search("supplierList", $access) > -1
			|| array_search("returnsList", $access) > -1
			|| array_search("purchase_return_details", $access) > -1
			|| isset($CheckSuperAdmin) || isset($CheckAdmin)
		) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>" class="dropdown-toggle">
					<i class="menu-icon fa fa-file"></i>
					<span class="menu-text"> ক্রয় রিপোর্ট </span>

					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">

					<?php if (array_search("purchaseInvoice", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>purchaseInvoice">
								<i class="menu-icon fa fa-caret-right"></i>
								
								ক্রয় চালান
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("purchaseRecord", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>purchaseRecord">
								<i class="menu-icon fa fa-caret-right"></i>
								ক্রয় রেকর্ড
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("supplierDue", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>supplierDue">
								<i class="menu-icon fa fa-caret-right"></i>
								
								সাপ্লায়ার বাকি রিপোর্ট
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("supplierPaymentReport", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>supplierPaymentReport">
								<i class="menu-icon fa fa-caret-right"></i>
								সাপ্লায়ার পেমেন্ট
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("supplierList", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>supplierList" target="_blank">
								<i class="menu-icon fa fa-caret-right"></i>
								<span class="menu-text"> সাপ্লায়ার তালিকা </span>
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("returnsList", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>returnsList">
								<i class="menu-icon fa fa-caret-right"></i>
								ক্রয় ফেরত তালিকা
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("purchase_return_details", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>purchase_return_details">
								<i class="menu-icon fa fa-caret-right"></i>
								ক্রয় ফেরত বিবরণ
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

				</ul>
			</li>
		<?php endif; ?>


		<?php if (
			array_search("salesinvoice", $access) > -1
			|| array_search("salesrecord", $access) > -1
			|| array_search("product_return_list", $access) > -1
			|| array_search("sale_return_details", $access) > -1
			|| array_search("customerDue", $access) > -1
			|| array_search("customerPaymentReport", $access) > -1
			|| array_search("customer_payment_history", $access) > -1
			|| array_search("customerlist", $access) > -1
			|| array_search("productwiseSales", $access) > -1
			|| array_search("customerwiseSales", $access) > -1
			|| array_search("invoiceProductDetails", $access) > -1
			|| array_search("price_list", $access) > -1
			|| array_search("quotation_invoice_report", $access) > -1
			|| array_search("quotation_record", $access) > -1
			|| isset($CheckSuperAdmin) || isset($CheckAdmin)
		) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>" class="dropdown-toggle">
					<i class="menu-icon fa fa-file"></i>
					<span class="menu-text"> বিক্রয় রিপোর্ট </span>
					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">

					<?php if (array_search("salesinvoice", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>salesinvoice">
								<i class="menu-icon fa fa-caret-right"></i>
								বিক্রয় ভাউচার
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("salesrecord", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>salesrecord">
								<i class="menu-icon fa fa-caret-right"></i>
								বিক্রয় রেকর্ড
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("product_return_list", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>product_return_list">
								<i class="menu-icon fa fa-caret-right"></i>
								বিক্রয় ফেরত তালিকা
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("sale_return_details", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>sale_return_details">
								<i class="menu-icon fa fa-caret-right"></i>
								বিক্রয় ফেরত বিবরণ
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("customerDue", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>customerDue">
								<i class="menu-icon fa fa-caret-right"></i>
								গ্রাহকের বাকি তালিকা
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("customerPaymentReport", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>customerPaymentReport">
								<i class="menu-icon fa fa-caret-right"></i>
								গ্রাহক পেমেন্ট রিপোর্ট
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("customer_payment_history", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>customer_payment_history">
								<i class="menu-icon fa fa-caret-right"></i>
								গ্রাহক পেমেন্ট  হিস্ট্রি
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("customerlist", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>customerlist">
								<i class="menu-icon fa fa-caret-right"></i>
								গ্রাহক তালিকা
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("price_list", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>price_list">
								<i class="menu-icon fa fa-caret-right"></i>
								পণ্যের মূল্য তালিকা
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("quotation_invoice_report", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>quotation_invoice_report">
								<i class="menu-icon fa fa-caret-right"></i>
								কোটেশন চালান
								
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("quotation_record", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>quotation_record">
								<i class="menu-icon fa fa-caret-right"></i>
								
								কোটেশন রেকর্ড
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

				</ul>
			</li>
		<?php endif; ?>


		<?php if (array_search("currentStock", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>currentStock">
					<i class="menu-icon fa fa-th-list"></i>
					<span class="menu-text"> স্টক </span>
				</a>
				<b class="arrow"></b>
			</li>
		<?php endif; ?>


		<?php if (
			array_search("TransactionReport", $access) > -1
			|| array_search("bank_transaction_report", $access) > -1
			|| array_search("cash_ledger", $access) > -1
			|| array_search("bank_ledger", $access) > -1
			|| array_search("cashStatment", $access) > -1
			|| array_search("BalanceSheet", $access) > -1
			|| array_search("day_book", $access) > -1
			|| isset($CheckSuperAdmin) || isset($CheckAdmin)
		) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>" class="dropdown-toggle">
					<i class="menu-icon fa fa-file"></i>
					<span class="menu-text"> অ্যাকাউন্টস রিপোর্ট </span>

					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">
					<?php if (array_search("TransactionReport", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>TransactionReport">
								<i class="menu-icon fa fa-caret-right"></i>
								ক্যাশ লেনদেন রিপোর্ট
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("bank_transaction_report", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>bank_transaction_report">
								<i class="menu-icon fa fa-caret-right"></i>
								ব্যাংক লেনদেন রিপোর্ট
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("cash_ledger", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>cash_ledger">
								<i class="menu-icon fa fa-caret-right"></i>
								ক্যাশ লেজার
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("bank_ledger", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>bank_ledger">
								<i class="menu-icon fa fa-caret-right"></i>
								ব্যাংক লেজার
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("cashStatment", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>cashStatment">
								<i class="menu-icon fa fa-caret-right"></i>
								ক্যাশ স্টেটমেন্ট
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("BalanceSheet", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>BalanceSheet">
								<i class="menu-icon fa fa-caret-right"></i>
								ব্যালেন্স ইন আউট
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("day_book", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>day_book">
								<i class="menu-icon fa fa-caret-right"></i>
								দৈনিক বই
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

				</ul>
			</li>
		<?php endif; ?>


		<?php if (
			array_search("emplists/all", $access) > -1
			|| array_search("emplists/active", $access) > -1
			|| array_search("emplists/deactive", $access) > -1
			|| array_search("salary_payment_report", $access) > -1
			|| isset($CheckSuperAdmin) || isset($CheckAdmin)
		) : ?>
			<li class="">
				<a href="<?php echo base_url(); ?>" class="dropdown-toggle">
					<i class="menu-icon fa fa-file"></i>
					<span class="menu-text"> কর্মচারী রিপোর্ট </span>
					<b class="arrow fa fa-angle-down"></b>
				</a>

				<b class="arrow"></b>

				<ul class="submenu">

					<?php if (array_search("emplists/all", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>emplists/all">
								<i class="menu-icon fa fa-caret-right"></i>
								সমস্ত কর্মচারী তালিকা
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("emplists/active", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>emplists/active">
								<i class="menu-icon fa fa-caret-right"></i>
								সক্রিয় কর্মচারী তালিকা
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("emplists/deactive", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>emplists/deactive">
								<i class="menu-icon fa fa-caret-right"></i>
								নিষ্ক্রিয় কর্মচারী তালিকা
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

					<?php if (array_search("salary_payment_report", $access) > -1 || isset($CheckSuperAdmin) || isset($CheckAdmin)) : ?>
						<li class="">
							<a href="<?php echo base_url(); ?>salary_payment_report">
								<i class="menu-icon fa fa-caret-right"></i>
								বেতন পেমেন্ট রিপোর্ট
							</a>
							<b class="arrow"></b>
						</li>
					<?php endif; ?>

				</ul>
			</li>
		<?php endif; ?>
	</ul><!-- /.nav-list -->
<?php } ?>