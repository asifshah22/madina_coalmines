<?php 
    $this->load->view('includes/header');
    $this->load->view('includes/sidebar'); 
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <h1><i class="fa fa-cube"></i>&nbsp;Designation</h1>
    </section>

  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- form elements  --> 
          <div id="showresult">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Add Designation</h3>
            </div>
            <!-- /.box-header -->        
            <form role="form" class="form-horizontal"  action='<?php echo base_url("Designation/SaveDesignation"); ?>' method="post" id="userform"> 
              <div class="box-body">
                <div class="form-group">
                  <label for="CategoryName" class="col-sm-1 control-label">Designation:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="DesignationName" required>
                  </div>
                </div>
              </div>
               
		<div class="box-body">
		<div class="row">
		  <div class="col-md-2">
		      <button type="submit" class="btn btn-block btn-primary">Save Record</button>
		  </div>	 
		  <div class="col-md-2">
		   <a href="<?php echo base_url(); ?>Designation/"><button type="button" name="BankToMain" value="BankToMain" class="btn btn-block btn-primary">Back to Main</button></a>
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
  </div>
<?php $this->load->view('includes/footer'); ?>