<?php 
$this->load->view("includes/header");
$this->load->view("includes/sidebar");
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Vendor</h1>
    </section>

  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- form elements --> 
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">View Vendor Details</h3>
            </div>
            <!-- /.box-header -->
           <!-- <div class="box-body no-padding">-->
            <?php echo "<font style=color:#00468E; font-weight:bold text-align:center;>".$this->session->flashdata('record_update')."</font>"; ?>
            <form role="form" class="form-horizontal" > 
         
              <div class="box-body">
             	
                <div class="form-group">
                  <label for="VendorName" class="col-sm-1 control-label">Vendor Name:</label>
                  <div class="col-sm-4" style="padding: 7px;">
                    <?php echo $GetVendor->VendorName;?>
                  </div>	
                </div>
                <div class="form-group">
                  <label for="ContactName" class="col-sm-1 control-label">Contact Name:</label>
                  <div class="col-sm-4" style="padding: 7px;">
                    <?php echo $GetVendor->ContactName;?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="Email" class="col-sm-1 control-label">Email:</label>
                  <div class="col-sm-4" style="padding: 7px;">
                    <?php echo $GetVendor->Email;?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="PhoneNo" class="col-sm-1 control-label">Phone No.:</label>
                  <div class="col-sm-4" style="padding: 7px;">
                    <?php echo $GetVendor->PhoneNo;?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="CellNo" class="col-sm-1 control-label">Cell No.:</label>
                  <div class="col-sm-4" style="padding: 7px;">
                    <?php echo $GetVendor->CellNo;?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="Address" class="col-sm-1 control-label">Address:</label>
                  <div class="col-sm-4" style="padding: 7px;">
                    <?php echo $GetVendor->Address;?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="NTN" class="col-sm-1 control-label">NTN:</label>
                  <div class="col-sm-4" style="padding: 7px;">
                    <?php echo $GetVendor->NTN;?>
                  </div>
                </div>
                  
            
              </div>
              <!-- /.box-body -->
			   <div class="box-body">
      <div class="col-md-2">
        <a href="<?php echo base_url(); ?>Vendor/AddVendor"><button type="button" name="cancelForm" value="cancelUpdate" class="btn btn-block bg-primary">Add Record</button></a>
      </div>
      <div class="col-md-2">
        <a href="<?php echo base_url(); ?>Vendor/"><button type="button" name="cancelForm" value="cancelUpdate" class="btn btn-block btn-primary">Back to Main</button></a>
      </div>
    </div>
            
            
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    
    
  </div>
  <!-- /.content-wrapper -->

<?php $this->load->view("includes/footer"); ?>