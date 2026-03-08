<?php 
    $this->load->view('includes/header');
    $this->load->view('includes/sidebar'); 
   
    $EmployeeId = $GetEmployee->EmployeeId; 
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-user"></i>&nbsp;Employee</h1>
    </section>

  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- form elements --> 
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title text-light-blue">View Employee</h3>
            </div>
              
            <!-- /.box-header -->
            <div class="box-body no-padding">
            <form role="form" class="form-horizontal"> 
              <div class="box-body">
              
                <div class="form-group">
                  <label for="Designation" class="col-sm-1 control-label">Designation:</label>                 
                  <div class="col-sm-4" style="padding-top:7px;">
                    <?php echo $GetEmployee->DesignationName; ?></div>
                  <span></span>
                 </div>

                <div class="form-group">
                  <label for="EmployeeName" class="col-sm-1 control-label">Employee Name:</label>
                  <div class="col-sm-4" style="padding-top:7px;">
                     <?php echo $GetEmployee->EmployeeName; ?>
                  </div>
                  <span><?php echo form_error('EmployeeName'); ?></span>
                </div>

                <div class="form-group">
                  <label for="EmployeeType" class="col-sm-1 control-label">EmployeeType:</label>
                  <div class="col-sm-4" style="padding-top:7px;">
                  <?php
                   if($GetEmployee->EmployeeType == '2') { echo "Admin"; }
                   if($GetEmployee->EmployeeType == '3') { echo "Employee"; }
                  ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="Gender" class="col-sm-1 control-label">Gender:</label>
                  <div class="col-sm-4" style="padding-top:7px;">
                  <?php
                   if($GetEmployee->Gender == 1) { echo "Male"; }
                   if($GetEmployee->Gender == 2) { echo "Female"; }
                  ?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="Email" class="col-sm-1 control-label">Email Address:</label>
                  <div class="col-sm-4" style="padding-top:7px;">
                    <?php echo $GetEmployee->EmailAddress; ?>
                  </div>
                    <span><?php echo form_error('Email'); ?> </span>
                </div>

                <div class="form-group">
                  <label for="CellNo" class="col-sm-1 control-label">Cell Number:</label>
                  <div class="col-sm-4" style="padding-top:7px;">
                  <?php echo $GetEmployee->CellNo; ?>
                  </div>
                    <span><?php echo form_error('CellNo'); ?> </span>
                </div>

                <div class="form-group">
                <label for="JoiningDate" class="col-sm-1 control-label">Joining Date:</label>
                <div class="col-sm-4" style="padding-top:7px;">
                <div class="input-group date">
                  <?php echo date('d/m/Y', strtotime($GetEmployee->JoiningDate)); ?>
                </div>
                </div>
                </div>

                <div class="form-group">
                  <label for="Address" class="col-sm-1 control-label">Home Address:</label>
                  <div class="col-sm-4" style="padding-top:7px;">
                    <?php echo $GetEmployee->HomeAddress; ?>
                  </div>
                </div>
		  
		<div class="box-body">
		<div class="row">
		  <div class="col-md-2">
		   <a href="<?php echo base_url(); ?>Employee/AddEmployee" class="btn btn-block btn-primary">Add Record</a>
		  </div>	 
		  <div class="col-md-2">
		   <a href="<?php echo base_url(); ?>Employee/"><button type="button" name="BankToMain" value="BankToMain" class="btn btn-block btn-primary">Back to Main</button></a>
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