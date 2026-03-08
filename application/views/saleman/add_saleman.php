<?php 
    $this->load->view('includes/header');
    $this->load->view('includes/sidebar'); 
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <h1><i class="fa fa-cube"></i>&nbsp;Saleman</h1>
    </section>

  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- form elements  --> 
          <div id="showresult">
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Add Saleman</h3>
            </div>
            <!-- /.box-header -->        
            <form role="form" class="form-horizontal"  action='<?php  echo base_url("Saleman/SaveSaleman"); ?>' method="post" id="userform"> 
  <!--          <form role="form" class="form-horizontal" id="userform" enctype="multipart/form-data" action="<?php // echo base_url(); ?>/Category/SaveCategory" method="post">--> 
              
              <div class="box-body">
                <div class="form-group">
                  <label for="SalemanName" class="col-sm-1 control-label">Saleman Name:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="SalemanName" id="SalemanName" placeholder="Enter Saleman Name" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="ContactNumber" class="col-sm-1 control-label">Contact #:</label>
                   <div class="col-sm-4">
                  <input type="text" class="form-control" name="ContactNumber" id="ContactNumber" placeholder="Enter Contact #" required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="Address" class="col-sm-1 control-label">Address:</label>
                   <div class="col-sm-4">
                   <textarea id="Address" name="Address" rows="4" cols="55"></textarea>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="col-sm-4">
                <input type="hidden" class="form-control"  name="ChartOfAccountCode" id="ChartOfAccountCode" value="<?php echo $COA_Code;?>" readonly="readonly">
                <input type="hidden" class="form-control"  name="ChartOfAccountCategoryId" id="ChartOfAccountCategoryId" value="<?php echo $Category_Id;?>" >
                <input type="hidden" class="form-control"  name="ChartOfAccountControlId" id="ChartOfAccountControlId" value="<?php echo $ControlCode_Id;?>" >
                </div>
              </div>

              <div class="form-group">
                  <div class="col-sm-4">
                      <input type="hidden" class="form-control"  name="ChartOfAccountTitle" id="ChartOfAccountTitle" required="required" readonly="readonly">
                  </div>
                </div>
              <!-- /.box-body -->
	      <div class="box-body">
               <div class="row">
		<div class='col-md-2'>
		   <button type='submit' class='btn  btn-block btn-primary bg-primary' value='SaveRecord'>Save Record</button>
		  </div>   
                <div class="col-md-2">
                   <a href="<?php echo base_url(); ?>Saleman/"><button type="button" name="BankToMain" value="BankToMain" class="btn btn-block btn-primary">Back to Main</button></a>
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
  <script>
$(function(){
        $('#SalemanName').focus( function() {
            $("#ChartOfAccountTitle").val('');
        });
        $('#SalemanName').blur( function() {
           var CustomerName = $(this).val();
           $("#ChartOfAccountTitle").val(CustomerName)
        });
    
    
});

</script> 
<?php $this->load->view('includes/footer'); ?>