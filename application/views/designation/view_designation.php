<?php 
    $this->load->view('includes/header');
    $this->load->view('includes/sidebar'); 
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <h1><i class="fa fa-black-tie"></i>&nbsp;Designation</h1>
    </section>

  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- form elements  --> 
          <div id="showresult">
          <div class="box box-info">
           <div class="box-header with-border">
            <h3 class="box-title">View Designation</h3>
           </div>
              
             <!-- /.box-header -->              
              <div class="box-body">
                <div class="form-group">
                  <label for="DesignationName" class="col-sm-1 control-label" style="font-weight:600;">Designation:</label>
                   <div class="col-sm-5" style="">
                       <?php echo $GetDesignation->DesignationName; ?>
                  </div>
                </div>
              </div>
	     
		<div class="box-body">
		<div class="row">
		  <div class="col-md-2">
		   <a href="<?php echo base_url(); ?>Designation/AddDesignation" class="btn btn-block btn-primary">Add Record</a>
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