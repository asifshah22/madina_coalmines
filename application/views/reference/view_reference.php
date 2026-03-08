<?php 
    $this->load->view('includes/header');
    $this->load->view('includes/sidebar'); 
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <h1><i class="fa fa-chain"></i>&nbsp;Transportation</h1>
    </section>

  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">View Transportation</h3>
            </div>
              <div class="box-body">
                <div class="form-group">
		    <label for="FullName" class="col-sm-1 control-label" style="font-weight:600;">Transportation / Policy:</label> 
                   <div class="col-sm-4">
                       <?php echo $Reference->FullName; ?>
                  </div>
                </div>
              </div>
	      <div class="box-body">
                <div class="form-group">
                  <label for="ContactNumber" class="col-sm-1 control-label" style="font-weight:600;">Contact Number:</label> 
                   <div class="col-sm-4">
                    <?php echo $Reference->ContactNumber;?>
                  </div>
                </div>
              </div>
	      <div class="box-body">
                <div class="form-group">
                  <label for="Email" class="col-sm-1 control-label" style="font-weight:600;">Email:</label> 
                   <div class="col-sm-4">
                    <?php echo $Reference->Email;?>
                  </div>
                </div>
              </div>
	      <div class="box-body">
                <div class="form-group">
                  <label for="Address" class="col-sm-1 control-label" style="font-weight:600;">Address:</label> 
                   <div class="col-sm-4">
                    <?php echo $Reference->Address;?>
                  </div>
                </div>
              </div>
	      <!-- /.box-body -->
	      <div class="box-body">
               <div class="row">
		<div class='col-md-2'>
		 <a href="<?php echo base_url(); ?>Reference/AddReference" class="btn btn-block btn-primary">Add Record</a>
		</div>   
               <div class="col-md-2">
               <a href="<?php echo base_url(); ?>Reference/"><button type="button" name="BankToMain" value="BankToMain" class="btn btn-block bg-orange">Back to Main</button></a>
                </div>
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
<?php $this->load->view('includes/footer'); ?>