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
              <h3 class="box-title">Edit Packing</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php  $id = $GetProductGroupById->ProductGroupId;   ?>
            <form role="form" id="ProductForm" class="form-horizontal" enctype="multipart/form-data" action='<?php echo base_url("ProductGroup/SaveProductGroup/$id"); ?>' method="post"> 
              <div class="box-body">
                  
                <div class="form-group">
                  <label for="BrandName" class="col-sm-1 control-label">Category Name:</label>
                  <div class="col-sm-4">
                    <select name="CategoryId" class="form-control select2" required>
                     <option selected="selected">Select Category</option>
                     <?php foreach ($GetAllCategories as $row) { ?>
                      <option value="<?php  echo $row['CategoryId']; ?>"<?php if($GetProductGroupById->CategoryId == $row['CategoryId']) { echo "selected=selected"; } ?>><?php echo $row['CategoryName']; ?></option>
                     <?php } ?>
                  </select>
                  </div>
                </div>

                  <div class="form-group">
                    <label for="ProductName" class="col-sm-1 control-label">Packing Name:</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control" name="ProductGroupName" id="ProductGroupName" value="<?php echo $GetProductGroupById->ProductGroupName; ?>">
                    </div>
                  </div>

              <div class="box-body">
               <div class="row">
                  <div class='col-md-2'>
                <button type="submit" class="btn btn-block btn-primary">Update Record</button>
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
  <!-- /.content-wrapper -->
<?php $this->load->view('includes/footer'); ?>