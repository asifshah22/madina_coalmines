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
              <h3 class="box-title">Add New Location</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" id="ProductForm" class="form-horizontal" enctype="multipart/form-data" action="<?php echo base_url(); ?>/Location/SaveLocation" method="post"> 
              <div class="box-body">

                <div class="form-group">
                  <label for="BrandName" class="col-sm-1 control-label">Location Name:</label>
                  <div class="col-sm-4">
	                  <input type="text" name="LocationName" class="form-control" required="required" placeholder="Enter Location Name">
                  </div>
                </div>

              <div class="form-group">
                <label for="BrandName" class="col-sm-1 control-label">Location Type:</label>
                  <div class="col-md-4">
                    <select name="LocationType" id="" class="form-control" required="required">
                      <option value="0">Select Location Type</option>
                      <option value="1"> Sale Point</option>
                      <option value="5"> Storage Point</option>
                    </select>
                  </div>
                </div>

		            <div class="form-group">
                  <label for="Address" class="col-sm-1 control-label">Address:</label>
                  <div class="col-sm-4">
	                   <input type="text" name="Address" class="form-control" required="required" placeholder="Enter Address">
                  </div>
                </div>
		
		            <div class="form-group">
                  <label for="PhoneNo" class="col-sm-1 control-label">Contact:</label>
                  <div class="col-sm-4">
	                  <input type="text" name="PhoneNo" class="form-control" placeholder="Enter Contact Number">
                  </div>
                </div>

              <div class="box-body">
                <div class="row">
                  <div class="col-md-2">
                    <button type="submit" class="btn btn-block btn-primary">Save Record</button>
                  </div>
                  <div class="col-md-2">
                    <a href="<?php echo base_url(); ?>Location/"><button type="button" name="BankToMain" value="BankToMain" class="btn btn-block btn-primary">Back to Main</button></a>
                  </div>
                </div>
              </div> 
            </form>
          </div>
       </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
<?php $this->load->view("includes/footer"); ?>