<?php
$this->load->view("includes/header");
$this->load->view("includes/sidebar");                
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-medkit"></i>&nbsp;ProductRates</h1>
    </section>
  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">View Product Rate</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" class="form-horizontal" enctype="multipart/form-data" action='<?php echo base_url("ProductRates/SaveProductRate"); ?>' method="post"> 
              <div class="box-body">
                <div class="form-group">
                  <label for="CategoryName" class="col-sm-1 control-label">Category:</label>
                  <div class="col-sm-4">
                 <?php echo $GetProductRate->CategoryName?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="ProductName" class="col-sm-1 control-label">Product:</label>
                  <div class="col-sm-4">
                  <?php echo $GetProductRate->ProductName?>
                  </div>
                </div>
                <?php 
                if($GetProductRate->CustomerId != 0){
                ?>
                <div class="form-group">
                  <label for="CustomerName" class="col-sm-1 control-label">Customer Name:</label>
                  <div class="col-sm-4">
                 <?php echo $GetProductRate->CustomerName?>
                  </div>
                </div>
                <?php }
                if($GetProductRate->VendorId != 0){
                ?>
                <div class="form-group">
                  <label for="VendorName" class="col-sm-1 control-label">Vendor Name:</label>
                  <div class="col-sm-4">
                 <?php echo $GetProductRate->VendorName?>
                  </div>
                </div>
                <?php } ?>
                <div class="form-group">
                  <label for="MinimumStock" class="col-sm-1 control-label">Rate:</label>
                  <div class="col-sm-4">
                    <?php echo $GetProductRate->Rate?>
                  </div>
                </div>
                <div class="form-group">
                  <label for="Note" class="col-sm-1 control-label">Note:</label>
                  <div class="col-sm-4">
                    <?php echo $GetProductRate->Note?>
                  </div>
                </div>
                
              </div>
              <!-- /.box-body -->
              <div class="box-body">
               <div class="row">
    <div class='col-md-2'>
     <a href="<?php echo base_url(); ?>ProductRates/AddProductRate" class="btn btn-block btn-primary">Add Record</a>
    </div>   
               <div class="col-md-2">
               <a href="<?php echo base_url(); ?>ProductRates/"><button type="button" name="BankToMain" value="BankToMain" class="btn btn-block bg-orange">Back to Main</button></a>
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