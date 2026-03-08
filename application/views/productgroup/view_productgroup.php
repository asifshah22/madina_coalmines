<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-medkit"></i>&nbsp;Packing</h1>
    </section>
  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">View Packing</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" class="form-horizontal" enctype="multipart/form-data" action='<?php echo base_url("Product/SaveProduct"); ?>' method="post"> 
              <div class="box-body">
                <div class="form-group">
                  <label for="CategoryName" class="col-sm-1 control-label">Category:</label>
                  <div class="col-sm-4">
                  <?php echo $GetProductGroupById->CategoryName?>
                  </div>
                </div>

                <div class="form-group">
                  <label for="ProductName" class="col-sm-1 control-label">Packing:</label>
                  <div class="col-sm-3">
                 <?php echo $GetProductGroupById->ProductGroupName?>
                  </div>
                </div>

              <!-- /.box-body -->
              <div class="box-body">
               <div class="row">
    <div class='col-md-2'>
     <a href="<?php echo base_url(); ?>ProductGroup/AddProductGroup" class="btn btn-block btn-primary">Add Record</a>
    </div>   
               <div class="col-md-2">
               <a href="<?php echo base_url(); ?>ProductGroup/"><button type="button" name="BankToMain" value="BankToMain" class="btn btn-block btn-primary">Back to Main</button></a>
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
<?php $this->load->view('includes/footer'); ?>