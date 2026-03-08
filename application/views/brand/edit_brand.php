<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-medkit"></i>&nbsp;Brands</h1>
    </section>
  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Brand</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php  $id = $GetBrandById->BrandId;   ?>
            <form role="form" id="ProductForm" class="form-horizontal" enctype="multipart/form-data" action='<?php echo base_url("Brand/SaveBrand/$id"); ?>' method="post"> 
                    <div class="box-body">
                      <div class="form-group">
                        <label for="BrandName" class="col-sm-1 control-label">Brand Name:</label>
                          <div class="col-sm-4">
                            <input type="text" name="BrandName" id="" class="form-control" value="<?php print $GetBrandById->BrandName; ?>">
                          </div>
                      </div><!-- /.form-group -->
                    </div>

              <div class="box-body">
               <div class="row">
                  <div class='col-md-2'>
                <button type="submit" class="btn btn-block btn-primary">Update Record</button>
              </div>
             <div class="col-md-2">
               <a href="<?php echo base_url(); ?>Brand/"><button type="button" name="BankToMain" value="BankToMain" class="btn btn-block btn-primary">Back to Main</button></a>
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