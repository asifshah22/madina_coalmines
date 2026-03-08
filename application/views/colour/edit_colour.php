<?php $this->load->view('includes/header'); ?>
<?php $this->load->view('includes/sidebar'); ?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><i class="fa fa-medkit"></i>&nbsp;Colours</h1>
    </section>
  <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Edit Colour</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <?php  $id = $GetColourById->ColourId;   ?>
            <form role="form" id="ProductForm" class="form-horizontal" enctype="multipart/form-data" action='<?php echo base_url("Colour/SaveColour/$id"); ?>' method="post"> 
                    <div class="box-body">
                      <div class="form-group">
                        <label for="ColourName" class="col-sm-1 control-label">Colour Name:</label>
                          <div class="col-sm-4">
                            <input type="text" name="ColourName" id="" class="form-control" value="<?php print $GetColourById->ColourName; ?>">
                          </div>
                      </div><!-- /.form-group -->
                    </div>

              <div class="box-body">
               <div class="row">
                  <div class='col-md-2'>
                <button type="submit" class="btn btn-block btn-primary">Update Record</button>
              </div>
             <div class="col-md-2">
               <a href="<?php echo base_url(); ?>Colour/"><button type="button" name="BankToMain" value="BankToMain" class="btn btn-block btn-primary">Back to Main</button></a>
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