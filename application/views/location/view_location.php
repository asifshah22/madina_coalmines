<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-user"></i>&nbsp;Location</h1>
    </section>

  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- form elements --> 
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title text-light-blue">View Location Details</h3>
            </div>
              
            <!-- /.box-header -->
            <div class="box-body no-padding">
            <form role="form" class="form-horizontal"> 

                    <div class="box-body">

                          <div class="form-group">
                            <label for="Designation" class="col-sm-1 control-label">Location Name:</label>
                            <div class="col-sm-4" style="padding-top:7px;"><?php print $GetLocation->LocationName; ?></div>
                          </div><!-- /.form-group -->

                          <div class="form-group">
                            <label for="Designation" class="col-sm-1 control-label">LocationType:</label>
                            <div class="col-sm-4" style="padding-top:7px;">
                              <?php if($GetLocation->LocationType == 1) { echo "Sale Point"; } ?>
                              <?php if($GetLocation->LocationType == 5) { echo "Storage Point"; } ?>
                              </div>
                          </div><!-- /.form-group -->

                          <div class="form-group">
                            <label for="Designation" class="col-sm-1 control-label">Address:</label>
                            <div class="col-sm-4" style="padding-top:7px;"><?php print $GetLocation->Address; ?></div>
                          </div><!-- /.form-group -->

                          <div class="form-group">
                            <label for="Designation" class="col-sm-1 control-label">Contact Number:</label>
                            <div class="col-sm-4" style="padding-top:7px;"><?php print $GetLocation->PhoneNo; ?></div>
                          </div><!-- /.form-group -->
                        <!-- /.col -->
                         
                      </div>
                      <!-- /.row -->
                          
  <div class="box-body">
    <div class="row">
      <div class="col-md-2">
       <a href="<?php echo base_url(); ?>Location/AddLocation" class="btn btn-block btn-primary">Add Record</a>
      </div>   
      <div class="col-md-2">
       <a href="<?php echo base_url(); ?>Location/"><button type="button" name="BankToMain" value="BankToMain" class="btn btn-block btn-primary">Back to Main</button></a>
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