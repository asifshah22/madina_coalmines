<?php 
$this->load->view("includes/header");
$this->load->view("includes/sidebar");
?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>Vendor</h1>
    </section>

  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- form elements --> 
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Add New Vendor</h3>
            </div>
            <!-- /.box-header -->
           <!-- <div class="box-body no-padding">-->
            <form role="form" class="form-horizontal" id="vendorform" enctype="multipart/form-data" action="<?php echo base_url(); ?>Vendor/SaveVendor" method="post"> 
              <div class="box-body">
             	
                <div class="form-group">
                  <label for="VendorName" class="col-sm-1 control-label">Vendor Name:</label>
                  <div class="col-sm-4">
                  <input type="text" class="form-control" name="VendorName" id="VendorName" placeholder="Enter Vendor Name" autocomplete="off">
                  </div>	
                </div>
                  
                <div class="form-group">
                  <label for="ContactName" class="col-sm-1 control-label">Contact Name:</label>
                  <div class="col-sm-4">
                  <input type="text" class="form-control"  name="ContactName" id="ContactName" placeholder="Enter Contact Name" autocomplete="off">
                  </div>
                </div>
                  
                <div class="form-group">
                  <label for="Email" class="col-sm-1 control-label">Email:</label>
                  <div class="col-sm-4">
                  <input type="email" class="form-control" name="Email" id="Email" placeholder="Enter Email" autocomplete="off">
                  </div>
                </div>
                <div class="form-group">
                  <label for="PhoneNo" class="col-sm-1 control-label">Phone No.:</label>
                  <div class="col-sm-4">
                  <input type="text" class="form-control"  name="PhoneNo" id="PhoneNo" placeholder="Enter Phone Number" autocomplete="off">
                  </div>
                </div>
                <div class="form-group">
                  <label for="CellNo" class="col-sm-1 control-label">Cell No.:</label>
                  <div class="col-sm-4">
                  <input type="text" class="form-control"  name="CellNo" id="CellNo" placeholder="Enter Cell Number" autocomplete="off">
                  </div>
                </div>
                <div class="form-group">
                  <label for="Address" class="col-sm-1 control-label">Address:</label>
                  <div class="col-sm-4">
                  <input type="text" class="form-control"  name="Address" id="Address" placeholder="Enter Address" autocomplete="off">
                  </div>
                </div>
                <div class="form-group">
                  <label for="NTN" class="col-sm-1 control-label">NTN:</label>
                  <div class="col-sm-4">
                  <input type="text" class="form-control"  name="NTN" id="NTN" placeholder="Enter NTN" autocomplete="off">
                  </div>
                </div>
                  
               <div class="form-group">
                  <div class="col-sm-4">
                  <input type="hidden" class="form-control"  name="ChartOfAccountCode" id="ChartOfAccountCode" value="<?php echo $COA_Code;?>" >
                  <input type="hidden" class="form-control"  name="ChartOfAccountCategoryId" id="ChartOfAccountCategoryId" value="<?php echo $Category_Id;?>" >
                  <input type="hidden" class="form-control"  name="ChartOfAccountControlId" id="ChartOfAccountControlId" value="<?php echo $ControlCode_Id;?>" >
                  <input type="hidden" class="form-control"  name="ChartOfAccountTitle" id="ChartOfAccountTitle">
                  </div>
                </div>           
          
          
            </div> 
            
              <!-- /.box-body -->
			   <div class="box-body">
    <div class="row">
      <div class="col-md-2">
        <button type="submit" name="AddVendorRecordBtn" value="AddVendorRecord" id="AddRecord" class="btn btn-block btn-primary">Save Record</button>
      </div>
      <div class="col-md-2">
        <a href="<?php echo base_url(); ?>SalesReturn/"><button type="button" name="" value="cancelUpdate" class="btn btn-block btn-primary">Back to Main</button></a>
      </div>
    </div>
        </div>

            </form>
            
            
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    
    
  </div>
  <!-- /.content-wrapper -->

<script>
//CustomerName

$(function(){
        $('#VendorName').focus( function() {
            $("#ChartOfAccountTitle").val('');
        });

        $('#VendorName').blur( function() {
           var CustomerName = $(this).val();
           $("#ChartOfAccountTitle").val(CustomerName)
        });
    
    
});

</script>    
<?php $this->load->view("includes/footer"); ?>
