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
              <h3 class="box-title">View Company Name Details</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
            <form role="form" class="form-horizontal" enctype="multipart/form-data" action='<?php echo base_url("Area/SaveArea/?id=".$GetArea->id); ?>' method="post"> 
              <div class="box-body">
                <div class="form-group">
                  <label for="CustomerName" class="col-sm-1 control-label">Company Name:</label>
                  <div class="col-sm-4">
                      <?php echo $GetArea->Area_name; ?>
                  </div>
                </div>
              </div>
	      <div class="box-body">
		<div class="row">
      <div class="col-md-2">
        <a href="<?php echo base_url(); ?>Area/AddArea"><button type="button" name="cancelForm" value="cancelUpdate" class="btn btn-block bg-primary">Add Record</button></a>
      </div>
		  <div class="col-md-2">
		    <a href="<?php echo base_url(); ?>Area/"><button type="button" name="cancelForm" value="cancelUpdate" class="btn btn-block btn-primary">Back to main</button></a>
		  </div>
		</div>  
            </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
<script>
//CustomerName

$(function(){
        $('#CustomerName').focus( function() {
            $("#ChartOfAccount").val(<?php echo $COA_Code?>);
        });

        $('#CustomerName').blur( function() {
           var COA_txt = $("#ChartOfAccount").val();
           var CustomerName = $(this).val();
           $("#ChartOfAccount").val(COA_txt+'-'+CustomerName)
        });
    
    
});

</script>    
<?php $this->load->view("includes/footer"); ?>