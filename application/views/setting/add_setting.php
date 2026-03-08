<?php $this->load->view('admin/includes/header'); ?>
<?php $this->load->view('admin/includes/sidebar'); ?>

            <!-- /.main-content starts -->
            <div class="main-content">
                <div class="main-content-inner">
                    
                     <!-- /.breadcrumb starts -->
          <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
              <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="<?php echo base_url(); ?>Dashboard">Home </a>
              </li>
              <li class=""><a href="#">Setting</a></li>
              <li class="active"><a href="#">Add Setting</a></li>
            </ul><!-- /.breadcrumb -->

            <div class="nav-search" id="nav-search">
              <form class="form-search">
                <span class="input-icon">
                  <!-- <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                  <i class="ace-icon fa fa-search nav-search-icon"></i> -->
                </span>
              </form>
            </div><!-- /.nav-search -->
          </div>
                  <!-- /.breadcrumb ends -->

                    <div class="page-content">
                    
                        <div class="page-header">
                            <h5 style="color: rgb(67, 142, 185);">Add New Setting</h5>
                        </div><!-- /.page-header -->
                        
              <form enctype="multipart/form-data" class="form-horizontal" role="form" action="<?php echo base_url(); ?>Setting/SaveSetting/" method="post">
                     <!-- /.row  starts-->
                     <div class="box-body">
                      <div class="row">
                       
                        <div style="border:0px solid;" class="col-md-12">
                        <div class="col-md-6">
                          <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4">Company:</div>
                            <div class="col-sm-8 col-sm-8"><select name="CompanyId" id="CompanyId" style="width: 190px" class="col-md-12" required="required">
                                <option value="0">Select Company</option>
                                <?php foreach ($GetAllCompanies as $row) {
                                ?>
                                <option value="<?php echo $row['CompanyId'] ?>"><?php echo $row['CompanyName']; ?></option>
                                <?php
                                } ?>
                              </select></div>
                          </div><!-- /.form-group -->
                          <div class="space-4"></div>
                          <div class="space-4"></div>

                          <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4">Component:</div>
                            <div class="col-sm-8 col-sm-8"><select name="ComponentId" id="ComponentId" style="width: 190px" class="col-md-12" required="required">
                                <option value="0">Select Component</option>
                                <option value="1">Purchase</option>
                                <option value="2">Purchase Return</option>
                                <option value="3">Sale</option>
                                <option value="4">Sale Return</option>
				<option value="5">Customer</option>
				<option value="6">Vendor</option>
                              </select></div>
                          </div><!-- /.form-group -->
                          <div class="space-4"></div>
                          <div class="space-4"></div>


                          <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4">Transaction Type:</div>
                            <div class="col-sm-8 col-sm-8"><select name="TransactionTypeId" id="TransactionTypeId" style="width: 190px" class="col-md-12" required="required">
                                <option value="0">Select Transaction Type</option>
                                <option value="1">Purchase Account</option>
				<option value="2">Purchase Return Account</option>
                                <option value="3">Sale Account</option>
				<option value="4">Sale Return Account</option>
                                <option value="5">Customer Account</option>
				<option value="6">Vendor Account</option>
				<option value="7">Cash Account</option>
				<option value="8">Stock Account</option>
			        <option value="9">Cost of Sale</option>
                              </select></div>
                          </div><!-- /.form-group -->
                          <div class="space-4"></div>
                          <div class="space-4"></div>

                          <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4">Control Code:</div>
                            <div class="col-sm-8 col-sm-8">
				<select name="ChartOfAccountControlId" id="form-field-select-3" class="chosen-select form-control" style="width: 190px;" required="required">
                                <option value="0">Control Code</option>
                                <?php foreach ($GetAllControlCodes as $CC) {
                                ?>
                                <option value="<?php echo $CC['ChartOfAccountControlId'] ?>"><?php echo $CC['ControlCode'] . "-" . $CC['ControlName'].'  Company Name:'.$CC['CompanyName']; ?></option>
                                <?php
                                } ?>
                              </select></div>
                          </div><!-- /.form-group -->
                          <div class="space-4"></div>
                          <div class="space-4"></div>
			  
			  <div class="form-group">
                            <div style="font-weight:600;" class="col-sm-4">Chart Of Account:</div>
                            <div class="col-sm-8 col-sm-8"><select name="ChartOfAccountId" id="ChartOfAccountId" style="width: 190px" class="col-md-12" required="required">
                                <option value="0">Chart Of Account</option>
                                <?php foreach ($GetAllChartOfAccount as $row) {
                                ?>
                                <option value="<?php echo $row['ChartOfAccountId'] ?>"><?php echo $row['ChartOfAccountTitle'].'  Company Name:'.$row['CompanyName']; ?></option>
                                <?php
                                } ?>
                              </select></div>
                          </div><!-- /.form-group -->
                          <div class="space-4"></div>
                          <div class="space-4"></div>

                          <div class="form-group">
                          <div style="font-weight:600;" class="col-sm-4">Notes:</div>
                          <div class="col-sm-8"><div class="col-sm-8" style="width: 400px;"><textarea name="Notes" rows="4" class="col-sm-8"></textarea></div>
                          </div><!-- /.form-group -->
                        </div>
                          <div class="space-4"></div>
                          <div class="space-4"></div>
                          <div class="space-4"></div>
                          <div class="space-4"></div>
                          
                      <div class="form-group" style="margin-left: 25%;">
                        <div class="col-sm-2"><button type="submit" id="AddSetting" class="btn btn-sm btn-primary">Add Setting</button></div>
                      </div>

                       </div>
                      <!-- /.row -->
                      <!-- /.form-group -->
                          
                       </form>   
                     </div><!-- /.page-content -->
                </div>
            </div>
            <!-- /.main-content ends -->
            
           
<?php $this->load->view('admin/includes/footer'); ?>