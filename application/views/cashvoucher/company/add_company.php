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
              <h3 class="box-title text-light-blue">Add Company</h3>
            </div>
            <!-- /.box-header -->
              <form enctype="multipart/form-data" class="form-horizontal" role="form" action="<?php echo base_url(); ?>Company/SaveCompany/" method="post">
                     <!-- /.row  starts-->
                     <div class="box-body">
                      <div class="row">
                       
                        <div style="border:0px solid;" class="col-md-12">
                          
                          <div class="form-group">
                          <label for="Designation" class="col-sm-1 control-label">Company Name:</label>
                          <div class="col-xs-4"><input type="text" name="CompanyName" id="form-field-1" class="form-control"/></div>
                          </div><!-- /.form-group -->

                          <div class="form-group">
                          <label for="Designation" class="col-sm-1 control-label">Address:</label>
                          <div class="col-xs-4"><input type="text" name="Address" id="form-field-1" class="form-control"/></div>
                          </div><!-- /.form-group -->

                          <div class="form-group">
                          <label for="Designation" class="col-sm-1 control-label">NTN:</label>
                          <div class="col-xs-4"><input type="text" name="NTN" id="form-field-1" class="form-control"/></div>
                          </div><!-- /.form-group -->

                          <div class="form-group">
                          <label for="Designation" class="col-sm-1 control-label">Fax No:</label>
                          <div class="col-xs-4"><input type="text" name="FaxNo" id="form-field-1" class="form-control"/></div>
                          </div><!-- /.form-group -->

                          <div class="form-group">
                          <label for="Designation" class="col-sm-1 control-label">Website:</label>
                          <div class="col-xs-4"><input type="text" name="Website" id="form-field-1" class="form-control"/></div>
                          </div><!-- /.form-group -->

                          <div class="form-group">
                          <label for="Designation" class="col-sm-1 control-label">Company Warranty:</label>
                          <div class="col-xs-4"><textarea name="CompanyWarranty" rows="4" cols="14" class="form-control"></textarea>
                          </div><!-- /.form-group -->
                        </div>

                          <div class="form-group">
                            <label for="Designation" class="col-sm-1 control-label">Company Logo:</label>
                            <div class="col-xs-4"><input type="file" name="CompanyLogo" id=""></div>
                          </div>

   <div class="box-body">
    <div class="row">
      <div class="col-md-2">
          <button type="submit" class="btn btn-block btn-primary">Save Record</button>
      </div>   
      <div class="col-md-2">
       <a href="<?php echo base_url(); ?>Employee/"><button type="button" name="BankToMain" value="BankToMain" class="btn btn-block bg-orange">Back to Main</button></a>
      </div>
     </div>
          </div> 
              </div>
            </form>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content --> 
  </div>
  <!-- /.content-wrapper -->           
<?php $this->load->view('includes/footer'); ?>