<?php
$this->load->view("includes/header");
$this->load->view("includes/sidebar");                
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-building"></i>&nbsp;Location</h1>
    </section>
  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Update Location</h3>
	    </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" id="ProductForm" class="form-horizontal" enctype="multipart/form-data" action="<?php echo base_url(); ?>/Location/UpdateLocation/<?php echo $GetLocation->LocationId; ?>" method="post"> 
		<input type="hidden" name="LocationId" value="<?php echo $GetLocation->LocationId; ?>">
              <div class="box-body">                  
                <div class="form-group">
                  <label for="BrandName" class="col-sm-1 control-label">Location Name:</label>
                  <div class="col-sm-4">
	            <input type="text" name="LocationName" class="form-control" required="required" placeholder="Enter Location Name" value="<?php echo $GetLocation->LocationName; ?>">
                  </div>
                </div>

                <div class="form-group">
                <label for="BrandName" class="col-sm-1 control-label">Location Type:</label>
                  <div class="col-md-4">
                    <select name="LocationType" id="" class="form-control" required="required">
                    <option value="0">Select Location Type</option>
                    <option value="1" <?php if($GetLocation->LocationType == 1) { echo "selected=selected"; } ?> > Sale Point</option>
                      <option value="5"<?php if($GetLocation->LocationType == 5) { echo "selected=selected"; } ?>> Storage Point</option>
                    </select>
                  </div>
                </div>

		<div class="form-group">
                  <label for="Address" class="col-sm-1 control-label">Address:</label>
                  <div class="col-sm-4">
	            <input type="text" name="Address" class="form-control" required="required" placeholder="Enter Address" value="<?php echo $GetLocation->Address; ?>">
                  </div>
                </div>


		<div class="form-group">
                  <label for="PhoneNo" class="col-sm-1 control-label">Mobile Number:</label>
                  <div class="col-sm-4">
	            <input type="text" name="PhoneNo" class="form-control" placeholder="Enter Mobile Number" value="<?php echo $GetLocation->PhoneNo; ?>">
                  </div>
                </div>

	      </div>
              <!-- /.box-body -->
              <div class="box-body">
               <div class="row">
                <div class='col-md-2'>
                <button type="submit" class="btn btn-block btn-primary">Update Record</button>
                </div>
             <div class="col-md-2">
               <a href="<?php echo base_url(); ?>Location/"><button type="button" name="BankToMain" value="BankToMain" class="btn btn-block btn-primary">Back to Main</button></a>
                </div>
               </div>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
       </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
<!-- ./wrapper -->
<?php $this->load->view("includes/footer"); ?>