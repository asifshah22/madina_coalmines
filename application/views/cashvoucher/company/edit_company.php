<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar');

$id = $GetCompany->CompanyId;
?>

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
              <h3 class="box-title text-light-blue">Update Company</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
                <form enctype="multipart/form-data" class="form-horizontal" role="form" action='<?php echo base_url("Company/UpdateCompany/$id"); ?>' method="post">

                    <!-- /.row  starts-->
                     <div class="box-body">
                          
                          <div class="form-group">
                            <label for="CompanyName" class="col-sm-1 control-label">Company Name:</label>
                            <div class="col-sm-4">
                            <input type="text" name="CompanyName" id="form-field-1" class="form-control" value="<?php print $GetCompany->CompanyName; ?>">
                          </div>
                          </div><!-- /.form-group -->

                          <div class="form-group">
                            <label for="CompanyName" class="col-sm-1 control-label">Address:</label>
                            <div class="col-sm-4">
                            <input type="text" name="Address" id="form-field-1" class="form-control" value="<?php print $GetCompany->Address; ?>">
                          </div>
                          </div><!-- /.form-group -->

                          <div class="form-group">
                            <label for="CompanyName" class="col-sm-1 control-label">NTN:</label>
                            <div class="col-sm-4">
                            <input type="text" name="NTN" id="form-field-1" class="form-control" value="<?php print $GetCompany->NTN; ?>">
                          </div>
                          </div><!-- /.form-group -->

                          <div class="form-group">
                            <label for="CompanyName" class="col-sm-1 control-label">Fax No:</label>
                            <div class="col-sm-4">
                              <input type="text" name="FaxNo" id="form-field-1" class="form-control" value="<?php print $GetCompany->FaxNo; ?>">
                            </div>
                          </div><!-- /.form-group -->

                          <div class="form-group">
                            <label for="CompanyName" class="col-sm-1 control-label">Website:</label>
                            <div class="col-sm-4">
                            <input type="text" name="Website" id="form-field-1" class="form-control" value="<?php print $GetCompany->Website; ?>"></div>
                          </div>

                          <div class="form-group">
                            <label for="CompanyName" class="col-sm-1 control-label">CompanyWarranty:</label>
                            <div class="col-sm-4">
                              <textarea name="CompanyWarranty" rows="4" cols="14" class="form-control">
                              <?php print $GetCompany->CompanyWarranty; ?> </textarea>
                            </div>
                          </div><!-- /.form-group -->

                          <div class="form-group">
                            <label for="CompanyName" class="col-sm-1 control-label">Company Logo:</label>
                            <div class="col-md-4"><input type="file" name="CompanyLogo" id="id-input-file-2">
                            </div>
                          </div>
                        <!-- /.col -->

                          <div class="form-group">
                            <label for="CompanyName" class="col-sm-1 control-label">Company Logo:</label>
                            <div class="col-md-4">
                         <?php if($GetCompany->CompanyLogo!="") { ?>
                         <img src="<?php echo base_url()."images/company-logo/".$GetCompany->CompanyLogo; ?>">
                         <?php } else { ?>
                         <img src="<?php echo base_url()."images/default.png"; ?>">
                         <?php } ?> 
                            </div>
                          </div>

                                                 
                  <div class="box-body">
                    <div class="row">
                      <div class="col-md-2">
                        <button type="submit" class="btn btn-block btn-primary">Update Record</button>
                      </div>   
                      <div class="col-md-2">
                        <a href="<?php echo base_url(); ?>Company/"><button type="button" name="BankToMain" value="BankToMain" class="btn btn-block bg-orange">Back to Main</button></a>
                      </div>
                    </div>
                  </div>

                   </form>
                </div>
                
            </div>
          </div>
            <!-- /.main-content ends -->
<?php $this->load->view('includes/footer'); ?>