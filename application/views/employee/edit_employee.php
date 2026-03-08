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
              <h3 class="box-title text-light-blue">Update Employee</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
            <form role="form" class="form-horizontal" id="employeeform" enctype="multipart/form-data" action='<?php echo base_url("Employee/UpdateEmployee/$EmployeeId"); ?>' method="post"> 
              
              <div class="box-body">
              
                <div class="form-group">
                  <label for="EmployeeName" class="col-sm-1 control-label">Name:</label>
                  <div class="col-sm-4">
                      <input type="text" class="form-control" name="EmployeeName" id="EmployeeName" value="<?php echo $GetEmployee->EmployeeName?>" required>
                  </div>
                  <span><?php echo form_error('EmployeeName'); ?> </span>
                </div>
                <div class="form-group">
                  <label for="Designation" class="col-sm-1 control-label">Designation:</label>                 
                  <div class="col-sm-4">
                  <select name="DesignationId" class="form-control select2" required>
                     <?php foreach ($GetAllDesignations as $Record) { ?>
                     <option value="<?php  echo $Record['DesignationId']; ?>" <?php if($GetEmployee->DesignationId == $Record['DesignationId'] ) { echo "selected"; } ?>><?php echo $Record['DesignationName']; ?></option>
                     <?php } ?>
                   </select>
                  </div>
                  <span></span>
                 </div>

                <div class="form-group">
                  <label for="Gender" class="col-sm-1 control-label">Gender:</label>                 
                  <div class="col-sm-4">
                  <select name="Gender" class="form-control" required>
                      <option value="0" selected="selected">Select Gender</option>
                     <option value="<?php  echo $GetEmployee->Gender; ?>" <?php if($GetEmployee->Gender == '1') { echo "selected"; }?>>Male</option>
                     <option value="<?php  echo $GetEmployee->Gender; ?>" <?php if($GetEmployee->Gender == '2') { echo "selected"; }?>>Female</option>
                  </select>
                  </div>
                  <span></span>
                 </div>  

                <div class="form-group">
                  <label for="EmployeeType" class="col-sm-1 control-label">Employee Type:</label>                 
                  <div class="col-sm-4">
                  <select name="EmployeeType" class="form-control" required>
                      <option value="">Select Employee Type</option>
                     <option value="2" <?php if($GetEmployee->EmployeeType == 2) { echo "selected"; }?>>Admin</option>
                     <option value="3" <?php if($GetEmployee->EmployeeType == 3) { echo "selected"; }?>>Employee</option>
                  </select>
                  </div>
                  <span></span>
                 </div>  

                <div class="form-group">
                  <label for="EmailAddress" class="col-sm-1 control-label">Email Address:</label>
                  <div class="col-sm-4">
                  <input type="text" class="form-control" name="EmailAddress" placeholder="Enter Email Address" value="<?php echo $GetEmployee->EmailAddress; ?>" autocomplete="off">
                  </div>
                    <span><?php echo form_error('Email'); ?> </span>
                </div>
                <div class="form-group">
                  <label for="Password" class="col-sm-1 control-label">Password:</label>
                  <div class="col-sm-4">
                  <input type="Password" class="form-control" name="Password" id="Password" value="<?php echo $GetEmployee->Password; ?>" autocomplete="off">
                  </div>
                </div>
                <div class="form-group">
                <label for="JoiningDate" class="col-sm-1 control-label">Joining Date:</label>
                <div class="col-sm-4">
                 <input class="form-control" name="JoiningDate" id="datepicker1" type="text"  value="<?php echo date('d/m/Y', strtotime($GetEmployee->JoiningDate)); ?>">
                </div>
              </div>
                <div class="form-group">
                  <label for="CellNo" class="col-sm-1 control-label">Cell Number:</label>
                  <div class="col-sm-4">
                  <input type="number" class="form-control" name="CellNo" id="CellNo" value="<?php echo $GetEmployee->CellNo?>" placeholder="Enter Cell Number">
                  </div>
                    <span><?php echo form_error('CellNo'); ?> </span>
                </div>
                <div class="form-group">
                  <label for="HomeAddress" class="col-sm-1 control-label">Home Address:</label>
                  <div class="col-sm-4">
                  <input type="text" class="form-control" name="HomeAddress" value="<?php echo $GetEmployee->HomeAddress?>" placeholder="Enter Home Address">
                  </div>
                </div>

                <div class="box-body">
		              <div class="row">
		                <div class="col-md-2">
		                  <button type="submit" class="btn btn-block btn-primary">Update Record</button>
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