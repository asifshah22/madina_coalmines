<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-user"></i>&nbsp;Company</h1>
    </section>

  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- form elements --> 
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title text-light-blue">View Company Details</h3>
            </div>
              
            <!-- /.box-header -->
            <div class="box-body no-padding">
            <form role="form" class="form-horizontal"> 

                    <div class="box-body">

                          <div class="form-group">
                            <label for="Designation" class="col-sm-1 control-label">Company Name:</label>
                            <div class="col-sm-4" style="padding-top:7px;"><?php print $GetCompany->CompanyName; ?></div>
                          </div><!-- /.form-group -->


                          <div class="form-group">
                            <label for="Designation" class="col-sm-1 control-label">Address:</label>
                            <div class="col-sm-4" style="padding-top:7px;"><?php print $GetCompany->Address; ?></div>
                          </div><!-- /.form-group -->

                          <div class="form-group">
                            <label for="Designation" class="col-sm-1 control-label">NTN:</label>
                            <div class="col-sm-4" style="padding-top:7px;"><?php print $GetCompany->NTN; ?></div>
                          </div><!-- /.form-group -->

                          <div class="form-group">
                            <label for="Designation" class="col-sm-1 control-label">Fax No:</label>
                            <div class="col-sm-4" style="padding-top:7px;"><?php print $GetCompany->FaxNo; ?></div>
                          </div><!-- /.form-group -->

                          <div class="form-group">
                            <label for="Designation" class="col-sm-1 control-label">Website:</label>
                            <div class="col-sm-4" style="padding-top:7px;"><?php print $GetCompany->Website; ?></div>
                          </div><!-- /.form-group -->

                          <div class="form-group">
                            <label for="Designation" class="col-sm-1 control-label">Company Warranty:</label>
                            <div class="col-sm-4" style="padding-top:7px;"><?php print $GetCompany->CompanyWarranty; ?></div>
                          </div><!-- /.form-group -->
                        <!-- /.col -->
                           <div class="form-group">
                              <label for="Designation" class="col-sm-1 control-label">Company Logo:</label>
                              <div class="col-sm-4" style="padding-top:7px;">
                           <?php if($GetCompany->CompanyLogo) { ?>
                           <img src="<?php echo base_url()."images/company-logo/".$GetCompany->CompanyLogo; ?>" width="200" height="150">
                           <?php } else { ?>
                           <img src="<?php echo base_url()."images/default.png"; ?>">
                           <?php  } ?> 
                              </div>
                            </div>
                      </div>
                      <!-- /.row -->
                          
  <div class="box-body">
    <div class="row">
      <div class="col-md-2">
       <a href="<?php echo base_url(); ?>Company/AddCompany" class="btn btn-block btn-primary">Add Record</a>
      </div>   
      <div class="col-md-2">
       <a href="<?php echo base_url(); ?>Company/"><button type="button" name="BankToMain" value="BankToMain" class="btn btn-block bg-orange">Back to Main</button></a>
      </div>
     </div>
          </div>
              </div>
            </form>
            </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content --> 
  </div>
<!-- ./wrapper -->
<?php $this->load->view('includes/footer'); ?>