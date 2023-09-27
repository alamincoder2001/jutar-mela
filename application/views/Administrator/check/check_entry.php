<style type="text/css">
  span.select2.select2-container.select2-container--default{
      width: 100% !important;
  }
  .select2-container .select2-selection--single {
      height: 28px;
      border-radius: 4px;
      margin-bottom: 5px;
  }

  .select2-container--default .select2-selection .select2-selection__clear{
      display: none;
  }
</style>
<div class="row">
  <div class="col-xs-12">

      <!--============Customer Information============ -->
      <!--============Customer Information============ -->
      <div class="widget-box">
        <div class="widget-header">
          <h4 class="widget-title">নতুন চেক তথ্য যোগ করুন</h4>
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
            <form id="check_form" action="<?= base_url();?>check/store" method="POST">
              <div class="row">
                <div class="col-sm-2"></div>

                <div class="col-sm-4">
                  
                  <div class="form-group">
                    <label class="col-sm-5 control-label no-padding-left" for="cus_id">ক্রেতা নির্বাচন  :<span class="text-bold text-danger">*</span></label>
                    <div class="col-sm-7">
                      <select class="select2 form-control" id="cus_id" required name="cus_id" style="height: 30px; border-radius: 5px;">
                        <option value=" ">ক্রেতা নির্বাচন</option>
                        <?php if($customers && isset($customers)):  foreach($customers as $customer):?>
                          <option value="<?= $customer->Customer_SlNo; ?>"><?= $customer->Customer_Code.' - '.ucfirst($customer->Customer_Name); ?></option>
                        <?php endforeach; endif; ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-5 control-label no-padding-left" for="bank_name">ব্যাংকের নাম:<span class="text-bold text-danger">*</span> </label>
                    <div class="col-sm-7">
                      <input type="text" id="bank_name"  name="bank_name" required placeholder="Bank Name" class="form-control"  />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-5 control-label no-padding-left" for="branch_name">শাখার নাম:<span class="text-bold text-danger">*</span> </label>
                    <div class="col-sm-7">
                      <input type="text" id="branch_name"  name="branch_name" required placeholder="Branch Name" class="form-control"  />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-5 control-label no-padding-left" for="check_no">চেক নং:<span class="text-bold text-danger">*</span> </label>
                    <div class="col-sm-7">
                      <input type="text" id="check_no"  name="check_no" required placeholder="Cheque No" class="form-control"  />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-5 control-label no-padding-left" for="check_amount">চেক পরিমাণ:<span class="text-bold text-danger">*</span> </label>
                    <div class="col-sm-7">
                      <input type="text" id="check_amount"  name="check_amount" required placeholder="Cheque Amount" class="form-control"  />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-5 control-label no-padding-left" for="check_status">চেক স্ট্যাটাস:<span class="text-bold text-danger">*</span></label>
                    <div class="col-sm-7">
                      <select class="chosen-select form-control" id="check_status" required name="check_status" style="height: 30px; border-radius: 5px;">
                        <option value="Pe" >Pending</option>
                        <option value="Pa">Paid</option>
                      </select>
                    </div>
                  </div>
                  
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label class="col-sm-5 control-label no-padding-left" for="date"> তারিখ :<span class="text-bold text-danger">*</span> </label>
                    <div class="col-sm-7">
                       <input class="form-control date-picker" required id="date" name="date" type="text" value="<?php echo date('Y-m-d'); ?>"  data-date-format="yyyy-mm-dd" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-5 control-label no-padding-left" for="check_date">চেক তারিখ :<span class="text-bold text-danger">*</span> </label>
                    <div class="col-sm-7">
                       <input class="form-control date-picker" required id="check_date" name="check_date" type="text" value="<?php echo date('Y-m-d'); ?>"  data-date-format="yyyy-mm-dd" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-5 control-label no-padding-left" for="remid_date">রিমাইন্ডার তারিখ:<span class="text-bold text-danger">*</span> </label>
                    <div class="col-sm-7">
                       <input class="form-control date-picker" required id="remid_date" name="remid_date" type="text" value="<?php echo date('Y-m-d'); ?>"  data-date-format="yyyy-mm-dd" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-5 control-label no-padding-left" for="sub_date">জমার তারিখ:<span class="text-bold text-danger">*</span> </label>
                    <div class="col-sm-7">
                       <input class="form-control date-picker" required id="sub_date" name="sub_date" type="text" value="<?php echo date('Y-m-d'); ?>"  data-date-format="yyyy-mm-dd" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-5 control-label no-padding-left" for="note">বর্ণনা : </label>
                    <div class="col-sm-7">
                       <input type="text" id="note" name="note" class="form-control"  placeholder="Despription" />
                    </div>
                  </div>
                  
                  <div class="form-group" style="margin-top: 10px;">
                    <label class="col-sm-4 control-label no-padding-left" for="ord_budget_range"> </label>
                    <div class="col-sm-8">
                      <button type="submit" id="check_submit" style="height: 27px; padding-top: 0px; float: right;" class="btn btn-primary cus_submit">জমা দিন</button>
                    </div>
                  </div>


                </div>

              </div>
            </form>
          </div>
        </div>
      </div>
  </div>  
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="widget-box">
			<div class="widget-header">
				<h4 class="widget-title">চেক তথ্য তালিকা</h4>
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
					<table id="dynamic-table" class="table table-striped table-bordered table-hover">
						<thead>
						<tr>
							<th>চেক তারিখ </th>
							<th>চেক নং</th>
							<th>ব্যাংক নাম - শাখার নাম</th>
							<th>ক্রেতার নাম</th>
							<th>চেক স্ট্যাটাস</th>
							<th>চেক হিসাব</th>
							<th>কর্ম</th>
						</tr>
						</thead>

						<tbody id="tBody">
						<?php $i=1; if(isset($checks)&&$checks ): foreach($checks as $check):?>
							<tr style="<?= ($check->check_status == 'Di')?'background-color:#ff000036;':''?>">
								<td><?php
									$date = new DateTime($check->check_date);
									echo date_format($date, 'd M Y');
									?></td>
								<td><?= $check->check_no; ?></td>
								<td><?= $check->bank_name.'-'.$check->branch_name; ?></td>
								<td><?= $check->Customer_Code.' - '.$check->Customer_Name; ?></td>

								<td>
									<?php if($check->check_status == 'Pa'): ?>
										<span class="label " style="background: green;">Paid</span>
									<?php elseif($check->check_status == 'Di'): ?>
										<span class="label " style="background: red;">Dishonor</span>
									<?php else: ?>
										<span class="label " style="background: #ec880a;">Pending</span>
									<?php endif;?>
								</td>
								<td><?= number_format($check->check_amount,2); ?></td>
								<td>
									<div class="hidden-sm hidden-xs action-buttons">
										<a class="linka fancybox fancybox.ajax" style="color: #F89406;"  href="<?= base_url();?>check/view/<?= $check->id;?>" >
											<i class="ace-icon fa fa-eye bigger-130" ></i>
                    </a>
                    <?php if($this->session->userdata('accountType') != 'u'){?>
										<a class="green" href="<?= base_url();?>check/edit/<?= $check->id; ?>" >
											<i class="ace-icon fa fa-pencil bigger-130"></i>
										</a>
										<a class="red" href="<?= base_url(); ?>check/delete/<?= $check->id?>" onclick="return confirm('Are You Sure Went to Delete This! ')">
											<i class="ace-icon fa fa-trash-o bigger-130"></i>
                    </a>
                    <?php }?>
									</div>
								</td>


							</tr>
						<?php endforeach; endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


<?php //$this->load->view('admin/ajax/check_ajax');?>
