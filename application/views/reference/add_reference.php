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
          <!-- form elements  --> 
          <div id="showresult">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Add Transportation</h3>
            </div>
            <!-- /.box-header -->        
            <form role="form" class="form-horizontal" action='<?php echo base_url("Reference/SaveReference"); ?>' method="post" id="userform"> 
              
              <div class="box-body">
                <div class="form-group">
                  <label for="WarrantyTitle" class="col-sm-1 control-label">Name:</label>
                   <div class="col-sm-4">
		    <input type="text" class="form-control" name="FullName" required="required">
                  </div>
                </div>
              </div>
              <div class="box-body">
                <div class="form-group">
                  <label for="ContactNumber" class="col-sm-1 control-label">Contact Number:</label>
                   <div class="col-sm-4">
		    <input type="text" class="form-control" name="ContactNumber">
                  </div>
                </div>
              </div>
	     <div class="box-body">
                <div class="form-group">
                  <label for="Email" class="col-sm-1 control-label">Email:</label>
                   <div class="col-sm-4">
		    <input type="text" class="form-control" name="Email">
                  </div>
                </div>
              </div>
	      <div class="box-body">
                <div class="form-group">
                  <label for="Address" class="col-sm-1 control-label">Address:</label>
                   <div class="col-sm-4">
		    <input type="text" class="form-control" name="Address">
                  </div>
                </div>
              </div>
	     
              <!-- /.box-body -->
	      <div class="box-body">
               <div class="row">
		<div class='col-md-2'>
		   <button type="submit" class="btn btn-block btn-primary">Save Record</button>
		  </div>   
                <div class="col-md-2">
                   <a href="<?php echo base_url(); ?>Reference/"><button type="button" name="BankToMain" value="BankToMain" class="btn btn-block bg-orange">Back to Main</button></a>
                </div>
               </div>
              </div>
            </form>
          </div>
          <!-- /.box -->
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php $this->load->view('includes/footer'); ?>