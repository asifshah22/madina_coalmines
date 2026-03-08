<?php 
    $this->load->view('includes/header');
    $this->load->view('includes/sidebar'); 
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
              <h3 class="box-title text-light-blue">Add Employee</h3>
            </div>
            <!-- /.box-header -->
            <form role="form" class="form-horizontal" id="employeeform" enctype="multipart/form-data" action='<?php echo base_url("Employee/InsertEmployee"); ?>' method="post"> 
              <div class="box-body">
              
                <div class="form-group">
                  <label for="Designation" class="col-sm-1 control-label">Designation:</label>
                  <div class="col-sm-4">
                  <select name="DesignationId" class="form-control" required="required">
                     <option selected="selected" value="">Select Designation</option>
                     <?php foreach ($GetAllDesignations as $Record) { ?>
                     <option value="<?php  echo $Record['DesignationId']; ?>"><?php echo $Record['DesignationName']; ?></option>
                     <?php } ?>
                  </select>
                  </div>
                  <span></span>
                 </div>


                <div class="form-group">
                  <label for="Employee Type" class="col-sm-1 control-label">Employee Type:</label>                 
                  <div class="col-sm-4">
                  <select name="EmployeeType" class="form-control" required="required">
                      <option value="" selected="selected">Select Employee Type</option>
                     <option value="2">Admin</option>
                     <option value="3">Employee</option>
                  </select>
                  </div>
                  <span></span>
                 </div>

                <div class="form-group">
                  <label for="Gender" class="col-sm-1 control-label">Gender:</label>                 
                  <div class="col-sm-4">
                  <select name="Gender" class="form-control" required="required">
                      <option value="" selected="selected">Select Gender</option>
                     <option value="1">Male</option>
                     <option value="2">Female</option>
                  </select>
                  </div>
                  <span></span>
                 </div>

                 <div class="form-group">
                  <label for="EmployeeName" class="col-sm-1 control-label">Employee Name:</label>
                  <div class="col-sm-4">
                      <input type="text" class="form-control" name="EmployeeName" id="EmployeeName" required>
                  </div>
                  <span><?php echo form_error('EmployeeName'); ?> </span>
                </div>

                <div class="form-group">
                  <label for="EmailAddress" class="col-sm-1 control-label">Email Address:</label>
                  <div class="col-sm-4">
		      <input type="text" class="form-control" name="EmailAddress" autocomplete="off" required="required">
                  </div>
                    <span><?php echo form_error('Email'); ?> </span>
                </div>

                <div class="form-group">
                  <label for="Password" class="col-sm-1 control-label">Password:</label>
                  <div class="col-sm-4">
		      <input type="password" class="form-control" name="Password" required="required">
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="CellNo" class="col-sm-1 control-label">Cell Number:</label>
                  <div class="col-sm-4">
                  <input type="number" class="form-control" name="CellNo" required="required">
                  </div>
                    <span><?php echo form_error('CellNo'); ?> </span>
                </div>

              <div class="form-group">
                <label for="JoiningDate" class="col-sm-1 control-label">Joining Date:</label>
                <div class="col-sm-4">
                  <input class="form-control" name="JoiningDate" id="datepicker1" type="text" value="<?php if($this->input->post('JoiningDate')!= "") print $this->input->post('JoiningDate'); else print  date("m/d/Y"); ?>">
                </div>
              </div>

                <div class="form-group">
                  <label for="HomeAddress" class="col-sm-1 control-label">Address:</label>
                  <div class="col-sm-4">
                  <input type="text" class="form-control" name="HomeAddress">
                  </div>
                    <span><?php echo form_error('OtherContactNumber'); ?> </span>
                </div>
     
   <div class="box-body">
		<div class="row">
		  <div class="col-md-2">
		      <button type="submit" class="btn btn-block btn-primary">Save Record</button>
		  </div>	 
		  <div class="col-md-2">
		   <a href="<?php echo base_url(); ?>Employee/"><button type="button" name="BankToMain" value="BankToMain" class="btn btn-block btn-primary">Back to Main</button></a>
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

<script type="text/javascript">
  $(function(){

    $('#EmployeeName').bind('keyup blur',function(){ 
    var EmployeeName = $(this);
    EmployeeName.val(EmployeeName.val().replace(/[^a-z A-Z" "]/g,'') ); }
  );
    
  })
</script>