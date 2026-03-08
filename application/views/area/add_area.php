<?php
$this->load->view("includes/header");
$this->load->view("includes/sidebar");
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="glyphicon glyphicon-user"></i>&nbsp;Company Name</h1>
    </section>

  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- form elements -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Add New Company Name</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
            <form role="form" class="form-horizontal" enctype="multipart/form-data" action="<?php echo base_url(); ?>Area/SaveArea" method="post">
              <div class="box-body">

                <div class="form-group">
                  <label for="AreaName" class="col-sm-1 control-label">Company Name:</label>
                  <div class="col-sm-4">
		                <input type="text" class="form-control" name="Area_name" id="Area_name" required="required" autocomplete="off">
                  </div>
                </div>
                
		</div>
		<div class="box-body">
		<div class="row">
		  <div class="col-md-2">
		    <button type="submit" name="submitForm" value="AddRecord" class="btn btn-block btn-primary">Save Record</button>
		  </div>
		  <div class="col-md-2">
		    <a href="<?php echo base_url(); ?>Area/"><button type="button" name="cancelForm" value="cancelUpdate" class="btn btn-block btn-primary">Back to Main</button></a>
		  </div>
		</div>  
               </div>
	      </form>
            </div>
	    </div>
            <!-- /.box-body -->
          </div>
	   </div>
          <!-- /.box -->
         </section>  
      </div> 
<script>
$(function(){
        $('#CustomerName').focus( function() {
            $("#ChartOfAccountTitle").val('');
        });
        $('#CustomerName').blur( function() {
           var CustomerName = $(this).val();
           $("#ChartOfAccountTitle").val(CustomerName)
        });
    
    
});

</script>    
<?php $this->load->view("includes/footer"); ?>